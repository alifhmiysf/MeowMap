<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CatSpotting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class CatSpottingController extends Controller
{
    
public function index(Request $request)
{
    $query = CatSpotting::with('user:id,name')
        ->where('status', 'approved');

    if ($request->filled('latitude') && $request->filled('longitude')) {
        $request->validate([
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        // Filter radius geografis dapat ditambahkan nanti.
    }

    return response()->json(
        $query->latest()->paginate(15)
    );
}


    public function show(Request $request, CatSpotting $catSpotting)
    {
        abort_unless(
            $catSpotting->status === 'approved' ||
            $catSpotting->user_id === $request->user()?->id,
            404
        );

        return response()->json(['data' => $catSpotting]);
    }


    
private function getDistrict(float $latitude, float $longitude): ?string
{
    $cacheKey = 'meowmap_district_' . md5(
        round($latitude, 5) . ',' . round($longitude, 5)
    );

    // Gunakan cache hanya jika sebelumnya berhasil mendapatkan kecamatan.
    $cachedDistrict = Cache::get($cacheKey);

    if (is_string($cachedDistrict) && trim($cachedDistrict) !== '') {
        return $cachedDistrict;
    }

    try {
        $response = Http::acceptJson()
            ->withHeaders([
                'User-Agent' => 'MeowMap/1.0 (Laravel reverse geocoding)',
            ])
            ->timeout(10)
            ->get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'geocodejson',
                'lat' => $latitude,
                'lon' => $longitude,
                'addressdetails' => 1,
                'zoom' => 14,
                'accept-language' => 'id',
            ]);

        if (!$response->successful()) {
            Log::warning('Reverse geocoding MeowMap gagal.', [
                'status' => $response->status(),
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]);

            return null;
        }

        $district = $response->json(
            'features.0.properties.geocoding.district'
        );

        if (!is_string($district) || trim($district) === '') {
            Log::warning('Nama kecamatan tidak ditemukan.', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'response' => $response->json(),
            ]);

            return null;
        }

        $district = trim($district);

        // Cache hanya hasil yang berhasil ditemukan.
        Cache::put($cacheKey, $district, now()->addDays(30));

        return $district;
    } catch (\Throwable $exception) {
        Log::warning('Gagal menentukan kecamatan laporan MeowMap.', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'error' => $exception->getMessage(),
        ]);

        return null;
    }
}


    public function store(Request $request)
{
    $data = $request->validate([
        'description' => [
            'required',
            'string',
            'min:3',
            'max:1000',
        ],
        'latitude' => [
            'required',
            'numeric',
            'between:-90,90',
        ],
        'longitude' => [
            'required',
            'numeric',
            'between:-180,180',
        ],
        'photo' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'report_type' => [
            'required',
            'in:lost,found,pet,adoption,sale',
        ],
    ]);

    $photoPath = $request->file('photo')
        ->store('cat-spottings', 'public');

    unset($data['photo']);

    // Tentukan kecamatan berdasarkan koordinat laporan.
    $district = $this->getDistrict(
        (float) $data['latitude'],
        (float) $data['longitude']
    );

    $catSpotting = $request->user()->catSpottings()->create([
        ...$data,
        'photo_path' => $photoPath,
        'district' => $district,
        'status' => 'pending',
    ]);

    return response()->json([
        'message' => 'Laporan berhasil dibuat dan menunggu moderasi.',
        'data' => $catSpotting,
    ], 201);
}

public function update(Request $request, CatSpotting $catSpotting)
{
    abort_unless(
        (int) $catSpotting->user_id === (int) $request->user()->id,
        403,
        'Kamu tidak memiliki akses untuk mengubah laporan ini.'
    );

    $data = $request->validate([
        'description' => [
            'sometimes',
            'required',
            'string',
            'min:3',
            'max:1000',
        ],
        'latitude' => [
            'sometimes',
            'required',
            'numeric',
            'between:-90,90',
        ],
        'longitude' => [
            'sometimes',
            'required',
            'numeric',
            'between:-180,180',
        ],
        'photo' => [
            'sometimes',
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:2048',
        ],
        'report_type' => [
            'sometimes',
            'required',
            'in:lost,found,pet,adoption,sale',
        ],
    ]);

    $oldPhotoPath = $catSpotting->photo_path;
    $newPhotoPath = null;

    // Perbarui foto jika pengguna mengunggah foto baru.
    if ($request->hasFile('photo')) {
        $newPhotoPath = $request->file('photo')
            ->store('cat-spottings', 'public');

        $data['photo_path'] = $newPhotoPath;
    }

    unset($data['photo']);

    // Perbarui kecamatan jika koordinat berubah.
    if (
        isset($data['latitude']) ||
        isset($data['longitude'])
    ) {
        $latitude = (float) (
            $data['latitude'] ?? $catSpotting->latitude
        );

        $longitude = (float) (
            $data['longitude'] ?? $catSpotting->longitude
        );

        $data['district'] = $this->getDistrict(
            $latitude,
            $longitude
        );
    }

    // Setiap perubahan laporan memicu moderasi ulang.
    $data['status'] = 'pending';

    try {
        $catSpotting->update($data);
    } catch (\Throwable $exception) {
        // Bersihkan foto baru jika proses penyimpanan gagal.
        if ($newPhotoPath) {
            Storage::disk('public')->delete($newPhotoPath);
        }

        throw $exception;
    }

    // Hapus foto lama setelah update berhasil.
    if ($newPhotoPath && $oldPhotoPath) {
        Storage::disk('public')->delete($oldPhotoPath);
    }

    return response()->json([
        'message' => 'Laporan diperbarui dan menunggu moderasi ulang.',
        'data' => $catSpotting->fresh(),
    ]);
}


public function destroy(Request $request, CatSpotting $catSpotting)
{
    // Pastikan hanya pemilik laporan yang boleh menghapusnya.
    abort_unless(
        (int) $catSpotting->user_id === (int) $request->user()->id,
        403,
        'Kamu tidak memiliki akses untuk menghapus laporan ini.'
    );

    // Simpan path foto sebelum laporan dihapus.
    $photoPath = $catSpotting->photo_path;

    // Hapus laporan dari database.
    $catSpotting->delete();

    // Hapus file foto jika laporan memilikinya.
    if ($photoPath) {
        Storage::disk('public')->delete($photoPath);
    }

    return response()->json([
        'message' => 'Laporan berhasil dihapus.',
    ]);
}
}