<?php

namespace App\Http\Controllers;

use Personals\Ad\Ad;
use Personals\Ad\Tag;

class SitemapController extends Controller
{
    public function robots()
    {
        $robots =
            "User-Agent: *\n" .
            "Disallow:\n" .
            "Allow: /\n" .
            "Disallow: /ads/*/publish/*\n" .
            "\n" .
            "Sitemap: " . route('sitemap');

        return response($robots, 200)->header('Content-Type', 'text/plain');
    }


    public function sitemap()
    {
        $xml = "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $xml .= "\t<url>\n\t\t<loc>" .
                route('index') .
                "</loc>\n\t</url>\n";
        $xml .= "\t<url>\n\t\t<loc>" .
                route('ad.write') .
                "</loc>\n\t</url>\n";
        foreach (Ad::where('status', Ad::STATUS_CONFIRMED)->get() as $ad) {
            $xml .= "\t<url>\n\t\t<loc>" .
                    route('ad.show', ['ad' => $ad, 'slug' => $ad->getSlug()]) .
                    "</loc>\n\t</url>\n";
        }
        foreach (Tag::all() as $tag) {
            $xml .= "\t<url>\n\t\t<loc>" .
                    route('tag.show', ['tag' => $tag->tag]) .
                    "</loc>\n\t</url>\n";
        }
        $xml .= "</urlset>";

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
