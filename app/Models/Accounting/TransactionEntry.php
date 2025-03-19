<?php

// app/Models/TransactionEntry.php

namespace App\Models\Accounting;

use App\Models\Accounting\Account;
use App\Models\Accounting\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionEntry extends Model
{
    use HasFactory;

    protected $connection = 'accounting_db';

    protected $fillable = [
        'transaction_id', 'account_id', 'type',
        'amount', 'tax_id', 'tax_amount', // Tambahkan tax fields
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2', // Tambahkan casting
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
