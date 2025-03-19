<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
// Pastikan model Company di-import
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Koneksi database yang digunakan
     *
     * @var string
     */
    protected $connection = 'user_db';

    /**
     * Kolom yang bisa diisi secara massal
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',          // Tambahkan uuid
        'company_id',    // Tambahkan company_id
        'name',
        'email',
        'password',
    ];

    /**
     * Kolom yang harus disembunyikan
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting atribut
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi ke model Company
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Relasi ke model Role melalui tabel pivot model_has_roles
     */
    public function roles(): MorphToMany
    {
        return $this->morphToMany(
            Role::class,
            'model',        // Kolom model_type di tabel pivot
            'model_has_roles', // Nama tabel pivot
            'model_id',     // Kolom model_id di pivot
            'role_id'      // Kolom role_id di pivot
        );
    }

    /**
     * Menggunakan UUID untuk route binding
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
