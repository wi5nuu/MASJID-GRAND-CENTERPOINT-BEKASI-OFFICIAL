<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $allowed = [
            'site_name', 'site_tagline', 'site_description', 'site_email', 'site_phone',
            'site_address', 'site_maps', 'site_footer', 'site_whatsapp', 'site_instagram',
            'site_facebook', 'site_youtube', 'site_logo', 'site_favicon',
            'contact_email', 'contact_phone', 'contact_address',
            'meta_title', 'meta_description', 'meta_keywords', 'og_image',
            'donasi_rekening', 'wifi_ssid', 'wifi_password',
            'running_text', 'event_ticket_enabled',
        ];

        $data = $request->only($allowed);

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }
        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
