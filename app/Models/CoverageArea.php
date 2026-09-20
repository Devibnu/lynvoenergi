<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoverageArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'city_name',
        'slug',
        'hero_title',
        'district_coverage',
        'custom_intro_text',
        'meta_title',
        'meta_description',
        'whatsapp_number',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'whatsapp_url',
    ];

    /**
     * Accessor for local WhatsApp call-to-action link.
     */
    public function getWhatsappUrlAttribute(): string
    {
        $text = "Halo Lynvo Energi, saya butuh aki / layanan emergency antar pasang aki untuk area *{$this->city_name}* dan sekitarnya. Mohon bantuan teknisi dan rekomendasi tipe aki.";
        return Setting::getWhatsappUrl($text, $this->whatsapp_number);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
