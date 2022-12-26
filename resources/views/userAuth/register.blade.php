@extends('layout.master')
@section('title', 'Register New User!')
@section('body')
    <div class="flex justify-center bg-neutral h-screen">
        <div class=" w-2/5 h-full flex flex-col justify-center">
            <div class="flex flex-col items-center justify-center">
                <a href="{{ url('/') }}">
                    <img src="{{ url('assets/logo.jpg') }}" class="border-2 w-24 rounded-full">
                    <span class="text-based font-bold text-primary ml-3">Beehive</span></a>
            </div>
            <form class=" bg-secondary shadow-md p-10 rounded-lg" method="post" action="">
                @csrf
                <h4 class="w-full text-3xl font-bold"> Signup</h4>
                <p class="text-lg text-gray-500">or, if you
                    have an account you can
                    <a href="{{ url('/login') }}" class="text-blue-600 underline" data-primary="blue-600">sign in</a>
                </p>
                <div class="w-full mt-5 space-y-3">
                    <div class="">
                        <div class="flex w-full gap-x-3">
                            <label class="font-medium text-gray-900 w-1/2">Email</label>
                            <label class="font-medium text-gray-900">Name</label>
                        </div>

                        <div class="flex gap-x-3">

                            <input type="text" name="email"
                                class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-primary="blue-600" data-rounded="rounded-lg" placeholder="Enter Your Email Address"
                                value="{{ old('email') }}" required />

                            <input type="text" name="name"
                                class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-primary="blue-600" data-rounded="rounded-lg" placeholder="Enter Your Name"
                                value="{{ old('name') }}"required />

                        </div>
                        <div class="flex gap-x-3">
                            <label class="label w-full">
                                @error('email')
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label w-full">
                                @error('name')
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="">
                        <div class="flex w-full gap-x-3">
                            <label class="font-medium text-gray-900 w-1/2">Password</label>
                            <label class="font-medium text-gray-900">Confirm Password</label>
                        </div>
                        <div class="flex">
                            <input type="password" name="password"
                                class="block w-1/2 mr-3 px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-primary="blue-600" data-rounded="rounded-lg" placeholder="Password" required />

                            <input type="password" name="confirm"
                                class="block w-1/2 px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-primary="blue-600" data-rounded="rounded-lg" placeholder="Confirm Password" required />

                        </div>

                        <div class="flex gap-x-3">
                            <label class="label w-full">
                                @error('password')
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </label>
                            <label class="label w-full">
                                @error('confirm')
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                    <div class="">
                    </div>

                    <div class="">
                        <label class="font-medium text-gray-900">Birthday</label>
                        <input type="date" name="birthday"
                            class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                            data-rounded="rounded-lg" value="{{ old('birthday') }}" />
                        @error('birthday')
                            <label class="label">
                                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                            </label>
                        @enderror
                    </div>
                    <div class="">
                        <label class="font-medium text-gray-900">Register as</label>
                        <select name="role"
                            class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                            data-primary="blue-600" data-rounded="rounded-lg">
                            {{-- <option value="1">Buyer</option>
                            <option value="2">Seller</option> --}}
                            <option value="1">Farmer (Buyer)</option>
                            <option value="2">BeeWorker (Seller)</option>
                        </select>
                    </div>
                    <div class="flex">
                        <input type="checkbox" name="tnc"
                            class="block mt-2 text-xl placeholder-gray-400 bg-gray-200  focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                            data-primary="blue-600" data-rounded="rounded-lg" required />
                        <label for="tnc" class="ml-3 mt-1">Accept Terms And Condition</label>
                    </div>
                    <div class="">
                        <button
                            class="inline-block w-full px-5 py-2 btn btn-success" >
                            Create Account
                        </button>
                        {{-- <a href=""
                            class="inline-block w-full px-5 py-2 mt-3 text-lg font-bold text-center text-gray-900 transition duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 ease"
                            data-rounded="rounded-lg">Sign up with Google</a> --}}
                    </div>

                </div>
            </form>

        </div>
    </div>
@endsection
