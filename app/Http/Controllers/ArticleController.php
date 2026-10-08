<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    /**
     * Display listing of published articles/blog posts.
     */
    public function index(Request $request): View
    {
        $articles = Article::active()->latest('published_at')->paginate(9);

        return view('pages.articles.index', [
            'articles' => $articles,
            'metaTitle' => 'Blog & Artikel Seputar Aki Industri | Lynvo Energi',
            'metaDescription' => 'Kumpulan artikel, tips perawatan aki, panduan teknis genset, UPS, dan kabar terbaru dari Lynvo Energi.',
        ]);
    }

    /**
     * Display detailed article.
     */
    public function show(string $slug): View
    {
        $article = Article::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $relatedArticles = Article::active()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        // Existing category names only (no fictional categories).
        $categories = Article::active()
            ->whereNotNull('category_name')
            ->where('category_name', '!=', '')
            ->selectRaw('category_name, COUNT(*) as total')
            ->groupBy('category_name')
            ->orderByDesc('total')
            ->get();

        return view('pages.articles.show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'categories' => $categories,
            'formattedContent' => \App\Support\ArticleContentFormatter::format($article->content),
            'metaTitle' => "{$article->title} | Lynvo Energi",
            'metaDescription' => $article->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($article->content), 150),
        ]);
    }
}
