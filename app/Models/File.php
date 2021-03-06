<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $table = "files";

    protected $casts = [
        'created_at' => 'datetime:Y-m-d h:i:s',
        'updated_at' => 'datetime:Y-m-d h:i:s'

    ];

    protected $fillable = [
        'name',
        'uploaded_at',
        'file',
        // 'user_id',
        'password'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
}
