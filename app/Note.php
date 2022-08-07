<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'notes', 'users_id', 'transaction_id'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
