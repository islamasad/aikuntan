<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $fillable = [
        'uuid',
        'company_id',
        'plan_id',
        'status',
        'trial_ends_at',
        'starts_at',
        'ends_at',
        'canceled_at',
        'payment_gateway',
        'gateway_id',
        'gateway_payload',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function items()
    {
        return $this->hasMany(SubscriptionItem::class);
    }

    public function usages()
    {
        return $this->hasMany(SubscriptionUsage::class);
    }
}
