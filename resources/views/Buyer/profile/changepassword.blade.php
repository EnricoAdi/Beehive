@extends('Buyer.layout.masterapp')
@section('title', 'Profile Buyer Beehive')

@section('content')

<div class="h-full ml-20 mt-6">

    <h1 class="text-darkgray text-2xl font-semibold mb-3">Edit Password of {{ $user->NAMA }}!</h1>

    <a href="{{url("/buyer/profile")}}" class="btn btn-error ml-3">Back</a>
    <form action="" method="post">
        @csrf
        @method("PATCH")
        <label for="old" class=" font-semibold text-gray-500 block pb-1 ml-3 mt-3">Old Password </label>
        <input name="old" class="input input-primary border-1  rounded-md px-4 py-2 w-52 ml-3" type="password"
            placeholder="Input your old password"   required/>
        @error('old')
            <label class="label">
                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
            </label>
        @enderror
        <label for="new" class=" font-semibold text-gray-500 block pb-1 ml-3 mt-3">New Password </label>
        <input name="new" class="input input-primary border-1  rounded-md px-4 py-2 w-52 ml-3" type="password" required
            placeholder="Input your new password" />
        @error('new')
            <label class="label">
                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
            </label>
        @enderror

        <label for="confirm" class=" font-semibold text-gray-500 block pb-1 ml-3 mt-3">Confirmation New Password
        </label>
        <input name="confirm" class="input input-primary border-1  rounded-md px-4 py-2 w-52 ml-3" type="password" required
            placeholder="Confirmation of new password" />
        @error('confirm')
            <label class="label">
                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
            </label>
        @enderror
        <br>
        <button type="submit" class="btn btn-secondary mt-4 ml-3">Change!</button>
    </form>
</div>
@endsection
