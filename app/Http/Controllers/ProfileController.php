<?php

namespace App\Http\Controllers;

use App\Models\ActiveCode;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //


    public function index()


    {

        return view('profile.index');
    }

    public  function  manageTwoFactor()
    {


        return view('profile.two-factor-auth');
    }


    public  function  postmanageTwoFactor( Request  $request)
    {

      $data=  $request->validate([
            'type'=>'required|in:sms,off',
            'phone'=>'required_unless:type,off||min:11|max:11'
        ]);



      if($data['type']==='sms')
      {
          if($request->user()->phone !== $data['phone'])
          {

            $code=ActiveCode::GenerateCode(auth()->user());


                $request->session()->flash('phone',$data['phone']);
              return redirect(route('profile.2fa.phone'));

          }else{

              $request->user()->update([
                 'twofa_type'=>'sms',

              ]);

          }
      }
      if($data['type']==='off'){

          $request->user()->update([
              'twofa_type'=>'off'
          ]);
      }

      alert()->success('تنظیمات با موفقیت تغییر یافت','تبریک');
      return back();


    }


    public  function getPhoneVerify(Request $request){

        if ( ! $request->session()->has('phone'))
        {

            return redirect(route('profile.2fa.manage'));

        }


        $request->session()->reflash();

        return view('profile.phone-verify');
    }



    public function postPhoneVerify(Request $request){

        $request->validate([
            'token'=>'required',
        ]);

        $status=ActiveCode::verifyCode($request->token , $request->user());

        if($status)
        {

            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone'=>$request->session()->get('phone'),
                'twofa_type'=>'sms'
            ]);

            alert()->success('شماره تلفن و تحراز هویت دو مرحه ایی شما تایید شد','تبریک');

        }
        else{
            alert()->error('شماره تلفن و تحراز هویت دو مرحه ایی نا موفق','متاسفانه');
        }



        return redirect(route('profile.2fa.manage'));

    }
}
