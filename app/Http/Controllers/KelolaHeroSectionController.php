<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class KelolaHeroSectionController extends Controller
{
    // Path to JSON data file
    private $dataPath = 'landing_page.json';

    /**
     * Show the landing page management form.
     */
    public function index()
    {
        $data = [];
        if (Storage::exists($this->dataPath)) {
            $json = Storage::get($this->dataPath);
            $data = json_decode($json, true) ?? [];
        }
        return view('admin.kelola-hero-section', compact('data'));
    }

    /**
     * Handle form submission to update landing page content.
     */
    public function update(Request $request)
    {
        $rules = [
            'hero_title'   => 'nullable|string|max:255',
            'hero_subtitle'=> 'nullable|string',
            'section_text' => 'nullable|string',
            'hero_image'   => 'nullable|image|max:2048',
            'profile_title'=> 'nullable|string|max:255',
            'profile_image'=> 'nullable|image|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        // Load existing data
        $data = [];
        if (Storage::exists($this->dataPath)) {
            $data = json_decode(Storage::get($this->dataPath), true) ?? [];
        }
        // Update text fields
        $data['hero_title']    = $request->input('hero_title');
        $data['hero_subtitle'] = $request->input('hero_subtitle');
        $data['section_text']   = $request->input('section_text');
        $data['profile_title']  = $request->input('profile_title');
        // Handle image upload
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('public/landing');
            // store returns path like public/landing/xxxx.jpg; we keep only filename
            $filename = basename($path);
            $data['hero_image'] = $filename;
        }
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('public/landing');
            $filename = basename($path);
            $data['profile_image'] = $filename;
        }
        // Save JSON
        Storage::put($this->dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return Redirect::back()->with('status', 'Konten Berhasil Diubah.');
    }
}
?>
