<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['quantity','status','notes','category_id'];

    public function balance(){
        return $this->belongsToMany(Balance::class);
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
}
