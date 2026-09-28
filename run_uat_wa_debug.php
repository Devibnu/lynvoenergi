<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$request = Illuminate\Http\Request::create('/produk', 'GET');
$response = app()->handle($request);
$html = $response->getContent();

file_put_contents('debug_catalog.html', $html);

$request = Illuminate\Http\Request::create('/produk/aki-mobil/gs-astra-ns40z', 'GET');
$response = app()->handle($request);
$html = $response->getContent();

file_put_contents('debug_detail.html', $html);
