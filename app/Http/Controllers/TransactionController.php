<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Http\Inputs\TransactionInput;

class TransactionController extends Controller
{
    private $transactionService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function execute(TransactionInput $transactionInput)
    {
        if ($transactionInput->requiredInputValid()) {
            return $this->dispathError(null, null, $transactionInput->getErros());
            // return response()
            //     ->json($transactionInput->getErros(), 422)
            // ;
        }

        try {
            $transactionEntity = $this->transactionService->executeTransaction(
                $transactionInput->json()
            );
        } catch (\Exception $e) {
            // dd($e);
            throw $e;

            return $this->dispathError($e->getMessage(), $e->getCode());
            // return response()
            //     ->json([''$e->getMessage()], 400)
            ;
        }


        return response()->json($transactionEntity->toArray());
    }
}
