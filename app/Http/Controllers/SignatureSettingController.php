<?php

namespace App\Http\Controllers;


use App\Models\SignatureSetting;
use Illuminate\Http\Request;

class SignatureSettingController extends Controller
{
    public function edit()
    {
        $setting = SignatureSetting::first();
        return view('admin.signature_settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'threshold' => 'required|integer|min:1|max:100',
        ]);

        $setting = SignatureSetting::first();
        $setting->update(['threshold' => $request->threshold]);

        return redirect()->back()->with('success', 'Threshold berhasil diperbarui.');
    }
}
