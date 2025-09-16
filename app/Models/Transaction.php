<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
use HasFactory;


protected $fillable = ['date', 'type', 'category', 'title', 'description', 'amount'];


protected $casts = [
'date' => 'date',
];
}