<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Controllers;

use App\Services\TransactionService;
use App\Http\Inputs\TransactionInput;

/**
 * Classe TransactionController
 * @package App\Http\Controllers
 */
class TransactionController extends Controller
{
    /**
     * Transaction service
     * @var TransactionService
     */
    private $transactionService;

    /**
     * Create a new controller instance.
     *
     * @param TransactionService $transactionService Transaction service
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Execute transaction
     * @param  TransactionInput $transactionInput Data request to transaction
     * @return Response
     */
    public function execute(TransactionInput $transactionInput)
    {
        if (!$transactionInput->valid()) {
            return $this->dispathError(null, null, $transactionInput->getErrors());
        }

        try {
            $transactionEntity = $this->transactionService->executeTransaction(
                $transactionInput->json()
            );
        } catch (\Exception $e) {
            // throw $e;
            return $this->dispathError($e->getMessage(), $e->getCode());
        }

        return response()->json($transactionEntity->toArray());
    }
}
