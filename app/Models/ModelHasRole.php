<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelHasRole extends Model
{
    protected $connection = 'user_db';

    protected $table = 'model_has_roles';

    protected $fillable = [
        'role_id',
        'model_id',
        'model_type',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }
}
