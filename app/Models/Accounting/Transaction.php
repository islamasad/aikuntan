<?php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $connection = 'accounting_db';

    protected $fillable = [
        'uuid', 'company_id', 'user_id', 'transaction_date',
        'total_amount', 'reference_number', 'description',
        'due_date', 'status',
    ];

    protected $casts = [
        'transaction_date' => 'datetime:Y-m-d',
        'due_date' => 'datetime:Y-m-d',
        'total_amount' => 'decimal:2', // Tambahkan casting
    ];

    // Relasi ke User (Lintas Database)
    public function user()
    {
        return $this->belongsTo(\App\Models\User\User::class, 'user_id')->connection('user_db');
    }

    // Relasi ke Transaction Entries
    public function entries()
    {
        return $this->hasMany(TransactionEntry::class);
    }
}
