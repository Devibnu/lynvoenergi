<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

// Create dummy product if not exists
$category = Category::firstOrCreate(['name' => 'Aki Mobil', 'slug' => 'aki-mobil']);
$brand = Brand::firstOrCreate(['name' => 'GS Astra', 'slug' => 'gs-astra']);
$product = Product::firstOrCreate(
    ['slug' => 'gs-astra-ns40z'],
    [
        'category_id' => $category->id,
        'brand_id' => $brand->id,
        'name' => 'GS Astra NS40Z',
        'voltage' => '12',
        'capacity_ah' => '35',
        'cca' => '320',
        'price' => 750000,
        'is_active' => true,
    ]
);

echo "Testing Catalog Page...\n";
$request = Request::create('/produk', 'GET');
$response = app()->handle($request);
$html = $response->getContent();

// Extract the WA link for this product
if (preg_match('/href="([^"]+whatsapp[^"]+)"[^>]*>.*?Pesan WA/is', $html, $matches)) {
    echo "Found WA Link on Catalog:\n" . urldecode($matches[1]) . "\n\n";
} else {
    echo "No WA link found on Catalog.\n\n";
}

echo "Testing Detail Page...\n";
$request = Request::create('/produk/' . $category->slug . '/' . $product->slug, 'GET');
$response = app()->handle($request);
$html = $response->getContent();

if (preg_match('/href="([^"]+whatsapp[^"]+)"[^>]*>.*?Pesan & Pasang via WhatsApp/is', $html, $matches)) {
    echo "Found WA Link on Detail:\n" . urldecode($matches[1]) . "\n";
} else {
    echo "No WA link found on Detail.\n";
}
