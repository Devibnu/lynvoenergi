$sidebarContent = file_get_contents(resource_path('views/layouts/admin/app.blade.php'));

$tests = [
    'Manajemen Data' => 'Manajemen Data',
    'Produk' => 'admin.products.index',
    'Kategori Produk' => 'admin.categories.index',
    'Merek' => 'admin.brands.index',
    'Sektor Aplikasi' => 'admin.applications.index',
    'Proyek' => 'admin.projects.index',
    'Artikel & Edukasi' => 'admin.articles.index'
];

echo "Running D6.9.3.1B Sidebar UAT...\n";
$allPass = true;

foreach ($tests as $label => $keyword) {
    if (strpos($sidebarContent, $keyword) !== false) {
        echo "[PASS] $label menu exists.\n";
    } else {
        echo "[FAIL] $label menu ($keyword) is missing.\n";
        $allPass = false;
    }
}

if ($allPass) {
    echo "\nSTATUS: PASS\n";
} else {
    echo "\nSTATUS: FAIL\n";
}
