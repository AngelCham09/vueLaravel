<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Deposit extends Pivot
{
    
    protected $table = 'deposits';

    // Each Deposit belongs to one Reserve
    public function reserve()
    {
        return $this->belongsTo(Reserve::class, 'reserve_id', 'id');
    }

    // Existing relationship to Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'dbs_seq', 'seq');
    }
}
