<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class CV extends Model
{
    public $table = 'cvs';
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'keyprogramming',
        'profile',
        'education',
        'URLlinks'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
