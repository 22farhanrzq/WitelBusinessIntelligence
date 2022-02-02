<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'mitras';

    public function distribution()
    {
        return $this->belongsTo(Distribution::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
