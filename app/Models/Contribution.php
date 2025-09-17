<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    protected $fillable = ['member_id','income_category_id','month_year','paid_at','amount'];
    protected $casts = ['paid_at' => 'date'];

    public function member()   { return $this->belongsTo(Member::class); }
    public function category() { return $this->belongsTo(IncomeCategory::class,'income_category_id'); }
}
