<?php

// app/Models/Accounting/Tax.php

namespace App\Models\Accounting;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model
{
    protected $connection = 'accounting_db';

    protected $fillable = ['uuid', 'name', 'rate'];

    protected $casts = [
        'rate' => 'decimal:2',
    ];

    public function transactionEntries()
    {
        return $this->hasMany(TransactionEntry::class);
    }
}
