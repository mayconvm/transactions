<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Classe Controller
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    /**
     * Dispath reponse with erros
     * @param  string $message Message error
     * @param  int $code    Code error
     * @param  array  $data    Context data to error
     * @return Response
     */
    protected function dispathError(string $message = null, int $code = null, array $data = [])
    {
        $result = array_filter(compact('message', 'code'));
        return response()
            ->json($result + $data, 422)
        ;
    }
}
