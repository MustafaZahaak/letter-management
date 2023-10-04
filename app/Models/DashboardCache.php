<?php

namespace App\Models;

use App\Scopes\DashboardScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DashboardCache extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m',
        'updated_at' => 'datetime:Y-m-d H:m',
        'data' => 'json'
    ];

    public static function booted()
    {
        if (!Auth::guard("api")->guest()) {
            static::addGlobalScope(new DashboardScope);
        }
    }
}
