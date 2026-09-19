<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public static function getValue($key, $default = '')
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Get normalized WhatsApp number.
     */
    public static function getNormalizedWhatsappNumber($customPhone = null)
    {
        $phone = $customPhone ?: self::getValue('site_whatsapp', '6281384474349');
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strpos($phone, '0') === 0) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }

    /**
     * Get normalized WhatsApp URL with optional pre-filled text.
     */
    public static function getWhatsappUrl($text = '', $customPhone = null)
    {
        $phone = self::getNormalizedWhatsappNumber($customPhone);
        $url = "https://wa.me/{$phone}";
        if ($text) {
            $url .= "?text=" . rawurlencode($text);
        }
        return $url;
    }
}
