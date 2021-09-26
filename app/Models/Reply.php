<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function user(){
        $this->belongsTo(User::class);
    }

    public function topic(){
        $this->belongsTo(Topic::class);
    }
}
