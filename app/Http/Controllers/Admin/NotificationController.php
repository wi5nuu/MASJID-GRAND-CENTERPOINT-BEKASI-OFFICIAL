<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Feed JSON untuk polling realtime (badge sidebar + dropdown topbar).
     */
    public function feed(Request $request)
    {
        return response()->json(AdminNotification::feed(8));
    }

    /**
     * Tandai semua pesan kontak sebagai dibaca.
     */
    public function readAll(Request $request)
    {
        $count = AdminNotification::markAllKontakRead();

        if ($request->expectsJson()) {
            return response()->json(array_merge(
                ['marked' => $count],
                AdminNotification::feed(8)
            ));
        }

        return back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }
}
