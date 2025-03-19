<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $fillable = [
        'uuid',
        'name',
    ];

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
