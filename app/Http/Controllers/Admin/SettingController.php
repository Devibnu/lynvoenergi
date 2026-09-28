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
        return back()->with('error', 'Silakan gunakan tombol Simpan Pengaturan di bawah.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'seo_title' => 'nullable|string|max:70',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string|max:255',
            'seo_og_title' => 'nullable|string|max:70',
            'seo_og_description' => 'nullable|string|max:160',
            'seo_twitter_title' => 'nullable|string|max:70',
            'seo_twitter_description' => 'nullable|string|max:160',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,svg,webp,ico|max:512',
            'seo_og_image' => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'seo_twitter_image' => 'nullable|image|mimes:jpg,png,webp|max:2048',
            'hero_phone' => 'required|string|min:9|max:15|regex:/^[0-9\-\+\s]+$/',
        ]);

        // --- LOGO ---
        if ($request->hasFile('site_logo') && $request->file('site_logo')->isValid()) {
            $file = $request->file('site_logo');
            Storage::disk('public')->makeDirectory('logo');
            $old = Setting::getValue('site_logo');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $file->storeAs('logo', 'logo_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path, 'label' => 'Logo Website']);
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
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $path, 'label' => 'Favicon Website']);
        }

        // --- SEO OG IMAGE ---
        if ($request->hasFile('seo_og_image') && $request->file('seo_og_image')->isValid()) {
            $file = $request->file('seo_og_image');
            Storage::disk('public')->makeDirectory('seo');
            $old = Setting::getValue('seo_og_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $file->storeAs('seo', 'og_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
            Setting::updateOrCreate(['key' => 'seo_og_image'], ['value' => $path, 'label' => 'SEO OG Image']);
        }

        // --- SEO TWITTER IMAGE ---
        if ($request->hasFile('seo_twitter_image') && $request->file('seo_twitter_image')->isValid()) {
            $file = $request->file('seo_twitter_image');
            Storage::disk('public')->makeDirectory('seo');
            $old = Setting::getValue('seo_twitter_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $file->storeAs('seo', 'twitter_' . time() . '.' . $file->getClientOriginalExtension(), 'public');
            Setting::updateOrCreate(['key' => 'seo_twitter_image'], ['value' => $path, 'label' => 'SEO Twitter Image']);
        }

        // --- TEXT SETTINGS ---
        $skip = ['_token', '_method', 'site_logo', 'site_favicon', 'seo_og_image', 'seo_twitter_image'];
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
