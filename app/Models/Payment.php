<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Payment extends Model
{
use HasFactory;


protected $fillable = ['member_id', 'month_year', 'paid_at', 'amount'];


protected $casts = [
'paid_at' => 'date',
];


public function member()
{
return $this->belongsTo(Member::class);
}
}