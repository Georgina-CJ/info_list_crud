<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountInfo extends Model
{
    protected $table = 'account_info';
    protected $fillable = [
        'account',
        'name',
        'sex',
        'birthday',
        'email',
        'memo'
    ];
}
