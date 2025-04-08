<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogAktivitasHelper;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::where('id', 1)->first();
        $page = 'Halaman Settings';

        $context = [
            'page' => $page,
            'settings' => $settings,
        ];
        return view('admin.settings.index', $context);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name_website' => ['required', 'max:40'],
            'tagline' => ['required'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg,gif', 'max:2048'],
        ], [
            'name_website.required' => 'Nama Website Harus Diisi!',
            'name_website.max' => 'Maksimal 40 karakter!',
            'tagline.required' => 'Tagline Harus Diisi!',
            'logo.image' => 'File harus berupa gambar!',
            'logo.mimes' => 'Format yang diperbolehkan: jpeg, png, jpg, gif, svg!',
            'logo.max' => 'Ukuran maksimal 2MB!',
        ]);

        $settings = Settings::findOrFail($id);

        $old_name = $settings->name_website;
        $old_tagline = $settings->tagline;
        $old_logo = $settings->logo;

        $settings->name_website = $request->name_website;
        $settings->tagline = $request->tagline;

        if ($request->hasFile('logo')) {
            if ($settings->logo && Storage::exists('public/img/' . $settings->logo)) {
                Storage::delete('public/img/' . $settings->logo);
            }

            $file = $request->file('logo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('img', $fileName, 'public');
        
            $settings->logo = $fileName;
        }

        $settings->save();

        $keterangan = "Mengubah settings:\n" .
                      "- Nama Website: \"$old_name\" → \"{$settings->name_website}\"\n" .
                      "- Tagline: \"$old_tagline\" → \"{$settings->tagline}\"";

        if ($request->hasFile('logo')) {
            $keterangan .= "\n- Logo: \"$old_logo\" → \"{$settings->logo}\"";
        }

        LogAktivitasHelper::catat('Update', 'Settings', $keterangan);

        return redirect()->route('settings.index')->with('update', 'Settings Berhasil Diperbarui!');
    }
}
