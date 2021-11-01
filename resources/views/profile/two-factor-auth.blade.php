@extends('profile.layout')

@section('main')

    <h4>Two Factor AUTH</h4>

    <hr>

        @if($errors->any())

            <div class="alert alert-danger" >

                <ul>

                    @foreach($errors->all() as $error)

                        <li> {{ $error  }}  </li>
                    @endforeach


                </ul>


            </div>

            @endif


    <form action="{{route('post.profile.2fa.manage')}}" method="POST" >

        @csrf

        <div  class="form-group">

            <label>Type</label>

            <select name="type" class="form-control">

                @foreach(config('twofactor.types') as $key =>$name )

                    <option value="{{$key}}" {{old('type')==$key || auth()->user()->twofa_type == $key ? 'selected' : ''}}> {{$name}}</option>
                @endforeach
            </select>
        </div>
                <label >phone</label>
                <div class="form-group">
                    <input type="number" maxlength="11" minlength="11" name="phone" class="form-control" placeholder="Please add your phone number" value="{{old('phone') ?? auth()->user()->phone  }}">
                </div>
                <div clas="form-group">
                <button class="btn btn-primary">Update</button>
                </div>
    </form>



@endsection
