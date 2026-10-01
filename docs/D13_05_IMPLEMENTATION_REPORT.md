# D13-05 IMPLEMENTATION REPORT: BreadcrumbList JSON-LD

## 1. Overview
BreadcrumbList JSON-LD schema has been successfully implemented on all public pages featuring a Breadcrumb UI navigation component, addressing finding D13-05-SEO-001.

*Update: SA Code Review requirements met. Replaced 'Aki' fallback logic and added strict testing for local-landing & products/show.*

## 2. Updated Views & Implementation Details

### `resources/views/pages/local-landing.blade.php`
- Dynamic generation using the coverage area's name.
- Hierarchy: Beranda > Layanan Antar Pasang > [Nama Area/City Name].
- Correctly uses `$area->city_name` (no prepended string) to avoid spoofing the URL/Context.

### `resources/views/pages/products/show.blade.php`
- Conditional hierarchy depending on the existence of `$product->category`.
- If category exists: Beranda > Katalog Produk > [Nama Kategori] > [Nama Produk].
- If category is missing (not possible due to DB constraints but safely handled): Beranda > Katalog Produk > [Nama Produk].
- Replaced fake category fallback (`'Aki'`) in both JSON-LD Schema and UI HTML to reflect strictly factual structures.

### `resources/views/pages/products/index.blade.php`
- Added dynamic logic to handle category filtering in the breadcrumb.
- Hierarchy if no category selected: Beranda > Katalog Produk.
- Hierarchy if category selected: Beranda > Katalog Produk > [Nama Kategori].
- The active item resolves accurately via `$selectedCategory` variable and `url()->current()`.

### `resources/views/pages/brands/show.blade.php`
- Dynamic generation using the specific brand's name.
- Hierarchy: Beranda > Daftar Merek > [Nama Merek].

### `resources/views/pages/projects/show.blade.php`
- Dynamic generation for individual projects.
- Hierarchy: Beranda > Portofolio Proyek > [Judul Proyek].

### `resources/views/pages/applications/show.blade.php`
- Dynamic generation for application sectors.
- Hierarchy: Beranda > Sektor Aplikasi > [Nama Sektor].

## 3. Schema Verification Checklist
For all implemented pages, the schema follows these strict rules:
- `@context`: `https://schema.org`
- `@type`: `BreadcrumbList`
- `itemListElement` type is `ListItem`.
- `position` is sequential starting from 1.
- `name` accurately matches the page's context.
- `item` URLs use HTTPS standard Laravel helpers (`route()` or `url()->current()`).
- URLs are non-trailing (ensured by global canonical behavior).
- Current page is consistently represented as the final item in the sequence.
- Verified that no duplicate BreadcrumbList schemas exist.

## 4. Test Coverage Additions (CONDITION 2)
Dedicated automated tests added to `tests/Feature/SeoStructuredDataTest.php` with hardened assertions:
- **Strict Single-Schema Verification**: Introduced `getBreadcrumbListSchema()` helper to extract JSON-LD script tags, decode JSON, filter by `@type === 'BreadcrumbList'`, and explicitly assert `assertCount(1, $schemas)` ensuring no duplicate breadcrumb schemas exist on the tested pages.
- **local-landing breadcrumb schema**: 
  Verified standard schema context, item positions, correct dynamic naming strictly from the decoded JSON-LD (not just random HTML string match), and tested precise URL formats (HTTPS and non-trailing slash via regex `^https://[^/]+/toko-aki-test-city$`).
- **products/show breadcrumb schema with category**: 
  Verified full 4-tier schema sequence (`Beranda` -> `Katalog Produk` -> `Test Category` -> `Test Product`) and precise HTTPS non-trailing URLs in the `item` fields directly from the parsed JSON data structure.
- **products/show breadcrumb schema without category**: 
  Omitted from test automation since `products.category_id` is strictly NOT NULL (Database Integrity Constraint) making a product without a category invalid in this system's schema.

## 5. Test Results
- **Filtered Test (`SeoStructuredDataTest`)**: 7 passed (41 assertions)
- **Full Regression Test**: 69 passed (190 assertions)
- **Git Diff Check**: No whitespace or formatting errors.
- Legacy untracked files were not modified or included.
