<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class KelolaHeroSectionController extends Controller
{
    private $dataPath = 'landing_page.json';

    public function index()
    {
        $data = [];
        if (Storage::exists($this->dataPath)) {
            $json = Storage::get($this->dataPath);
            $data = json_decode($json, true) ?? [];
        }
        return view('admin.kelola-hero-section', compact('data'));
    }

    public function update(Request $request)
    {
        $rules = [
            'hero_title' => 'required|string|max:100',
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'profile_title' => 'required|string|max:100',
            'section_text' => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
        $messages = [
            'hero_title.required' => 'Judul hero section tidak boleh kosong',
            'hero_title.max' => 'Judul hero section terlalu panjang',
            'hero_image.image' => 'Format gambar yang diunggah tidak sesuai',
            'hero_image.mimes' => 'Format gambar yang diunggah tidak sesuai',

            'profile_title.required' => 'Judul profile tidak boleh kosong',
            'profile_title.max' => 'Judul profile terlalu panjang',

            'section_text.required' => 'Paragraf profile tidak boleh kosong',
            'section_text.max' => 'Paragraf profile terlalu panjang',

            'profile_image.image' => 'Format gambar yang diunggah tidak sesuai',
            'profile_image.mimes' => 'Format gambar yang diunggah tidak sesuai',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $data = [];
        if (Storage::exists($this->dataPath)) {
            $data = json_decode(Storage::get($this->dataPath), true) ?? [];
        }

        $existingHeroImage = $data['hero_image'] ?? null;
        $isSame = false;
        if (!$request->hasFile('hero_image')) {
            $isSame = false;
        } else {
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

        $data['hero_title'] = $request->input('hero_title');
        $data['profile_title'] = $request->input('profile_title');
        $data['section_text'] = $request->input('section_text');
        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('landing', 'public');
            $newFilename = basename($path);
            if ($existingHeroImage && $existingHeroImage !== $newFilename && Storage::disk('public')->exists('landing/' . $existingHeroImage)) {
                Storage::disk('public')->delete('landing/' . $existingHeroImage);
            }
            $data['hero_image'] = $newFilename;
        } else {
            $data['hero_image'] = $existingHeroImage;
        }
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
        Storage::put($this->dataPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        return Redirect::back()->with('status', 'Konten Berhasil Diubah.');
    }
}
?>