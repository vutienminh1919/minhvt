<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Phân trang booostrap
        Paginator::useBootstrap();
        // Load view từ Modules
        $this->loadViewsFrom(app_path('Modules/Store/Views'), 'Store');
        // Dựng ham whereLike
        Builder::macro('whereLike', function ($attribute, $value) {
            return $this->where($attribute, 'LIKE', "%{$value}%");
        });
        View::composer('layouts.master', function ($view) {
            $menus = Menu::whereNull('parent_id') // Chỉ lấy menu cha
            ->whereIn('status', [1])
                ->with(['children' => function ($query) {
                    $query->whereIn('status', [1]); // Loại bỏ các menu con có status = 3
                }])               // Lấy menu con
                ->orderBy('display_order')// Sắp xếp theo thứ tự hiển thị
                ->get()->toArray(); // Lấy dữ liệu menus
            $view->with('menus', $menus); // Gửi dữ liệu tới view
        });
        //Đăng ký configs
        $configPath = app_path('Configs'); // Đường dẫn tới thư mục Configs
        $configFiles = glob($configPath . '/*.php'); // Lấy tất cả file .php

        foreach ($configFiles as $file) {
            $configName = basename($file, '.php'); // Tên file không có .php
            Config::set($configName, require $file); // Nạp nội dung file vào cấu hình
        }
    }
}
