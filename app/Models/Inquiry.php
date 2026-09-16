<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'name',
        'company_name',
        'phone',
        'email',
        'target_location',
        'message',
        'source_url',
        'category_id',
        'quantity',
        'is_read',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
