<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mitras()
    {
        return $this->hasMany(Mitra::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }
}
