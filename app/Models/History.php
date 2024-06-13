<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'notes',
        'lentTo',
        'dateGiven',
        'estimatedDateOfReturn',
        'dateOfReturn',
        'returnedBy'
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function lentToUser()
    {
        return $this->belongsTo(User::class, 'lentTo');
    }

    public function returnedByUser()
    {
        return $this->belongsTo(User::class, 'returnedBy');
    }
}
