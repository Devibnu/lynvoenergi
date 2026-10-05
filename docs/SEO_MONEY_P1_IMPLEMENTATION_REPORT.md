# Lynvo Energi — P1 Money Keyword Implementation Report
## `/toko-aki-serang`

**Date:** 2026-10-05  
**Status:** IMPLEMENTATION COMPLETE — SA REVIEW REQUIRED  
**Deployment:** Not performed  
**Commit/push:** Not performed

## A. Objective

Improve the local transaction metadata for `/toko-aki-serang` around “Toko Aki Serang” and related buy, replacement, delivery, installation, and trade-in intent. Preserve the existing URL, H1, CTAs, FAQ, valid structured data, and broader service-hub role. Do not invent or force product data.

## B. Discovery Reference

Implementation follows [`SEO_MONEY_P1_DISCOVERY.md`](./SEO_MONEY_P1_DISCOVERY.md). The user selected the path to proceed with local metadata/copy only and leave the uncertain product block unchanged.

## C. Files Changed

1. [`app/Http/Controllers/LocalSeoController.php`](../app/Http/Controllers/LocalSeoController.php) — Serang-only metadata override.
2. [`resources/views/pages/local-landing.blade.php`](../resources/views/pages/local-landing.blade.php) — local content heading semantics.
3. [`tests/Feature/LocalSeoLandingTest.php`](../tests/Feature/LocalSeoLandingTest.php) — target-route metadata and rendered structure regression test.
4. This report.

No database, seeder, route, Product detail, global layout, or structured-data source was changed.

## D. Exact Changes

- For slug `toko-aki-serang`, the controller now uses the approved title and description even if the existing CoverageArea row contains older persisted metadata. Other cities retain current metadata behavior.
- Main-content heading levels were adjusted to avoid skips: location card H3→H2; trade-in, Serang hotline, and other-area subsection H4→H3. Text and visual classes remain the same.
- Added a target-route regression test for metadata, canonical path, contact CTAs, relevant internal links, heading hierarchy, and absence of nested anchors or `/merek/null`.
- Product selection logic and product section content were not changed.

## E. Title Before / After

**Before:**  
`Toko Aki Serang 24 Jam - Distributor & Antar Pasang Aki Mobil | Lynvo Energi`

**After:**  
`Toko Aki Serang | Jual, Ganti & Pasang Aki di Tempat`

The updated title keeps the primary phrase first and prioritizes retail transaction intent. No additional secondary keywords were added.

## F. Meta Description Before / After

**Before:**  
`Pusat jual aki mobil, truk, genset & alat berat di Serang Banten. Layanan antar pasang aki cepat, garansi resmi, original GS Astra, Yuasa, Incoe, Amaron.`

**After:**  
`Jual aki Serang untuk mobil dan kendaraan Anda. Lynvo Energi melayani ganti, antar, pasang aki di tempat, dan tukar tambah aki dengan teknisi siap datang ke lokasi.`

The new description follows the approved local transaction copy. It does not add an unsupported exact “terdekat” or physical-store claim.

## G. H1 Before / After

**Before and after (unchanged):**  
`Toko Aki & Accu Serang — Beli Aki / Ganti Accu, Kami Antar & Pasang di Tempat!`

It already expresses the primary local term and relevant transactional intents without needing further keyword additions.

## H. Content Changes

No body-copy additions or section expansion. Four heading tags were promoted one level to make the main-content outline sequential; visible text and styling remain unchanged.

## I. CTA Changes

No CTA text, function, phone number, or endpoint changed. WhatsApp ordering, phone contact, technician request, consultation, and trade-in actions remain as before.

## J. FAQ Changes

None. Existing five customer-facing questions and FAQPage data remain unchanged.

## K. Internal Link Changes

None. Existing service hub breadcrumb/link and sibling city links remain unchanged. Automated response assertions cover the hub and an active sibling local landing URL.

## L. Product Block Decision

**Decision: unchanged; no product card was added or fabricated.**

The live discovery render showed the catalogue heading without product cards. The controller selects active products whose `is_popular_retail` flag is true. The repository ProductSeeder does not set this flag, and the migration default is false. This source evidence does not establish which real products operations wants featured or verify live availability/pricing; database changes and fabricated product/stock/price data were out of scope. The prompt instructed stopping on unclear product data, so the product query and presentation remain untouched pending verified product selection.

No fake fallback product, price, stock claim, or Product schema was introduced. The empty catalogue section may therefore remain until its valid data/operational state is resolved.

## M. Structured Data Validation

- Local landing source remains `AutoRepair` with the current `Service` catalog entry, `FAQPage`, and `BreadcrumbList`.
- The generic Product node remains absent; no generic Product, offer, review, or aggregate rating was added.
- Global `Organization` / `WebSite` data and Product Detail schema sources were not modified.
- Focused structured-data and Product Detail regression tests passed.

## N. Canonical Validation

The target-route test verifies the rendered canonical URL ends in `/toko-aki-serang`. The route and URL architecture were not changed. The repository layout continues to generate canonical from the current URL.

## O. Cannibalization Check

The new title is city-specific and targets local commercial intent. `/layanan/antar-pasang-aki` retains its existing province-wide delivery/installation title and H1. Cilegon, Cikande, and Tangerang metadata were not changed. No new URLs or redirects were introduced.

## P. Tests

**Focused:**  
`php artisan test --filter='LocalSeoLandingTest|SeoStructuredDataTest|ProductDetailTest'`  
**Result:** 21 passed, 154 assertions.

**Full suite:**  
`php artisan test`  
**Result:** 118 passed, 458 assertions.

Both runs emitted an existing PHPUnit XML configuration deprecation warning; tests passed.

## Q. `git diff --check`

**PASS** — no whitespace errors.

## R. Render / UAT Results

The Laravel feature test rendered `/toko-aki-serang` with HTTP 200 and checked:

- Approved title and meta description, including when stored area metadata is stale.
- One H1 and sequential heading levels inside `<main>`.
- Canonical path ending in `/toko-aki-serang`.
- WhatsApp, phone, FAQ, and trade-in CTAs.
- Existing service-hub and sibling-area internal links.
- No nested anchors and no `/merek/null`.

Production was not deployed or changed, so there is no post-deployment live render validation. The discovered production catalogue state remains as described in section L.

## S. Remaining Limitations

1. The product block remains empty in the inspected production render until eligible products are verified and explicitly selected as popular retail items. No database mutation was made.
2. The live robots endpoint was not verifiable in the prior discovery session; this implementation did not change robots or indexing configuration.
3. Local-business geo and price-range values remain existing shared values and were not validated or changed.
4. Confirm operational availability/coverage claims before a future content revision.

## T. SA Review Required

Please review the Serang-specific controller override, heading-level adjustments, and the decision to leave the product block untouched. In particular, SA/operations should confirm the live source of CoverageArea metadata and provide verified product eligibility if resolving the empty catalogue is desired.

**FINAL STATUS: IMPLEMENTATION COMPLETE — SA REVIEW REQUIRED**

