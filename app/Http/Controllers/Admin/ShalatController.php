<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalShalat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class ShalatController extends Controller
{
    // Koordinat Kota Bekasi
    const LATITUDE  = -6.2383;
    const LONGITUDE = 106.9756;
    const METHOD    = 11; // Singapore / MUIS — paling dekat untuk Indonesia

    public function index()
    {
        $jadwals = JadwalShalat::orderByDesc('tanggal')->paginate(30);
        return view('admin.shalat.index', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'subuh'   => 'required',
            'dzuhur'  => 'required',
            'ashar'   => 'required',
            'maghrib' => 'required',
            'isya'    => 'required',
        ]);

        JadwalShalat::updateOrCreate(
            ['tanggal' => $request->tanggal],
            $request->only('tanggal','subuh','syuruq','dzuhur','ashar','maghrib','isya')
        );

        return back()->with('success', 'Jadwal shalat berhasil disimpan.');
    }

    public function update(Request $request, JadwalShalat $jadwal)
    {
        $jadwal->update($request->only('subuh','syuruq','dzuhur','ashar','maghrib','isya'));
        return back()->with('success', 'Jadwal shalat berhasil diperbarui.');
    }

    /**
     * Fetch jadwal shalat dari Aladhan API untuk bulan tertentu.
     * POST /admin/shalat/fetch
     */
    public function fetchFromApi(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2024|max:2030',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        try {
            $response = Http::timeout(15)->get('https://api.aladhan.com/v1/calendar', [
                'latitude'  => self::LATITUDE,
                'longitude' => self::LONGITUDE,
                'method'    => self::METHOD,
                'month'     => $bulan,
                'year'      => $tahun,
            ]);

            if (!$response->successful()) {
                return back()->with('error', 'Gagal mengambil data dari API. Coba lagi.');
            }

            $data = $response->json();

            if (($data['code'] ?? 0) !== 200) {
                return back()->with('error', 'API mengembalikan error: ' . ($data['status'] ?? 'Unknown'));
            }

            $count = 0;
            foreach ($data['data'] as $day) {
                $timings  = $day['timings'];
                $tanggal  = Carbon::createFromFormat('d-m-Y', $day['date']['gregorian']['date'])->toDateString();
                $hijri    = $day['date']['hijri']['date'] ?? null;

                // Aladhan returns times like "04:31 (WIB)" — strip timezone suffix
                $strip = fn($t) => trim(explode(' ', $t)[0]);

                JadwalShalat::updateOrCreate(
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

            return back()->with('success', "Berhasil mengimpor {$count} jadwal shalat untuk " . Carbon::create($tahun, $bulan)->locale('id')->isoFormat('MMMM Y') . ' dari API Aladhan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Fetch hari ini saja — dipanggil dari scheduler harian.
     */
    public static function fetchToday(): bool
    {
        try {
            $today    = Carbon::now('Asia/Jakarta');
            $response = Http::timeout(15)->get('https://api.aladhan.com/v1/timings/' . $today->timestamp, [
                'latitude'  => self::LATITUDE,
                'longitude' => self::LONGITUDE,
                'method'    => self::METHOD,
            ]);

            if (!$response->successful()) return false;

            $data    = $response->json();
            $timings = $data['data']['timings'] ?? null;
            $hijri   = $data['data']['date']['hijri']['date'] ?? null;

            if (!$timings) return false;

            $strip = fn($t) => trim(explode(' ', $t)[0]);

            JadwalShalat::updateOrCreate(
                ['tanggal' => $today->toDateString()],
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

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
