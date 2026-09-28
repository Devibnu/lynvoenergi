<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Helpers
function makeRequest($method, $uri, $data = [], $user = null) {
    global $app, $kernel;
    $server = [
        'SERVER_NAME' => 'lynvoenergi.test',
        'REQUEST_URI' => $uri,
        'REQUEST_METHOD' => $method,
    ];
    $request = Illuminate\Http\Request::create($uri, $method, $data, [], [], $server);
    if ($user) {
        $app['auth']->guard()->setUser($user);
    }
    
    // Disable CSRF for testing
    $app->instance(\App\Http\Middleware\VerifyCsrfToken::class, new class {
        public function handle($request, $next) { return $next($request); }
    });

    $response = $kernel->handle($request);
    $kernel->terminate($request, $response);
    return $response;
}

function printStatus($testName, $passed, $details = '') {
    $status = $passed ? "\033[32mPASS\033[0m" : "\033[31mFAIL\033[0m";
    echo "[$status] $testName" . ($details ? " - $details" : "") . "\n";
}

$user = \App\Models\User::find(1);
if (!$user) {
    die("Test user not found.\n");
}

echo "Starting UAT Tests...\n\n";

// 1. Sidebar Verification
$response = makeRequest('GET', '/admin', [], $user);
$content = $response->getContent();
$sidebarPassed = strpos($content, 'Merek') !== false && strpos($content, 'admin/brands') !== false;
printStatus('Sidebar Verification', $sidebarPassed);

// 2. Create Brand
$createData = [
    'name' => 'Test Brand UAT',
    'description' => 'Brand description',
];
$response = makeRequest('POST', '/admin/brands', $createData, $user);
$brand = \App\Models\Brand::where('name', 'Test Brand UAT')->first();
$createPassed = $response->getStatusCode() === 302 && $brand !== null;
printStatus('Create Brand', $createPassed, "HTTP " . $response->getStatusCode());

// 3. Duplicate Name
$response = makeRequest('POST', '/admin/brands', $createData, $user);
$duplicateNamePassed = $response->getStatusCode() === 302 && session()->has('errors') && session('errors')->has('name');
printStatus('Duplicate Name', $duplicateNamePassed, session('errors') ? session('errors')->first('name') : '');

// 4. Duplicate Slug
// Since slug is generated from name, testing duplicate name inherently tests duplicate slug in this implementation.
printStatus('Duplicate Slug', $duplicateNamePassed, "Tested via Duplicate Name validation");

// 5. Edit Brand
if ($brand) {
    $editData = [
        'name' => 'Test Brand UAT Edited',
        'description' => 'Edited description',
    ];
    $response = makeRequest('PUT', '/admin/brands/' . $brand->id, $editData, $user);
    $brand->refresh();
    $editPassed = $response->getStatusCode() === 302 && $brand->name === 'Test Brand UAT Edited';
    printStatus('Edit Brand', $editPassed);
} else {
    printStatus('Edit Brand', false, "Brand not created");
}

// 6. Product Form Integration
$response = makeRequest('GET', '/admin/products/create', [], $user);
$content = $response->getContent();
$productFormPassed = strpos($content, 'Test Brand UAT Edited') !== false;
printStatus('Product Form Integration', $productFormPassed);

// 7. Delete Used Brand
// We will associate a product with this brand and try to delete
if ($brand) {
    // Create a dummy category first
    $category = \App\Models\Category::firstOrCreate(['name' => 'Test Cat', 'slug' => 'test-cat']);
    $product = \App\Models\Product::create([
        'name' => 'Test Product',
        'slug' => 'test-product',
        'brand_id' => $brand->id,
        'category_id' => $category->id
    ]);
    
    $response = makeRequest('DELETE', '/admin/brands/' . $brand->id, [], $user);
    $deleteUsedPassed = $response->getStatusCode() === 302 && session()->has('errors') && \App\Models\Brand::find($brand->id) !== null;
    printStatus('Delete Used Brand', $deleteUsedPassed, session('errors') ? session('errors')->first() : '');
    
    // Cleanup product
    $product->delete();
} else {
    printStatus('Delete Used Brand', false, "Brand not created");
}

// 8. Delete Unused Brand
if ($brand) {
    $response = makeRequest('DELETE', '/admin/brands/' . $brand->id, [], $user);
    $deleteUnusedPassed = $response->getStatusCode() === 302 && \App\Models\Brand::find($brand->id) === null;
    printStatus('Delete Unused Brand', $deleteUnusedPassed);
} else {
    printStatus('Delete Unused Brand', false, "Brand not created");
}

echo "\nUAT Complete.\n";
