<?php

namespace App\Services;

use App\Models\Donasi;
use App\Models\Kontak;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * Agregator notifikasi panel admin.
 * Sumber: jamaah menunggu persetujuan, pesan kontak belum dibaca,
 * dan donasi menunggu konfirmasi.
 */
class AdminNotification
{
    public static function pendingUsersCount(): int
    {
        return User::whereHas('role', fn ($q) => $q->where('name', 'jamaah'))
            ->whereNull('approved_at')
            ->count();
    }

    public static function unreadKontakCount(): int
    {
        return Kontak::unread()->count();
    }

    public static function pendingDonasiCount(): int
    {
        return Donasi::pending()->count();
    }

    public static function counts(): array
    {
        $users = self::pendingUsersCount();
        $kontak = self::unreadKontakCount();
        $donasi = self::pendingDonasiCount();

        return [
            'users' => $users,
            'kontak' => $kontak,
            'donasi' => $donasi,
            'total' => $users + $kontak + $donasi,
        ];
    }

    /**
     * Daftar notifikasi terbaru, terurut dari yang paling baru.
     */
    public static function items(int $limit = 8): Collection
    {
        $items = collect();

        $pendingUsers = User::whereHas('role', fn ($q) => $q->where('name', 'jamaah'))
            ->whereNull('approved_at')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get(['id', 'name', 'unit_no', 'created_at']);
        foreach ($pendingUsers as $u) {
            $items->push([
                'type' => 'user',
                'icon' => 'user',
                'color' => 'amber',
                'text' => "Pendaftar jamaah baru: {$u->name}" . ($u->unit_no ? " (Unit {$u->unit_no})" : ''),
                'time' => $u->created_at?->diffForHumans(),
                'at' => $u->created_at?->toIso8601String(),
                'url' => route('admin.users.index'),
            ]);
        }

        $unreadKontak = Kontak::unread()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get(['id', 'nama', 'subjek', 'created_at']);
        foreach ($unreadKontak as $k) {
            $items->push([
                'type' => 'kontak',
                'icon' => 'mail',
                'color' => 'blue',
                'text' => "Pesan baru dari {$k->nama}" . ($k->subjek ? ": {$k->subjek}" : ''),
                'time' => $k->created_at?->diffForHumans(),
                'at' => $k->created_at?->toIso8601String(),
                'url' => route('admin.kontak.index'),
            ]);
        }

        $pendingDonasi = Donasi::pending()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get(['id', 'nama', 'jumlah', 'created_at']);
        foreach ($pendingDonasi as $d) {
            $items->push([
                'type' => 'donasi',
                'icon' => 'heart',
                'color' => 'green',
                'text' => 'Donasi menunggu konfirmasi dari ' . ($d->nama ?: 'Hamba Allah') . ' (' . number_format((float) $d->jumlah, 0, ',', '.') . ')',
                'time' => $d->created_at?->diffForHumans(),
                'at' => $d->created_at?->toIso8601String(),
                'url' => route('admin.donasi.index'),
            ]);
        }

        return $items->sortByDesc('at')->values()->take($limit);
    }

    public static function feed(int $limit = 8): array
    {
        return [
            'counts' => self::counts(),
            'items' => self::items($limit),
        ];
    }

    /**
     * "Tandai semua dibaca" — menandai seluruh pesan kontak sebagai dibaca.
     * Persetujuan jamaah & konfirmasi donasi diselesaikan lewat aksi masing-masing.
     */
    public static function markAllKontakRead(): int
    {
        return Kontak::unread()->update(['is_read' => true, 'read_at' => now()]);
    }
}
