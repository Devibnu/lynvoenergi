<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SeoController extends Controller
{
    public function robots()
    {
        $enabled = Setting::getValue('robots_enabled', '1');

        if ($enabled == '1') {
            $content = "User-agent: *\n";
            $content .= "Allow: /\n\n";
            $content .= "Disallow: /admin\n";
            $content .= "Disallow: /login\n";
            $content .= "Disallow: /register\n";
            $content .= "Disallow: /password\n\n";
            $content .= "Sitemap: https://lynvoenergi.com/sitemap.xml\n";
        } else {
            $content = Setting::getValue('robots_custom_content', '');
        }

        return response($content)->header('Content-Type', 'text/plain');
    }
}
