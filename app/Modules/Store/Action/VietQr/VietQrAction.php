<?php

namespace App\Modules\Store\Action\VietQr;

use App\Modules\Store\Action\BaseAction;
use App\Modules\Store\Models\Banks;

class VietQrAction extends BaseAction
{
    public function create($request)
    {

        $data = $request->all();
        $create = $this->vietQr->call($data, 'generate', 'POST');
        if ($create && $create['code'] == '00') {
            return $create['data'];
        }
        throw new \Exception('Không có thông tin');

    }

    public function getBank($request)
    {

        $bank = Banks::get();
        return $bank;


    }


}
