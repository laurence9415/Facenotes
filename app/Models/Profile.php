<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'mobile_number',
        'address',
        'city',
        'state',
        'zip_code',
        'profile_picture'
    ];

    public function getProfilePictureAttribute($value)
    {
        $names = explode('/', $value);
        return $this->attributes['profile_picture'] = $names[0] === 'storage' ? $value : "storage/$value";
    }
}
