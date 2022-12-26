@extends('Buyer.layout.masterapp')
@section('title', 'Profile Buyer Beehive')

@section('content')

    <div class="h-full">
        <h1 class="text-3xl ml-20 mt-5 font-semibold block">Changing Profile Picture</h1>
        <div class="block ml-20 mt-7">
            <a href="{{url("/buyer/profile")}}" class="btn btn-error capitalize mt-2 ml-2 w-24">Back</a> <br>
            <form action="" method="post" class="ml-2" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if (env("APP_ENV")=="production")
                    <img src="{{asset("profile-pictures/$user->PICTURE")}}" alt="Picture of {{$user->NAMA}}" class="w-52 rounded-full mt-5">
                @else
                    <img src="{{asset("storage/profile-pictures/$user->PICTURE")}}" alt="Picture of {{$user->NAMA}}" class="w-52 rounded-full mt-5">
                @endif
                <label class="block mb-2 pt-5 text-sm font-medium text-gray-900 " for="picture">Picture</label>
                <input
                    class="block mb-5  text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:outline-none w-96"
                    id="picture" name="picture" type="file" accept=".jpg,.png,.jpeg">
                <button class="btn btn-info" type="submit">Submit!</button>
            </form>
        </div>
    </div>
@endsection
