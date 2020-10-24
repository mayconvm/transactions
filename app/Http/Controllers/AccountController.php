<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Inputs\AccountInput;
use App\Services\AccountService;

class AccountController extends Controller
{

    private $accountService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function update()
    {
        return ("update");
    }

    public function store(AccountInput $accountInput)
    {
        if ($accountInput->requiredInputValid()) {
            return response()
                ->json($accountInput->getErros(), 422)
            ;
        }

        try {
            $accountEntity = $this->accountService->createAccount(
                $accountInput->json()
            );
        } catch (\Exception $e) {
            return response()
                ->json($e->getMessage(), 400)
            ;
        }

        return response()->json($accountEntity->toArray());
    }

    public function show(AccountInput $accountInput)
    {

        $result = $accountInput->validated();
        // call service
        return (var_dump("show", $result));
    }
}
