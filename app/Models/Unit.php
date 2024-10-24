<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unit extends Model
{
    protected $table = 'unit';
    protected $fillable = ['no_unit', 'status', 'kondisi', 'id_alat'];


    public function unit(): BelongsTo
    {
        return $this->belongsTo(InventarisAlat::class, 'id_alat');
    }
}
