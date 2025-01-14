<?php

namespace App\Http\Controllers;



use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();
        if(!empty($request->input('title'))){
            $query->whereLike('title', $request->input('title'));
        }
        if (!empty($request->input('url'))) {
            $query->whereLike('url', $request->input('url'));
        }
        $data = $query->orderBy('id', 'DESC')->paginate(10);
        $data->getCollection()->transform(function ($menu) {
            $menu->parent_name = $menu->parent ? $menu->parent->title : null;
            return $menu;
        });
        return view('menu.index', [
            'data' => $data,
        ]);
    }

}
