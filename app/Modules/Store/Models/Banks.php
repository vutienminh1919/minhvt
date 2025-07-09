<?php

namespace App\Modules\Store\Models;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model
{
    // Tên bảng tương ứng
    protected $table = 'banks';

    // Khóa chính
    protected $primaryKey = 'id';

    // Cho phép tự động timestamps
    public $timestamps = false;

    // Các trường có thể gán (fillable)
    protected $fillable = [
        'bank_id',
        'name',
        'code',
        'bin',
        'shortName',
        'logo',
        'transferSupported',
        'lookupSupported',
        'short_name',
        'support',
        'isTransfer',
        'swift_code',
        'time_created',
        'time_updated',
    ];
}
