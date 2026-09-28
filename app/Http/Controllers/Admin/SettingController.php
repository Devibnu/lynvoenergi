<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function upload(Request $request)
    {
        // This is kept just in case but we'll merge logic to update()
        return back()->with('error', 'Silakan gunakan tombol Simpan Pengaturan di bawah.');
    }

    public function update(Request $request)
    {
        // --- LOGO ---
        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {
            $file = $request->file('site_logo');
            Storage::disk('public')->makeDirectory('logo');
            $old = Setting::getValue('site_logo');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $file->storeAs('logo', 'logo_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $path, 'label' => 'Logo Website']
            );
        }

        // --- FAVICON ---
        if ($request->hasFile('site_favicon') && $request->file('site_favicon')->isValid()) {
            $file = $request->file('site_favicon');
            Storage::disk('public')->makeDirectory('logo');
            $old = Setting::getValue('site_favicon');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $file->storeAs('logo', 'favicon_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $path, 'label' => 'Favicon Website']
            );
        }

        // --- TEXT SETTINGS ---
        $skip = ['_token', '_method', 'site_logo', 'site_favicon'];
        foreach ($request->except($skip) as $key => $value) {
            if ($value !== null && $value !== '') {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'label' => ucwords(str_replace('_', ' ', $key))]
                );
            }
        }

        return back()->with('success', 'Pengaturan berhasil disimpan!');
    }
}
