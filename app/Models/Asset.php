<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    const CUSTOM_FIELD_MODEL = 'Asset';

    protected $fillable = [
        'asset_name',
        'asset_type_id',
        'serial_number',
        'value',
        'location',
        'status',
        'description',
        'asset_image'
    ];

    public function assetType()
    {
        return $this->belongsTo(AssetType::class, 'asset_type_id');
    }

    public function assetHistory()
    {
        return $this->hasOne(AssetHistory::class);
    }
}