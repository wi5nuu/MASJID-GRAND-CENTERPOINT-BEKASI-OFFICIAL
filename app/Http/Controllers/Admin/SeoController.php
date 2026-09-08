<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoPage;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    public function index() { return view('admin.seo.index', ['pages' => \App\Models\SeoPage::all()]); }

    public function update(Request $request, \App\Models\SeoPage $page)
    {
        $request->validate([
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords'    => 'nullable|string|max:255',
            'og_image'         => 'nullable|string|max:255',
        ]);
        $page->update($request->only('meta_title','meta_description','meta_keywords','og_image'));
        return back()->with('success', 'Pengaturan SEO berhasil disimpan.');
    }
}
