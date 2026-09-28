<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Setting;
use Illuminate\Http\Request;

echo "UAT 1: Default Robots\n";
Setting::updateOrCreate(['key' => 'robots_enabled'], ['value' => '1', 'label' => 'Enable Robots']);

$request = Request::create('/robots.txt', 'GET');
$response = app()->handle($request);
echo "Headers:\n";
echo "Content-Type: " . $response->headers->get('Content-Type') . "\n";
echo "Content:\n" . $response->getContent() . "\n";

echo "\n------------------\n";
echo "UAT 2: Custom Robots\n";
Setting::updateOrCreate(['key' => 'robots_enabled'], ['value' => '0', 'label' => 'Enable Robots']);
Setting::updateOrCreate(['key' => 'robots_custom_content'], ['value' => "User-agent: Googlebot\nDisallow: /private\n", 'label' => 'Custom Robots']);

$request = Request::create('/robots.txt', 'GET');
$response = app()->handle($request);
echo "Headers:\n";
echo "Content-Type: " . $response->headers->get('Content-Type') . "\n";
echo "Content:\n" . $response->getContent() . "\n";
