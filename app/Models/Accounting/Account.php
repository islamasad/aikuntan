<?php

namespace App\Models\Accounting;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $connection = 'accounting_db';

    protected $fillable = [
        'uuid', 'company_id', 'parent_id', 'code', 'type',
        'name', 'currency', 'subtype', 'opening_balance', 'balance_date',
    ];

    // Relasi ke Company (Lintas Database)
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class, 'company_id')->connection('user_db');
    }

    // Relasi Parent Account
    public function parent()
    {
        return $this->belongsTo(Account::class, 'parent_id');
    }

    public function transactionEntries()
    {
        return $this->hasMany(TransactionEntry::class);
    }
}
