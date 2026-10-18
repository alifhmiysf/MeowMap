<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class RegionLookupService
{
    public function findDistrict(
        float $latitude,
        float $longitude
    ): ?string {
        $response = Http::acceptJson()
            ->timeout(10)
            ->retry(2, 300)
            ->get(
                'https://wilayah-id-api.dhanypedia.com/api/v1/boundaries/reverse',
                [
                    'lat' => $latitude,
                    'lng' => $longitude,
                ]
            );

        if (! $response->successful()) {
            throw new RuntimeException(
                'Reverse geocoding gagal dengan HTTP '
                . $response->status()
            );
        }

        $data = $response->json('data');

        if (
            data_get($data, 'provinsi.nama_provinsi')
            !== 'Daerah Istimewa Yogyakarta'
        ) {
            return null;
        }

        $district = data_get(
            $data,
            'kecamatan.nama_kecamatan'
        );

        return is_string($district) && $district !== ''
            ? $district
            : null;
    }
}
