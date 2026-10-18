<?php

namespace App\Console\Commands;

use App\Models\CatSpotting;
use App\Services\RegionLookupService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class BackfillCatSpottingDistricts extends Command
{
    protected $signature = 'meowmap:backfill-districts';

    protected $description =
        'Mengisi kecamatan laporan kucing yang belum memiliki district di DIY';

    public function handle(RegionLookupService $regionLookup): int
    {
        $processed = 0;
        $updated = 0;
        $skipped = 0;
        $failed = 0;

        CatSpotting::query()
            ->whereNull('district')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->chunkById(50, function ($reports) use (
                $regionLookup,
                &$processed,
                &$updated,
                &$skipped,
                &$failed
            ) {
                foreach ($reports as $report) {
                    $processed++;

                    try {
                        $district = $regionLookup->findDistrict(
                            (float) $report->latitude,
                            (float) $report->longitude
                        );

                        if ($district === null) {
                            $skipped++;
                            $this->warn(
                                "Laporan #{$report->id}: wilayah tidak teridentifikasi di DIY."
                            );
                            continue;
                        }

                        // Update hanya kolom district.
                        // Koordinat dan data laporan lain tidak diubah.
                        $report->district = $district;
                        $report->save();

                        $updated++;

                        $this->info(
                            "Laporan #{$report->id}: {$district}"
                        );
                    } catch (Throwable $e) {
                        $failed++;

                        Log::warning(
                            'Gagal menentukan kecamatan laporan MeowMap.',
                            [
                                'report_id' => $report->id,
                                'error' => $e->getMessage(),
                            ]
                        );

                        $this->error(
                            "Laporan #{$report->id}: gagal diproses."
                        );
                    }
                }
            });

        $this->newLine();
        $this->info("Diperiksa: {$processed}");
        $this->info("Berhasil diisi: {$updated}");
        $this->info("Dilewati: {$skipped}");
        $this->info("Gagal: {$failed}");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
