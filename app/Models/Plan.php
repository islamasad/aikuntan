<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'description',
        'price',
        'billing_interval',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
