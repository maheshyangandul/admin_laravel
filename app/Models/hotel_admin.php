<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hotel_admin extends Model
{
    use HasFactory;
    protected $fillable=['name','hotel_id','vendor_id','contact','email','password'];
}
