<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // 設置可以批量賦值的屬性
    protected $fillable = ['user_name', 'message'];

    // 如果你的表有時間戳，可以取消註釋下面這行
    // public $timestamps = false;
}
