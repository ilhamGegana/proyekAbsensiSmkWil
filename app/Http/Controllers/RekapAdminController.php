<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapAdminController extends Controller
{
    public function index(Request $request)
    {
        // Awalnya kosong, nanti diisi hasil filter
        $data = [];

        return view('admin.rekap.index', compact('data'));
    }

    public function download(Request $request)
    {
        // Placeholder untuk download PDF
        return "Fitur download PDF akan dibuat di sini.";
    }
}
