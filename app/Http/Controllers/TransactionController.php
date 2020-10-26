<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Http\Inputs\TransactionInput;
use App\Http\Inputs\TransactionCreditInput;

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
    public function execute(Request $request)
    {
        $transactionInput = new TransactionInput($request->all());
        if (!$transactionInput->valid()) {
            return $this->dispathError(null, null, $transactionInput->getErrors());
        }

        try {
            $transactionEntity = $this->transactionService->executeTransaction(
                $transactionInput
            );
        } catch (\Exception $e) {
            return $this->dispathError($e->getMessage(), $e->getCode());
        }

        // notification
        event(new \App\Events\TransactionEvent($transactionEntity));

        return response()->json($transactionEntity->toArray());
    }

    /**
     * Execute transaction
     * @param  TransactionInput $transactionInput Data request to transaction
     * @return Response
     */
    public function executeCredit(Request $request)
    {
        $transactionInput = new TransactionCreditInput($request->all());
        if (!$transactionInput->valid()) {
            return $this->dispathError(null, null, $transactionInput->getErrors());
        }

        try {
            $transactionEntity = $this->transactionService->executeTransactionCredit(
                $transactionInput
            );
        } catch (\Exception $e) {
            return $this->dispathError($e->getMessage(), $e->getCode());
        }

        // notification
        event(new \App\Events\TransactionEvent($transactionEntity));

        return response()->json($transactionEntity->toArray());
    }
}
