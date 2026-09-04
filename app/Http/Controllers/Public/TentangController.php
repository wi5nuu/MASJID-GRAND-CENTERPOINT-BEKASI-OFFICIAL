<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use App\Models\Setting;

class TentangController extends Controller
{
    public function index()
    {
        $pengurusList = Pengurus::active()->get();
        return view('public.tentang', compact('pengurusList'));
    }
}
