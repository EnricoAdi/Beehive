@extends('Admin.layout.masterapp')
@section('title', 'Master User Beehive')

@section('content')

    <div class="h-full">
        <h1 class="text-3xl ml-20 mt-5 font-semibold block">{{ $from }}'s Profile</h1>

        <a href={{ url("/admin/master/user?filter=$from") }}><button class="btn btn-error ml-20 mt-3">Back</button></a>
        <div class="border-b-2 block md:flex">

            <div class="w-full md:w-2/5 p-4 sm:p-6 lg:p-8 bg-neutral shadow-md ">
                <div class="flex justify-between">

                </div>

                <div class="w-full p-8 mx-2 flex flex-col justify-center"> 
                    @if (env('APP_ENV') == 'production')
                            <img id="showImage" src="{{ asset("profile-pictures/$userDetail->PICTURE") }}" class="max-w-xs w-56 items-center border ml-2 rounded-lg" alt="Picture of {{ $userDetail->NAMA }}" />
                    @else
                            <img id="showImage" src="{{ asset("storage/profile-pictures/$userDetail->PICTURE") }}" class="max-w-xs w-56 items-center border ml-2 rounded-lg"  alt="Picture of {{ $userDetail->NAMA }}"/>
                    @endif

                </div>

            </div>

            <form action="" method="post" class="w-full md:w-3/5 p-8 bg-neutral lg:ml-4 shadow-md">
                @csrf
                @method('PATCH')
                <div class="rounded  shadow p-6">
                    <div class="pb-6">
                        <label class="font-semibold text-gray-700 block pb-1">Email</label>
                        <div class="flex">
                            <input disabled name="email" class="border-1  rounded-r px-4 py-2 w-full" type="text"
                                value="{{ $userDetail->EMAIL }}" />
                            <input type="hidden" name="email1" class="border-1  rounded-r px-4 py-2 w-full"
                                value="{{ $userDetail->EMAIL }}" />
                        </div>
                    </div>
                    <div class="pb-6">
                        <label for="name" class=" font-semibold text-gray-700 block pb-1">Name</label>
                        <div class="flex flex-col">
                            <input name="name" class="input input-primary border-1  rounded-r px-4 py-2 w-full"
                                type="text" value="{{ $userDetail->NAMA }}" placeholder="Input Your Name" />
                            @error('name')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>
                    <div class="pb-6">
                        <label for="name" class="font-semibold text-gray-700 block pb-1">Birthday</label>
                        <div class="flex">
                            <input type="datetime-local" name="birthday"
                                class="input input-primary block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400  rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-rounded="rounded-lg" value="{{ $userDetail->TANGGAL_LAHIR }}" disabled />

                        </div>
                    </div>

                    <div class="pb-6">
                        <label for="bio" class="font-semibold text-gray-700 block pb-1">Bio</label>
                        <div class="flex flex-col">
                            <textarea name="bio" id="" cols="30" rows="10"
                                class="input input-primary border-1  rounded-r px-4 py-2 w-full">{{ $userDetail->BIO }}</textarea>
                            @error('bio')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <button class="btn btn-primary text-neutral">Save Changes</button>

                </div>
            </form>
        </div>
    </div>


@endsection
