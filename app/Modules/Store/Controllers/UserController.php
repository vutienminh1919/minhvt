<?php

namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Store\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
//        dd(url()->current());
        $query = User::query();
        if (!empty($request->input('name'))) {
            $query->whereLike('name', $request->input('name'));
        }
        if (!empty($request->input('email'))) {
            $query->whereLike('email', $request->input('email'));
        }
        $data = $query->orderBy('id', 'desc')->paginate(10);
        return view('Store::user.list', [
            'data' => $data,
        ]);

    }

    public function create(Request $request)
    {
        $data = $request->all();
        $params = [
            'name' => $data['name'] ?? "",
            'email' => $data['email'] ?? "",
            'password' => $data['password'] ?? "",
            'time_created' => time(),
        ];
        $user = User::create($params);
        if ($user) {
            return response()->json([
                'message' => 'Tạo mới thành công',
                'data' => $user,
                'code' => 200
            ]);
        }
        return response()->json([
            'message' => 'Có lỗi xảy ra',
            'code' => 500
        ]);
    }

    public function update(Request $request)
    {
        // Lấy thông tin từ request
        $data = $request->all();

        // Tìm user theo ID
        $user = User::find($data['id']);

        // Nếu không tìm thấy user, trả về lỗi
        if (!$user) {
            return response()->json([
                'message' => 'User không tồn tại',
                'code' => 404
            ]);
        }

        // Chuẩn bị dữ liệu cập nhật
        $params = [
            'name' => $data['name'] ?? $user->name, // Nếu không có giá trị mới, giữ nguyên giá trị cũ
            'email' => $data['email'] ?? $user->email,
            'password' => !empty($data['password']) ? $data['password'] : $user->password, // Nếu có mật khẩu mới, mã hóa nó
            'time_updated' => now(), // Cập nhật thời gian
        ];

        // Cập nhật user
        $user->update($params);
        if ($user) {
            return response()->json([
                'message' => 'Chỉnh sửa thành công',
                'data' => $user,
                'code' => 200
            ]);
        }
        return response()->json([
            'message' => 'Có lỗi xảy ra',
            'code' => 500
        ]);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Người dùng không tồn tại.'], 404);
        }
        return response()->json($user);
    }
}
