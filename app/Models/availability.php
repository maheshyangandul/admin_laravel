<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class availability extends Model
{
    use HasFactory;
    protected $fillable=['hotel_id','hotel_sector_id','images','title','desc','price','room_id'];
}
