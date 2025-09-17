<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeCategory extends Model
{
    protected $fillable = ['name', 'default_amount', 'description', 'active'];

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }
}
