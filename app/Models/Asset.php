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

    public function history()
    {
        return $this->hasMany(History::class);
    }
}
