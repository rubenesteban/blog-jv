<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];
    public function users()
    {
        return $this->belongsToMany('App\Models\User')->as('subscriptions')->withTimestamps();
    }
}
