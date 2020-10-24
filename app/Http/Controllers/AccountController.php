<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Http\Inputs\AccountInput;

/**
 * Classe AccountController
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
    /**
     * Account service
     * @var AccountService
     */
    private $accountService;

    /**
     * Create a new controller instance.
     *
     * @param AccountService $accountService Account service
     * @return void
     */
    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    /**
     * Create new account
     * @param  AccountInput $accountInput Data request to new account
     * @return Response
     */
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
