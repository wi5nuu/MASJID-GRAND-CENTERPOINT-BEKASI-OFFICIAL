<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\ShalatController;

class FetchJadwalShalat extends Command
{
    protected $signature   = 'shalat:fetch {--bulan= : Bulan (1-12)} {--tahun= : Tahun}';
    protected $description = 'Fetch jadwal shalat Bekasi dari Aladhan API';

    public function handle(): int
    {
        // Jika ada argumen bulan/tahun, fetch satu bulan penuh
        if ($this->option('bulan') && $this->option('tahun')) {
            return $this->fetchBulan((int) $this->option('bulan'), (int) $this->option('tahun'));
        }

        // Default: fetch hari ini saja
        $this->info('Fetching jadwal shalat Bekasi untuk hari ini dari Aladhan API...');
        $success = ShalatController::fetchToday();

        if ($success) {
            $this->info('Jadwal shalat hari ini berhasil diperbarui.');
            return self::SUCCESS;
        }

        $this->error('Gagal mengambil jadwal shalat dari API.');
        return self::FAILURE;
    }

    private function fetchBulan(int $bulan, int $tahun): int
    {
        $this->info("Fetching jadwal shalat Bekasi bulan {$bulan}/{$tahun}...");

        try {
            $response = \Illuminate\Support\Facades\Http::timeout(15)->get('https://api.aladhan.com/v1/calendar', [
                'latitude'  => ShalatController::LATITUDE,
                'longitude' => ShalatController::LONGITUDE,
                'method'    => ShalatController::METHOD,
                'month'     => $bulan,
                'year'      => $tahun,
            ]);

            if (!$response->successful()) {
                $this->error('API request gagal: ' . $response->status());
                return self::FAILURE;
            }

            $data  = $response->json();
            $count = 0;

            foreach ($data['data'] as $day) {
                $timings = $day['timings'];
                $tanggal = \Carbon\Carbon::createFromFormat('d-m-Y', $day['date']['gregorian']['date'])->toDateString();
                $hijri   = $day['date']['hijri']['date'] ?? null;
                $strip   = fn($t) => trim(explode(' ', $t)[0]);

                \App\Models\JadwalShalat::updateOrCreate(
                    ['tanggal' => $tanggal],
                    [
                        'subuh'      => $strip($timings['Fajr']),
                        'syuruq'     => $strip($timings['Sunrise']),
                        'dzuhur'     => $strip($timings['Dhuhr']),
                        'ashar'      => $strip($timings['Asr']),
                        'maghrib'    => $strip($timings['Maghrib']),
                        'isya'       => $strip($timings['Isha']),
                        'hijri_date' => $hijri,
                    ]
                );
                $count++;
            }

            $this->info("Berhasil mengimpor {$count} jadwal shalat.");
            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}
