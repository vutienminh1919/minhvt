<?php

namespace App\Modules\Store\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Store\Action\VietQr\VietQrAction;
use Illuminate\Http\Request;


class VietQrController extends Controller
{
    public function create(Request $request)
    {
        try {
            $result = app(VietQrAction::class)->create($request);
            return $this->successResponse($result, 'Thành công');
        } catch (\Throwable $th) {
//            $error = $this->messageError($th);
            return $this->errorResponse($th->getMessage());
        }

    }

    public function getBankList(Request $request)
    {
        try {
            $result = app(VietQrAction::class)->getBank($request);
            return $this->successResponse($result, 'Thành công');
        } catch (\Throwable $th) {
//            $error = $this->messageError($th);
            return $this->errorResponse($th->getMessage());
        }

    }

}
