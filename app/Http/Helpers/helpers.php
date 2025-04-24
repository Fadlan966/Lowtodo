<?php

use App\Models\Card;
/**
 * Convert boolean is_due_checked status to readable text
 *
 * @param bool|null $isChecked
 * @param string $doneText
 * @param string $dueText
 * @return string
 */
function status_text($status)
{
    switch ($status) {
        case Card::STATUS_COMPLETED:
            return 'Completed';
        case Card::STATUS_LATE:
            return 'Late';
        case Card::STATUS_PENDING:
        default:
            return 'Pending';
    }
}

/**
 * Get badge HTML based on status
 *
 * @param string $status
 * @return string
 */
function status_badge($status)
{
    $classes = [
        Card::STATUS_COMPLETED => 'bg-green-100 text-green-800',
        Card::STATUS_LATE => 'bg-red-100 text-red-800',
        Card::STATUS_PENDING => 'bg-yellow-100 text-yellow-800'
    ];

    return '<span class="px-2 py-1 rounded-full text-xs font-medium ' . $classes[$status] . '">' . status_text($status) . '</span>';
}
