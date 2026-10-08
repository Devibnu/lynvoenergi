<?php

namespace App\Support;

/**
 * Render-time presentation helper for article content.
 *
 * IMPORTANT: This class never rewrites, summarises or drops article text.
 * It only groups the existing plain-text blocks into structural blocks
 * (paragraph / heading / numbered step) so the view can present them
 * with better visual hierarchy. Stored content is left untouched.
 */
class ArticleContentFormatter
{
    /**
     * @return array{mode: 'html'|'blocks', html?: string, blocks?: array<int, array<string, mixed>>}
     */
    public static function format(?string $content): array
    {
        $content = (string) $content;

        // Content authored as HTML is rendered as-is (styled via .article-prose).
        if (preg_match('/<(p|h[1-6]|ul|ol|li|div|br|table|blockquote|img|strong|em|a)\b/i', $content)) {
            return ['mode' => 'html', 'html' => $content];
        }

        $normalized = str_replace(["\r\n", "\r"], "\n", $content);
        $chunks = preg_split('/\n\s*\n/', trim($normalized)) ?: [];

        $blocks = [];
        $currentStep = null;

        foreach ($chunks as $index => $chunk) {
            $text = trim($chunk);
            if ($text === '') {
                continue;
            }

            // Numbered step title, e.g. "1. Periksa Kondisi Terminal Aki"
            if (preg_match('/^(\d{1,2})[.)]\s+(.+)$/u', $text, $m) && self::isTitleLike($m[2])) {
                if ($currentStep) {
                    $blocks[] = $currentStep;
                }
                $currentStep = [
                    'type' => 'step',
                    'number' => (int) $m[1],
                    'title' => $m[2],
                    'icon' => self::iconFor($m[2]),
                    'paragraphs' => [],
                ];
                continue;
            }

            // Section heading: short line without terminal punctuation (never the first block).
            if ($index > 0 && self::isTitleLike($text) && ! str_contains($text, "\n")) {
                if ($currentStep) {
                    $blocks[] = $currentStep;
                    $currentStep = null;
                }
                $blocks[] = ['type' => 'heading', 'text' => $text];
                continue;
            }

            if ($currentStep) {
                $currentStep['paragraphs'][] = $text;
            } else {
                $blocks[] = ['type' => 'paragraph', 'text' => $text];
            }
        }

        if ($currentStep) {
            $blocks[] = $currentStep;
        }

        return ['mode' => 'blocks', 'blocks' => $blocks];
    }

    private static function isTitleLike(string $text): bool
    {
        $text = trim($text);

        return mb_strlen($text) <= 80
            && ! preg_match('/[.!?:;,]$/u', $text);
    }

    /**
     * Decorative icon only (aria-hidden in view). Falls back to a neutral icon.
     */
    private static function iconFor(string $title): string
    {
        $t = mb_strtolower($title);

        return match (true) {
            str_contains($t, 'terminal') => 'fa-plug',
            str_contains($t, 'tegangan') => 'fa-gauge-high',
            str_contains($t, 'kendaraan') || str_contains($t, 'digunakan') => 'fa-car-side',
            str_contains($t, 'kelistrikan') || str_contains($t, 'lampu') => 'fa-lightbulb',
            str_contains($t, 'spesifikasi') => 'fa-clipboard-check',
            str_contains($t, 'gejala') || str_contains($t, 'pemeriksaan') => 'fa-stethoscope',
            default => 'fa-circle-check',
        };
    }
}
