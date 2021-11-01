<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use MongoDB\Driver\Exception\ExecutionTimeoutException;


class GoogleAuthController extends Controller
{
    public function redirect()
    {

        return Socialite::driver('google')->redirect();
    }

    public function callback(){


        try {
            $google_user=Socialite::driver('google')->user();

            $user=User::where('email',$google_user->email)->first();

            if($user)
            {

                auth()->loginUsingId($user->id);

            }else{

                $new_user=User::create([

                    'name'=>$google_user->name,
                    'email'=>$google_user->email,
                    'password'=>Hash::make(Str::random(16))

                ]);




                auth()->loginUsingId($new_user->id);
            }

            alert()->success('شما با موفقیت وارد شدید','خوش آمدید')->persistent('گرفتم');
            return redirect('/home');


        }catch (\Exception $e)
        {

            return $e->getMessage();
        }



    }
}
