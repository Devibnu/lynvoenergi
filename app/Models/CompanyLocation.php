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
        return $this->whatsapp ?: Setting::getValue('hero_phone');
    }

    /**
     * Get the active Phone number (fallback to central setting if empty)
     */
    public function getActivePhoneAttribute()
    {
        return $this->phone ?: Setting::getValue('hero_phone');
    }

    /**
     * Get global primary location (cached)
     */
    public static function getPrimaryLocation()
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('global_primary_location', function () {
            return self::active()->where('is_primary', true)->first();
        });
    }

    /**
     * Get all active ordered locations for contact page (cached)
     */
    public static function getContactLocations()
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('contact_locations', function () {
            return self::active()->ordered()->get();
        });
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::saved(function ($location) {
            \Illuminate\Support\Facades\Cache::forget('global_primary_location');
            \Illuminate\Support\Facades\Cache::forget('contact_locations');
        });

        static::saving(function ($location) {
            // If this location is being set as primary, demote all others
            if ($location->is_primary) {
                static::where('id', '!=', $location->id)->update(['is_primary' => false]);
            }
        });
        
        static::deleted(function ($location) {
            \Illuminate\Support\Facades\Cache::forget('global_primary_location');
            \Illuminate\Support\Facades\Cache::forget('contact_locations');

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
