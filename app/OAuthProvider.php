<?php

namespace App;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OAuthProvider extends Model
{
    protected $table = 'oauth_providers';

    protected $guarded = ['id'];

    protected $hidden = ['access_token', 'refresh_token'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
