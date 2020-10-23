<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionService;

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

    public function execute(Request $input)
    {
        $accountEntity = $this->transactionService->executeTransaction(
            $input->json()
        );

        // call service
        return (var_dump("store", $accountEntity));
    }
}
