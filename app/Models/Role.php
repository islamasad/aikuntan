<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Role extends Model
{
    use HasFactory;

    protected $connection = 'user_db';

    protected $fillable = [
        'uuid',
        'application_id',
        'name',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function users(): MorphToMany
    {
        return $this->morphToMany(
            User::class,
            'model',
            'model_has_roles',
            'role_id',
            'model_id'
        );
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
