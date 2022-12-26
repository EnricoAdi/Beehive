@extends('layout.master')
@section('title', 'Change Password')
@section('body')
    <div class="flex justify-center h-screen">

        <div class="mt-8">
            <div class="ml-20">
                <img src="{{ url('assets/logo.jpg') }}" class="border-2 w-24 rounded-full">
                <span class="text-based font-bold text-primary ml-3">Beehive</span>
            </div><br>

            <form action="" method="post">
                @csrf
                    <div class="block p-6 rounded-lg shadow-lg bg-primary max-w-md mt-10 w-96">
                        <div class="text-lg font-bold text-center mb-6  text-whiteColor"><br> Enter Your New Password
                            </div>
                        <div class="">
                            <input type="password" name="password"
                                class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-primary="blue-600" data-rounded="rounded-lg" required placeholder="Input password" />
                        </div> <br>
                        <div class="">
                            <input type="password" name="confirm"
                                class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-primary="blue-600" data-rounded="rounded-lg"  required placeholder="Input conirmation password" />
                        </div> <br>

                        <button
                            class="inline-block w-full px-5 py-2 text-lg font-medium text-center text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 ease"
                            data-primary="blue-600" data-rounded="rounded-lg">
                            Change!
                        </button>

                    </div>
            </form>
        </div>

    </div>
@endsection
