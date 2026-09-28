<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

// Clean up first
Storage::disk('public')->deleteDirectory('seo');
Setting::where('key', 'like', 'seo_%')->delete();

// Create dummy images
Storage::disk('public')->makeDirectory('seo');
Storage::disk('public')->put('seo/og_test.jpg', 'fake-image-content');
Storage::disk('public')->put('seo/tw_test.jpg', 'fake-image-content');

// Directly insert into DB to simulate upload success
Setting::updateOrCreate(['key' => 'seo_title'], ['value' => 'Lynvo Energi | Distributor Aki Industri Indonesia', 'label' => 'Seo Title']);
Setting::updateOrCreate(['key' => 'seo_description'], ['value' => 'Distributor aki industri, genset, UPS, forklift dan kendaraan komersial seluruh Indonesia.', 'label' => 'Seo Description']);
Setting::updateOrCreate(['key' => 'seo_keywords'], ['value' => 'aki industri, aki genset, aki ups, aki forklift', 'label' => 'Seo Keywords']);
Setting::updateOrCreate(['key' => 'seo_author'], ['value' => 'Lynvo Energi', 'label' => 'Seo Author']);
Setting::updateOrCreate(['key' => 'seo_og_title'], ['value' => 'Lynvo Energi Official', 'label' => 'Seo Og Title']);
Setting::updateOrCreate(['key' => 'seo_og_description'], ['value' => 'Solusi aki industri dan kendaraan komersial seluruh Indonesia.', 'label' => 'Seo Og Description']);
Setting::updateOrCreate(['key' => 'seo_og_image'], ['value' => 'seo/og_test.jpg', 'label' => 'SEO OG Image']);
Setting::updateOrCreate(['key' => 'seo_twitter_title'], ['value' => 'Lynvo Energi Official', 'label' => 'Seo Twitter Title']);
Setting::updateOrCreate(['key' => 'seo_twitter_description'], ['value' => 'Solusi aki industri dan kendaraan komersial seluruh Indonesia.', 'label' => 'Seo Twitter Description']);
Setting::updateOrCreate(['key' => 'seo_twitter_image'], ['value' => 'seo/tw_test.jpg', 'label' => 'SEO Twitter Image']);

echo "DB Settings:\n";
$settings = Setting::where('key', 'like', 'seo_%')->get(['key', 'value'])->toArray();
print_r($settings);

echo "\nFiles in storage/app/public/seo:\n";
$files = Storage::disk('public')->files('seo');
print_r($files);

// Test homepage response
$request = Illuminate\Http\Request::create('/', 'GET');
$response = app()->handle($request);
$html = $response->getContent();

echo "\nRendered Meta Tags:\n";
preg_match_all('/<title>.*<\/title>|<meta name="(description|keywords|author|twitter:[^"]+)"[^>]*>|<meta property="og:[^"]+"[^>]*>/i', $html, $matches);
foreach ($matches[0] as $match) {
    echo $match . "\n";
}
