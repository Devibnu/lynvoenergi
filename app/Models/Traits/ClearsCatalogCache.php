<?php

namespace App\Models\Traits;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

trait ClearsCatalogCache
{
    protected static function bootClearsCatalogCache()
    {
        static::saved(function ($model) {
            self::clearCatalogCache($model);
        });

        static::deleted(function ($model) {
            self::clearCatalogCache($model);
        });
    }

    protected static function clearCatalogCache($model)
    {
        Cache::forget('catalog:categories');
        Cache::forget('catalog:brands');

        if (get_class($model) === \App\Models\Product::class) {
            if ($model->category_id) {
                Cache::forget('catalog:brands:category:' . $model->category_id);
            }
            if ($model->getOriginal('category_id') && $model->getOriginal('category_id') !== $model->category_id) {
                Cache::forget('catalog:brands:category:' . $model->getOriginal('category_id'));
            }
        } else {
            // For Brand or Category update, we might need to clear all category brand caches
            $categoryIds = Category::pluck('id');
            foreach ($categoryIds as $id) {
                Cache::forget('catalog:brands:category:' . $id);
            }
        }
    }
}
