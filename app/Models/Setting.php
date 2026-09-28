<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public static function getValue($key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Get normalized WhatsApp number.
     */
    public static function getNormalizedWhatsappNumber($customPhone = null)
    {
        $phone = $customPhone ?: self::getValue('hero_phone');
        if (empty($phone) || trim($phone) === '') {
            return '';
        }
        $phone = preg_replace('/[^0-9]/', '', (string) $phone);
        if (empty($phone)) {
            return '';
        }
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
        if (empty($phone)) {
            return '#';
        }
        $url = "https://wa.me/{$phone}";
        if ($text) {
            $url .= "?text=" . rawurlencode($text);
        }
        return $url;
    }

    /**
     * Get safe tel: URL.
     */
    public static function getPhoneUrl($customPhone = null)
    {
        $phone = $customPhone ?: self::getValue('hero_phone');
        if (empty($phone) || trim($phone) === '') {
            return '#';
        }
        $phone = preg_replace('/[^0-9+]/', '', (string) $phone);
        if (empty($phone)) {
            return '#';
        }
        return "tel:{$phone}";
    }
}
