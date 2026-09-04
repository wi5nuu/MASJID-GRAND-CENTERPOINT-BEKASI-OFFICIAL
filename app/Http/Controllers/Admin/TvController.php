<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TvDisplay;
use App\Models\JadwalShalat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TvController extends Controller
{
    public function index() { return view('admin.tv.index', ['displays' => TvDisplay::orderBy('urutan')->paginate(20)]); }
    public function create() { return view('admin.tv.form'); }

    public function store(Request $request)
    {
        $request->validate(['tipe' => 'required|string', 'konten' => 'required|string']);
        $data = $request->only('tipe','judul','konten','durasi','urutan');
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('file')) $data['file'] = $request->file('file')->store('tv', 'public');
        TvDisplay::create($data);
        return redirect()->route('admin.tv.index')->with('success', 'Konten TV berhasil ditambahkan.');
    }

    public function edit(TvDisplay $tv) { return view('admin.tv.form', compact('tv')); }

    public function update(Request $request, TvDisplay $tv)
    {
        $data = $request->only('tipe','judul','konten','durasi','urutan');
        $data['is_active'] = $request->boolean('is_active', true);
        if ($request->hasFile('file')) {
            if ($tv->file) Storage::disk('public')->delete($tv->file);
            $data['file'] = $request->file('file')->store('tv', 'public');
        }
        $tv->update($data);
        return redirect()->route('admin.tv.index')->with('success', 'Konten TV berhasil diperbarui.');
    }

    public function destroy(TvDisplay $tv) { $tv->delete(); return back()->with('success', 'Konten TV dihapus.'); }
    public function show(TvDisplay $tv) { return view('admin.tv.show', compact('tv')); }

    public function display()
    {
        $shalat   = JadwalShalat::whereDate('tanggal', today())->first();

        // Jika tidak ada data hari ini, auto-fetch dari API
        if (!$shalat) {
            \App\Http\Controllers\Admin\ShalatController::fetchToday();
            $shalat = JadwalShalat::whereDate('tanggal', today())->first();
        }

        $displays = TvDisplay::where('is_active', true)->orderBy('urutan')->get();

        return view('tv.display', compact('shalat', 'displays'));
    }

    public function layout()
    {
        $settings = [
            'tv_col_kiri'        => \App\Models\Setting::get('tv_col_kiri',        '1.1'),
            'tv_col_tengah'      => \App\Models\Setting::get('tv_col_tengah',       '1.8'),
            'tv_col_kanan'       => \App\Models\Setting::get('tv_col_kanan',        '1.1'),
            'tv_header_height'   => \App\Models\Setting::get('tv_header_height',    '64'),
            'tv_footer_height'   => \App\Models\Setting::get('tv_footer_height',    '36'),
            'tv_show_kiri'       => \App\Models\Setting::get('tv_show_kiri',        '1'),
            'tv_show_kanan'      => \App\Models\Setting::get('tv_show_kanan',       '1'),
            'tv_show_footer'     => \App\Models\Setting::get('tv_show_footer',      '1'),
            'tv_show_shalat_jum' => \App\Models\Setting::get('tv_show_shalat_jum',  '1'),
            'tv_show_wifi'       => \App\Models\Setting::get('tv_show_wifi',        '1'),
            'tv_show_donasi'     => \App\Models\Setting::get('tv_show_donasi',      '1'),
            'tv_show_countdown'  => \App\Models\Setting::get('tv_show_countdown',   '1'),
            'tv_show_kegiatan'   => \App\Models\Setting::get('tv_show_kegiatan',    '1'),
            'stream_mode'        => \App\Models\Setting::get('stream_mode',         'youtube'),
            'stream_is_live'     => \App\Models\Setting::get('stream_is_live',      '0'),
            'stream_label'       => \App\Models\Setting::get('stream_label',        'Live Masjid'),
            'stream_camera_name' => \App\Models\Setting::get('stream_camera_name',  ''),
            'tv_live_url'        => \App\Models\Setting::get('tv_live_url',         ''),
            'wifi_ssid'          => \App\Models\Setting::get('wifi_ssid',           'MasjidGCP'),
            'wifi_password'      => \App\Models\Setting::get('wifi_password',       'masjidgcp2024'),
            'donasi_rekening'    => \App\Models\Setting::get('donasi_rekening',     "Bank Syariah Indonesia\nNo. Rek: 1234567890\na.n. Masjid Grand Centerpoint"),
            'running_text'       => \App\Models\Setting::get('running_text',        'Selamat datang di Masjid Grand Centerpoint Bekasi.'),
        ];

        return view('admin.tv.layout', compact('settings'));
    }

    public function layoutUpdate(\Illuminate\Http\Request $request)
    {
        $keys = [
            'tv_col_kiri','tv_col_tengah','tv_col_kanan',
            'tv_header_height','tv_footer_height',
            'tv_show_kiri','tv_show_kanan','tv_show_footer',
            'tv_show_shalat_jum','tv_show_wifi','tv_show_donasi',
            'tv_show_countdown','tv_show_kegiatan',
            'stream_mode','stream_is_live','stream_label',
            'stream_camera_name','tv_live_url',
            'wifi_ssid','wifi_password','donasi_rekening','running_text',
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                \App\Models\Setting::set($key, $request->input($key), 'tv');
            }
        }

        // Checkbox yang tidak terkirim saat unchecked
        foreach (['tv_show_kiri','tv_show_kanan','tv_show_footer','tv_show_shalat_jum','tv_show_wifi','tv_show_donasi','tv_show_countdown','tv_show_kegiatan','stream_is_live'] as $cb) {
            \App\Models\Setting::set($cb, $request->has($cb) ? '1' : '0', 'tv');
        }

        return back()->with('success', 'Layout TV berhasil disimpan.');
    }
}
