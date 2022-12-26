@extends('Seller.layout.masterapp')
@section('title', 'Profile Beeworker Beehive')

@section('content')
    <div class="h-full">
        <h1 class="text-3xl ml-20 mt-5 font-semibold block">Beeworker's Profile</h1>
        <span class="text-gray-600 ml-20">Balance : Rp{{ number_format($user->BALANCE) }}</span>

        <div class="border-b-2 block md:flex">

            <div class="w-full md:w-2/5 p-4 sm:p-6 lg:p-8 bg-neutral shadow-md ">
                <div class="flex justify-between">

                </div>

                <span class="text-gray-600 ml-12 ">Custom your profile to attract Farmers!</span>
                <div class="w-full p-8 mx-2 flex flex-col justify-center">
                    @if ($user->PICTURE == 'DEFAULT.JPG')
                        <div class="tooltip tooltip-open tooltip-bottom mr-20 tooltip-info mb-10"
                            data-tip="You still doesn't have profile picture yet!">
                            @if (env('APP_ENV') == 'production')
                                <img id="showImage" class="max-w-xs w-56 items-center border ml-2 rounded-lg"
                                    src="{{ asset('profile-pictures/DEFAULT.JPG') }}" alt="">
                            @else
                                <img id="showImage" class="max-w-xs w-56 items-center border ml-2 rounded-lg"
                                    src="{{ asset('storage/profile-pictures/DEFAULT.JPG') }}" alt="">
                            @endif
                        </div>
                    @else
                        @if (env('APP_ENV') == 'production')
                            <img id="showImage" class="max-w-xs w-56 items-center border ml-2 rounded-lg"
                                src="{{ asset("profile-pictures/$user->PICTURE") }}" alt="">
                        @else
                            <img id="showImage" class="max-w-xs w-56 items-center border ml-2 rounded-lg"
                                src="{{ asset("storage/profile-pictures/$user->PICTURE") }}" alt="">
                        @endif
                    @endif
                    <a href="profile/picture" class="btn btn-accent capitalize mt-2 ml-2 w-56">Change Profile Picture</a>
                </div>

            </div>

            <div class="w-full md:w-3/5 p-8 bg-neutral lg:ml-4 shadow-md">
                <form action="" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="rounded shadow p-6">
                        <div class="pb-6">
                            <label class="font-semibold text-gray-700 block pb-1">Email</label>
                            <div class="flex">
                                <input disabled name="email" class="border-1  rounded-r px-4 py-2 w-full" type="text"
                                    value="{{ $user->EMAIL }}" />
                            </div>
                        </div>
                        <div class="pb-6">
                            <label for="name" class=" font-semibold text-gray-700 block pb-1">Name</label>
                            <div class="flex">
                                <input name="name" class="input input-primary border-1  rounded-r px-4 py-2 w-full"
                                    type="text" value="{{ $user->NAMA }}" placeholder="Input Your Name" />
                            </div>
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                        <div class="pb-6">
                            <label for="name" class="font-semibold text-gray-700 block pb-1">Birthday</label>
                            <div class="flex">
                                <input type="datetime-local" name="birthday"
                                    class="input input-primary block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400  rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                    data-rounded="rounded-lg" value="{{ $user->TANGGAL_LAHIR }}" />

                            </div>
                            @error('birthday')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <div class="pb-6">
                            <label for="name" class="font-semibold text-gray-700 block pb-1">Bio</label>
                            <div class="flex">
                                <textarea name="bio" id="" cols="30" rows="10"
                                    class="input input-primary border-1  rounded-r px-4 py-2 w-full">{{ $user->BIO }}</textarea>

                            </div>
                            @error('bio')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>


                        <button class="btn btn-primary text-neutral">Save Changes</button>

                    </div>
                </form>
                <a href="{{ url('/seller/profile/password') }}">
                    <button class="btn btn-secondary mt-3 ml-3">Change Password</button>
                </a>

            </div>
        </div>
    </div>

@endsection
