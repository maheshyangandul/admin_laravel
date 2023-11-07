<?php



namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Register extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, AuthenticableTrait;

    protected $fillable = ['full_name', 'email', 'password', 'confirm_password', 'type', 'active', 'contact'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

   
}