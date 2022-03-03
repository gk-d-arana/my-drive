<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = "files";

    protected $fillable = [
        'name',
        'uploaded_at',
        'file',
        'user_id'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
