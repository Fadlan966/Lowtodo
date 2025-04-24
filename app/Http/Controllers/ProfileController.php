<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;
use Hash;


class ProfileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.profile');
    }

    /**
     * Store the updated profile information.
     *
     * @return response()
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'confirm_password' => 'required_with:password|same:password',
            'avatar' => 'image',
        ]);

        $input = $request->all();

        // Proses upload avatar
        if ($request->hasFile('avatar')) {
            $avatarName = time() . '.' . $request->avatar->getClientOriginalExtension();
            $request->avatar->move(public_path('avatars'), $avatarName);

            $input['avatar'] = $avatarName;
        } else {
            unset($input['avatar']);
        }

        // Proses update password jika diisi
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        } else {
            unset($input['password']);
        }

        // Update data user
        auth()->user()->update($input);

        // Log aktivitas
        Activity::create([
            'user_id' => auth()->id(),
            'title' => 'Updated profile',
        ]);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Profile updated successfully.');
    }

    public function activities()
    {
        $activities = Activity::where('user_id', auth()->id())
            ->latest()
            ->take(10) // bisa sesuaikan jumlahnya
            ->get();

        return view('pages.profile', compact('activities'));
    }

    public function destroy($id)
    {
        $activity = Activity::where('user_id', auth()->id())->findOrFail($id);
        $activity->delete();

        return back()->with('success_activity', 'Activity deleted successfully.');
    }
}
