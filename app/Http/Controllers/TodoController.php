<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\CheckList;
use App\Models\ParentList;
use App\Models\TodoSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TodoController extends Controller
{
    public function index()
    {
        $sessions = TodoSession::where('user_id', auth()->id())->get();
        return view('pages.dashboard', compact('sessions'));
    }

    public function storeSession(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return DB::transaction(function () use ($request) {
            $imageName = null;
            if ($request->hasFile('img')) {
                $imageName = time() . '.' . $request->img->extension();
                $request->img->move(public_path('storage/images'), $imageName);
            }

            $session = TodoSession::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'description' => $request->description,
                'img' => $imageName ? 'storage/images/' . $imageName : null,
            ]);

            foreach (['To Do', 'Doing', 'Done'] as $title) {
                ParentList::create([
                    'session_id' => $session->id,
                    'title' => $title,
                ]);
            }

            return redirect()->route('projects.show', ['id' => $session->id]);
        });
    }

    public function show($id)
    {
        $todoSession = TodoSession::with('parentLists')->findOrFail($id);
        return view('pages.projectSession', compact('todoSession'));
    }

    public function detail(TodoSession $TodoSession)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Project',
            'data' => [
                'id' => $TodoSession->id,
                'title' => $TodoSession->title,
                'img' => $TodoSession->img,
                'description' => $TodoSession->description,
            ],
        ]);
    }

    public function updateSession(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        return DB::transaction(function () use ($request, $id) {
            $session = TodoSession::findOrFail($id);

            $imgPath = $session->img;
            if ($request->hasFile('img')) {
                if ($imgPath && file_exists(public_path($imgPath))) {
                    unlink(public_path($imgPath));
                }

                $imageName = time() . '.' . $request->img->extension();
                $request->img->move(public_path('storage/images'), $imageName);
                $imgPath = 'storage/images/' . $imageName;
            }

            $session->update([
                'title' => $request->title,
                'description' => $request->description,
                'img' => $imgPath,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session updated successfully.',
                'data' => $session,
            ]);
        });
    }

    public function deleteSession($id)
    {
        DB::transaction(function () use ($id) {
            $session = TodoSession::where('id', $id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $session->parentLists->each(function ($parentList) {
                $parentList->cards->each(function ($card) {
                    $card->checklists()->delete();
                    $card->delete();
                });
                $parentList->delete();
            });

            $session->delete();
        });

        return response()->json(['message' => 'Session and all related data deleted successfully']);
    }

    public function storeParent(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:todo_sessions,id',
        ]);

        $parentList = ParentList::create([
            'session_id' => $request->session_id,
            'title' => 'New List',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Parent list created successfully',
            'data' => $parentList,
        ]);
    }

    public function detailParent(ParentList $ParentList)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Parent List',
            'data' => [
                'id' => $ParentList->id,
                'title' => $ParentList->title,
            ],
        ]);
    }

    public function updateParent(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $parentList = ParentList::findOrFail($id);

        if ($parentList->title === $request->title) {
            return response()->json([
                'success' => false,
                'message' => 'No changes detected.',
            ], 400);
        }

        $parentList->update(['title' => $request->title]);

        return response()->json([
            'success' => true,
            'message' => 'Parent list updated successfully.',
            'data' => $parentList,
        ]);
    }

    public function deleteParent($id)
    {
        try {
            $userSessionIds = TodoSession::where('user_id', auth()->id())->pluck('id');
            $parentList = ParentList::where('id', $id)->whereIn('session_id', $userSessionIds)->first();

            if (!$parentList) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parent list not found or permission denied',
                ], 404);
            }

            $parentList->delete();

            return response()->json([
                'success' => true,
                'message' => 'Parent list and related cards deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting parent list: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function storeCard(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'parent_id' => 'required|exists:parent_lists,id',
            ]);

            return DB::transaction(function () use ($request, $validated) {
                if ($request->hasFile('img')) {
                    $imageName = time() . '.' . $request->img->extension();
                    $request->img->move(public_path('storage/images/cards'), $imageName);
                    $validated['img'] = $imageName;
                }

                $card = Card::create($validated);
                $card->checkAndUpdateStatus();
                $card->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Card created successfully',
                    'card' => $card,
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create card: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function showCard(Card $card)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail Card',
            'data' => [
                'id' => $card->id,
                'title' => $card->title,
                'description' => $card->description,
                'due_date' => $card->due_date,
                'is_due_checked' => $card->is_due_checked,
                'img' => $card->img,
            ],
        ]);
    }

    public function updateCard(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'nullable|date',
                'is_due_checked' => 'boolean',
                'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            ]);

            return DB::transaction(function () use ($request, $validated, $id) {
                $card = Card::findOrFail($id);

                if ($request->hasFile('img')) {
                    $imageName = time() . '.' . $request->img->extension();
                    $request->img->move(public_path('storage/images/cards'), $imageName);
                    $validated['img'] = $imageName;
                }

                $card->fill($validated);
                $card->checkAndUpdateStatus();
                $card->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Card updated successfully',
                    'card' => $card->fresh(),
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update card: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteCard($id)
    {
        try {
            $card = Card::findOrFail($id);

            if ($card->img && file_exists(public_path('storage/images/cards/' . $card->img))) {
                unlink(public_path('storage/images/cards/' . $card->img));
            }

            $card->delete();

            return response()->json([
                'success' => true,
                'message' => 'Card deleted successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting card: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Tambahkan method ini di TodoController
    public function moveCard(Request $request, $id)
    {
        try {
            $request->validate([
                'new_parent_id' => 'required|exists:parent_lists,id',
            ]);

            $card = Card::find($id);

            // Validasi card exists
            if (!$card) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Card not found',
                    ],
                    404,
                );
            }

            $oldParentId = $card->parent_id;
            $card->update(['parent_id' => $request->new_parent_id]);

            return response()->json([
                'success' => true,
                'message' => 'Card moved successfully',
                'card' => $card->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Error moving card: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
