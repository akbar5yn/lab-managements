<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    protected $table = 'unit';
    protected $fillable = ['no_unit', 'status', 'kondisi', 'equipment_category_id'];


    public function unit(): BelongsTo
    {
        return $this->belongsTo(InventarisAlat::class, 'unit_id');
    }
}
