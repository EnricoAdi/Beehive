@extends('layout.master')
@section('title', 'Email Sended!')
@section('body')
    <div class="flex justify-center h-screen">

        <div class="mt-8">
            <div class="ml-20">
                <img src="{{ url('assets/logo.jpg') }}" class="border-2 w-24 rounded-full">
                <span class="text-based font-bold text-primary ml-3">Beehive</span>
            </div><br>

            <div class="block p-6 rounded-lg shadow-lg bg-secondary max-w-md mt-10 w-96">
                <div class="text-lg font-bold text-center mb-6  text-black"><br> Email Has been sended!</div>

            </div>
        </div>

    </div>
@endsection
