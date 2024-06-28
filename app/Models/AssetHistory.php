<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'notes',
        'lentTo',
        'dateGiven',
        'estimatedDateOfReturn',
        'dateOfReturn',
        'returnedBy_id',
    ];

    protected $casts = [
        'dateGiven' => 'datetime:Y-m-d\TH:i:s.u\Z',
        'estimatedDateOfReturn' => 'datetime:Y-m-d\TH:i:s.u\Z',
        'dateOfReturn' => 'datetime:Y-m-d\TH:i:s.u\Z',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function returnedBy()
    {
        return $this->belongsTo(User::class, 'returnedBy_id');
    }
}