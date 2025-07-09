<?php

namespace App\Http\Controllers;


use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();
        if (!empty($request->input('title'))) {
            $query->whereLike('title', $request->input('title'));
        }
        if (!empty($request->input('url'))) {
            $query->whereLike('url', $request->input('url'));
        }
        $data = $query->orderBy('status', 'ASC')->orderBy('id', 'DESC')->paginate(10);
        $data->getCollection()->transform(function ($menu) {
            $menu->parent_name = $menu->parent ? $menu->parent->title : null;
            return $menu;
        });
        return view('menu.index', [
            'data' => $data,
        ]);
    }

    public function showFormCreate()
    {
        $query = Menu::query();
        $menus = $query->whereNull('parent_id')->select(['id', 'title'])->get();
        $html = '<option selected="selected" value="">--Chọn menu cha--</option>';
        if ($menus) {
            foreach ($menus as $menu) {
                $html .= '<option value="' . $menu->id . '">' . $menu->title . '</option>';
            }
        }
        return view('menu.create', [
            'menu' => $html,
        ]);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $params = [
            'parent_id' => $data['parent_id'] ?? null,
            'title' => $data['title'] ?? "",
            'url' => $data['url'] ?? "",
            'icon' => $data['icon'] ?? "",
            'display_order' => $data['display_order'] ?? "",
            'time_created' => time(),
        ];
        $menu = Menu::create($params);
        if ($menu) {
            return redirect()->route('menus.index')->with('success', 'Tạo mới thành công');
        }
        return redirect()->back();

    }

    public function changeStatus(Request $request)
    {
        $data = $request->all();
        if ($data['id']) {
            $id = $data['id'];
            $status = $data['status'] ?? 2;
            $query = Menu::query();
            $menu = $query->where('id', $id)->first();
            if ($menu) {
                $menu->status = $status;
                $menu->save();
                return $this->successResponse();
            }
            return $this->errorResponse();
        }
        return $this->errorResponse();

    }

    public function detail($id)
    {
        $query = Menu::query();
        if ($id) {
            $menu = $query->where('id', $id)->first();
            $parent_menu = Menu::whereNull('parent_id')->select(['id', 'title'])->get();
            $html = '<option selected="selected" value="">--Chọn menu cha--</option>';
            if ($parent_menu) {
                foreach ($parent_menu as $menus) {
                    $selected = "";
                    $selected = ($menu['parent_id'] == $menus->id) ? "selected" : "";
                    $html .= '<option value="' . $menus->id . '" '. $selected .'>' . $menus->title . '</option>';
                }
            }
            $data = [
                'detail' => $menu,
                'parent_menu' => $html,
            ];
            if ($menu) {
                return $this->successResponse('', 200, $data);
            }
            return $this->errorResponse();
        }
        return $this->errorResponse();

    }

    public function update(Request $request)
    {
        $query = Menu::query();
        $data = $request->all();
        $id = $data['id'];
        if ($id) {
            $menu = $query->where('id', $id)->first();
            if ($menu) {
                $menu->parent_id = $data['parent_id'] ?? null;
                $menu->title = $data['title'] ?? "";
                $menu->url = $data['url'] ?? "";
                $menu->display_order = $data['display_order'] ?? "";
                $menu->icon = $data['icon'] ?? "";
                $menu->time_updated = time();
                $menu->save();
                return $this->successResponse();
            }
            return $this->errorResponse('Không có thông tin');
        }
        return $this->errorResponse();

    }

}
