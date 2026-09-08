<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Berita;
use App\Models\Galeri;
use App\Models\Video;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $kegiatans = Kegiatan::active()->select('slug', 'updated_at')->get();
        $beritas   = Berita::published()->select('slug', 'updated_at')->get();
        $videos    = Video::where('is_active', true)->select('slug', 'updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        // Static pages
        $staticPages = [
            ['url' => route('home'),           'priority' => '1.0',  'changefreq' => 'daily'],
            ['url' => route('tentang'),        'priority' => '0.8',  'changefreq' => 'monthly'],
            ['url' => route('kegiatan.index'), 'priority' => '0.9',  'changefreq' => 'weekly'],
            ['url' => route('galeri.index'),   'priority' => '0.7',  'changefreq' => 'weekly'],
            ['url' => route('event.index'),    'priority' => '0.8',  'changefreq' => 'weekly'],
            ['url' => route('kontak'),         'priority' => '0.7',  'changefreq' => 'monthly'],
            ['url' => route('donasi.index'),   'priority' => '0.8',  'changefreq' => 'monthly'],
            ['url' => route('berita.index'),   'priority' => '0.9',  'changefreq' => 'daily'],
            ['url' => route('video.index'),    'priority' => '0.7',  'changefreq' => 'weekly'],
        ];

        foreach ($staticPages as $page) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($page['url']) . '</loc>';
            $xml .= '<changefreq>' . $page['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $page['priority'] . '</priority>';
            $xml .= '</url>';
        }

        // Kegiatan dynamic pages
        foreach ($kegiatans as $kegiatan) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('kegiatan.show', $kegiatan->slug)) . '</loc>';
            $xml .= '<lastmod>' . optional($kegiatan->updated_at)->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.7</priority>';
            $xml .= '</url>';
        }

        // Berita dynamic pages
        foreach ($beritas as $berita) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('berita.show', $berita->slug)) . '</loc>';
            $xml .= '<lastmod>' . optional($berita->updated_at)->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.6</priority>';
            $xml .= '</url>';
        }

        // Video dynamic pages
        foreach ($videos as $video) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars(route('video.show', $video->slug)) . '</loc>';
            $xml .= '<lastmod>' . optional($video->updated_at)->toAtomString() . '</lastmod>';
            $xml .= '<changefreq>monthly</changefreq>';
            $xml .= '<priority>0.5</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
