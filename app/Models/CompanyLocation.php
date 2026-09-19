<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'address',
        'city',
        'province',
        'postal_code',
        'google_maps_url',
        'phone',
        'whatsapp',
        'business_hours',
        'is_primary',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope a query to only include active locations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Get the active WhatsApp number (fallback to central setting if empty)
     */
    public function getActiveWhatsappAttribute()
    {
        return $this->whatsapp ?: Setting::getValue('site_whatsapp');
    }

    /**
     * Get the active Phone number (fallback to central setting if empty)
     */
    public function getActivePhoneAttribute()
    {
        return $this->phone ?: Setting::getValue('hero_phone', Setting::getValue('b2b_phone'));
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::saving(function ($location) {
            // If this location is being set as primary, demote all others
            if ($location->is_primary) {
                static::where('id', '!=', $location->id)->update(['is_primary' => false]);
            }
        });
        
        static::deleted(function ($location) {
            // If the primary location is deleted, set the next oldest one as primary
            if ($location->is_primary) {
                $next = static::orderBy('id', 'asc')->first();
                if ($next) {
                    $next->update(['is_primary' => true]);
                }
            }
        });
    }
}
