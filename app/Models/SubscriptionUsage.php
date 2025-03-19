<?php

// app/Models/SubscriptionUsage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionUsage extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $table = 'subscription_usage';

    protected $fillable = [
        'subscription_id',
        'feature',
        'used',
        'limit',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
