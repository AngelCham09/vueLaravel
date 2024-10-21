<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $incrementing = false; // Set to false for composite keys

    protected $primaryKey = ['date', 'seq', 'bank']; // Composite primary key

    protected $keyType = 'string'; // If any part of the composite key is a string

    public $timestamps = true; // Assuming timestamps are used

    // Relationship to deposits
    public function deposits()
    {
        return $this->hasMany(Deposit::class, 'dbs_seq', 'seq');
    }
}
