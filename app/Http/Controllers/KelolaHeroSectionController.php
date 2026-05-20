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
            'hero_title'   => 'nullable|string|max:100',
            'hero_subtitle'=> 'nullable|string',
            'section_text'   => 'required|string',
            'hero_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile_title'=> 'nullable|string|max:255',
            'profile_image'=> 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
        $messages = [
            'hero_title.max' => 'Judul hero section terlalu panjang',
            'section_text.required' => 'Paragraf konten tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        // Load existing data
        $data = [];
        if (Storage::exists($this->dataPath)) {
            $data = json_decode(Storage::get($this->dataPath), true) ?? [];
        }

        // Determine current hero image filename
        $existingHeroImage = $data['hero_image'] ?? null;
        $isSame = false;
        // If no new file uploaded, keep existing image (no duplicate check needed)
        if (!$request->hasFile('hero_image')) {
            $isSame = false; // allow keeping the same image
        } else {
            // If a new file is uploaded, compare its content with existing image (if any)
            if ($existingHeroImage && Storage::disk('public')->exists('landing/' . $existingHeroImage)) {
                $existingFullPath = Storage::disk('public')->path('landing/' . $existingHeroImage);
                if (file_exists($existingFullPath)) {
                    $uploadedHash = md5_file($request->file('hero_image')->getPathname());
                    $existingHash = md5_file($existingFullPath);
                    if ($uploadedHash === $existingHash) {
                        $isSame = true;
                    }
                }
            }
        }

        if ($isSame) {
            $validator->errors()->add('hero_image', 'Gambar tidak boleh sama');
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Update text fields
        $data['hero_title']    = $request->input('hero_title');
        $data['hero_subtitle'] = $request->input('hero_subtitle');
        $data['section_text'] = $request->input('section_text');
        $data['profile_title']  = $request->input('profile_title');
        // Handle hero image upload
        if ($request->hasFile('hero_image')) {
            // Store new image
            $path = $request->file('hero_image')->store('landing', 'public');
            $newFilename = basename($path);
            // Delete old image if it exists and is different
            if ($existingHeroImage && $existingHeroImage !== $newFilename && Storage::disk('public')->exists('landing/' . $existingHeroImage)) {
                Storage::disk('public')->delete('landing/' . $existingHeroImage);
            }
            $data['hero_image'] = $newFilename;
        } else {
            // No new upload – keep existing filename
            $data['hero_image'] = $existingHeroImage;
        }
        // Handle profile image upload
        $existingProfileImage = $data['profile_image'] ?? null;
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('landing', 'public');
            $newProfileFilename = basename($path);
            if ($existingProfileImage && $existingProfileImage !== $newProfileFilename && Storage::disk('public')->exists('landing/' . $existingProfileImage)) {
                Storage::disk('public')->delete('landing/' . $existingProfileImage);
            }
            $data['profile_image'] = $newProfileFilename;
        } else {
            $data['profile_image'] = $existingProfileImage;
        }
        // Save JSON
        Storage::put($this->dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return Redirect::back()->with('status', 'Konten Berhasil Diubah.');
    }
}
?>
