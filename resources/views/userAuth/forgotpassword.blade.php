@extends('layout.master')
@section('title', 'Forgot Password')
@section('body')
    <div class="flex justify-center h-screen">

        <div class="mt-8">
            <div class="ml-20">
                <a href="{{ url('/') }}">
                <img src="{{ url('assets/logo.jpg') }}" class="border-2 w-24 rounded-full">
                <span class="text-based font-bold text-primary ml-3">Beehive</span>
                </a>
            </div><br>

            <form action="" method="post">
                @csrf
                @if($already)
                <div class="block p-6 rounded-lg shadow-lg bg-secondary max-w-md mt-10 w-96">
                    <div class="text-lg font-bold text-center mb-6  text-whiteColor"><br> Email Sended!</div>

                </div>
                @else
            <div class="block p-6 rounded-lg shadow-lg bg-secondary max-w-md mt-10 w-96">
                <div class="text-lg font-bold text-center mb-6"><br> Enter Your Email For Reset Password</div>
                <div class="">
                    <input type="email" name="email"
                        class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                        data-primary="blue-600" data-rounded="rounded-lg" placeholder="..@something.com"
                        value="{{ old('email') }}" required />
                </div> <br>

                <button
                class="inline-block w-full px-5 py-2 btn btn-success shadow-md" >
                Send Email!
            </button>

            </div>
                @endif
            </form>
        </div>

    </div>
@endsection
