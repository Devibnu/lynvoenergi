<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Handle logo file upload separately
        if ($request->hasFile('site_logo')) {
            $request->validate([
                'site_logo' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            ]);

            // Delete old logo if exists
            $oldLogo = \App\Models\Setting::where('key', 'site_logo')->value('value');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Store new logo
            $logoFile = $request->file('site_logo');
            $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
            $logoPath = $logoFile->storeAs('logo', $logoName, 'public');

            // Save path to database
            \App\Models\Setting::where('key', 'site_logo')->update(['value' => $logoPath]);
        }

        // Handle favicon file upload separately
        if ($request->hasFile('site_favicon')) {
            $request->validate([
                'site_favicon' => 'file|mimes:ico,png,svg,jpg,jpeg,webp|max:512',
            ]);

            // Delete old favicon if exists
            $oldFavicon = \App\Models\Setting::where('key', 'site_favicon')->value('value');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // Store new favicon
            $faviconFile = $request->file('site_favicon');
            $faviconName = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
            $faviconPath = $faviconFile->storeAs('logo', $faviconName, 'public');

            // Save path to database
            \App\Models\Setting::where('key', 'site_favicon')->update(['value' => $faviconPath]);
        }

        // Handle text-based settings
        $excludedKeys = ['_token', '_method', 'site_logo', 'site_favicon'];
        foreach ($request->except($excludedKeys) as $key => $value) {
            \App\Models\Setting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
