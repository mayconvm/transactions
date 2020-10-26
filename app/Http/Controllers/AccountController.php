<?php
/**
 * Classe Controller
 * @author mayconvm <mayconvm@gmail.com>
 */

namespace App\Http\Controllers;

use App\Services\AccountService;
use App\Http\Inputs\AccountInput;
use Illuminate\Http\Request;

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
     * @param  Request $request Data request to new account
     * @return Response
     */
    public function store(Request $request)
    {
        $accountInput = new AccountInput($request->all());
        if (!$accountInput->valid()) {
            return response()
                ->json($accountInput->getErrors(), 422)
            ;
        }

        try {
            $accountEntity = $this->accountService->createAccount(
                $accountInput
            );
        } catch (\Exception $e) {
            return response()
                ->json($e->getMessage(), 400)
            ;
        }

        return response()->json($accountEntity->toArray());
    }
}
