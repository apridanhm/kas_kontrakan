<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'phone', 'active'];
    protected $casts = ['active' => 'boolean']; // <-- tambah ini

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
