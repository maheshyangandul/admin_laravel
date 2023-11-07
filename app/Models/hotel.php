<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class hotel extends Model
{
    use HasFactory;
    protected $fillable=['name','description','images','country','state','city','pincode','location','hotel_sector_id','vendor_id'];
}
