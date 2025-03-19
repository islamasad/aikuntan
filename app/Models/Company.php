<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $fillable = [
        'uuid',
        'name',
        'tax_number',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)
            ->where('status', 'active')
            ->where('ends_at', '>', now());
    }

    public function isOnTrial()
    {
        return $this->activeSubscription?->trial_ends_at?->isFuture();
    }
}
