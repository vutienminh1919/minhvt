<?php

namespace App\Modules\Store\Action;

use App\Lib\partner\VietQr;

class BaseAction
{
    public $vietQr;

    public function __construct(VietQr $vietQr)
    {
        $this->vietQr = $vietQr;

    }
}
