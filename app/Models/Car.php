<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $table = 'cars';

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'status',
    ];
    public function user(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }

}
