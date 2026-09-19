<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'application_product');
    }

    /**
     * Get the WhatsApp order URL for this product.
     */
    public function getWhatsappOrderUrlAttribute()
    {
        $text = "Halo Lynvo Energi, saya tertarik memesan produk {$this->name}. Apakah stoknya tersedia?";
        return Setting::getWhatsappUrl($text);
    }
}
