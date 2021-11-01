<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{

    protected $fillable=[

        'user_id',
        'active_codes',
        'expired_at'

    ];


    public $timestamps=false;

    use HasFactory;

    public function user()
    {

        return $this->belongsTo(ActiveCode::class);
    }


    public function scopeGenerateCode($query ,$user){

        if($code = $this->geAliveCodeForUser($user))
        {

            $code=$code->active_codes;

        }else
        {


        do{

            $code=mt_rand(10000,999999);

        }while($this->checkCodeIsUnique($user ,  $code));

        $user->activeCode()->create([
            'active_codes'=>$code,
            'expired_at'=>now()->addMinute(10)

        ]);

        }

        return $code;


    }

    private function checkCodeIsUnique($user , int $code)
    {

        return !! $user->activeCode()->where('active_codes',$code)->first();

    }

    private function geAliveCodeForUser($user)
    {

        return $user->activeCode()->where('expired_at','>',now())->first();
    }


    public function scopeVerifyCode($query , $code , $user)
    {


        return !! $user->activeCode()->where('active_codes',$code)->where('expired_at' , '>' , now())->first();

    }

}
