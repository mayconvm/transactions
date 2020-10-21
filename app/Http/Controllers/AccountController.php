<?php

namespace App\Http\Controllers;

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
        $accountEntity = $this->accountService->createAccount($accountInput);

        // call service
        return (var_dump("store", $accountEntity));
    }

    public function show(AccountInput $accountInput)
    {

        $result = $accountInput->validated();
        // call service
        return (var_dump("show", $result));
    }
}
