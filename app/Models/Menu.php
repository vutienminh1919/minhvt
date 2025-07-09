<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = ['parent_id', 'title', 'url', 'icon', 'order', 'time_created', 'time_updated', 'status'];
    public $timestamps = false;

    // Lấy menu con
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('display_order');
    }

    // Quan hệ với menu cha
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id', 'id');
    }
}
