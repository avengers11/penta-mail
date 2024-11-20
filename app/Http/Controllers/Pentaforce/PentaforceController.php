<?php

namespace Acelle\Http\Controllers\Pentaforce;

use Acelle\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Acelle\Model\Customer;
use Acelle\Model\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;

class PentaforceController extends Controller
{
    // login
    public function login($id)
    {
        $user = User::find(Crypt::decrypt($id));
        Auth::login($user);

        return redirect(env("PENTAFORCE_URL")."/user/plugins/penta-mail");
    }

    // registration
    public function registration(Request $request)
    {
        // Initiate customer object for filling the form
        $customer = Customer::newCustomer();
        $user = new User();
        if (!empty($request->old())) {
            $customer->fill($request->old());
            $user->fill($request->old());
        }

        // save posted data
        if ($request->isMethod('post')) {
            $user->fill($request->all());

            // Okay, create it
            $user = $customer->createAccountAndUser($request);
            $user->setActivated();
        }

        return [
            'customer' => $customer,
            'user' => $user,
        ];
    }
}
