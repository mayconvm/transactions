<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function dispathError($message = null, $code = null, array $data = [])
    {
        $result = array_filter(compact('message', 'code'));
        return response()
            ->json($result + $data, 422)
        ;
    }
}
