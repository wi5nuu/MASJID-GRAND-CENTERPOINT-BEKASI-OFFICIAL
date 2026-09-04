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
        $page->update($request->only('meta_title','meta_description','meta_keywords','og_image'));
        return back()->with('success', 'Pengaturan SEO berhasil disimpan.');
    }
}
