<?php

// app/Models/SubscriptionItem.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionItem extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $fillable = [
        'subscription_id',
        'plan_id',
        'quantity',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
