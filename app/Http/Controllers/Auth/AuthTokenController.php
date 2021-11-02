<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ActiveCode;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class AuthTokenController extends Controller
{
    //

    public function getToken(Request $request)
    {

        if(! $request->session()->has('auth'))
        {
            return redirect(route('login'));
        }

        $request->session()->reflash();

        return view('auth.token');
    }

    public function postToken(Request $request)
    {
        $request->validate([

            'token'=>'required'
        ]);

        if(! $request->session()->has('auth'))
        {
            return redirect(route('login'));
        }

        $user=\App\Models\User::findOrFail($request->session()->get('auth.user_id'));
        $status=  ActiveCode::verifyCode($request->token , $user);

        if (! $status)
        {

           alert()->error('token is not valid','ERROR');
           return  redirect(route ('login'));

        }

        if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember')))
        {

            $user->activeCode()->delete();
            return redirect('/');
            alert()->success('WElcome' , 'LogedIn');

        }

        return  redirect(route('login'));





    }
}
