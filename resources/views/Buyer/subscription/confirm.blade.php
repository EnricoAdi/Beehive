@extends('Buyer.layout.masterapp')
@section('title', 'Upgrade Account Beehive')

@section('content')
    {{-- Enrico --}}
    <div class="flex justify-center h-screen">
        <div class="mt-8">
            @csrf
            <div class="block px-6 pb-6 rounded-lg shadow-lg bg-secondary max-w-md mt-4">

                <div class="p-5">

                    <div class="text-xl font-bold text-center">
                        You are about to buy a premium lifetime subscription</div>
                    <div class="text-lg text-center mb-4 "><br>
                        Just pay once, benefit forever
                    </div>

                    <form action="" method="post">
                        @csrf
                        <div class="flex-none mt-8 bg-white rounded-b rounded-t-none overflow-hidden shadow p-6 rounded-md">
                            <div class="w-full pt-6 text-4xl font-bold text-center">
                                Rp500.000
                            </div>
                            <div class="flex items-center justify-center">
                            </div>
                        </div>
                        <div class="text-sm font-semibold text-center mt-4">

                            <input type="radio" name="mode" class="radio-2" value="midtrans" /> Midtrans
                            <input type="radio" name="mode" class="radio-2 ml-4" value="credit" /> From Credit
                        </div>
                        <div class="text-center mt-2">Your Balance : {{"Rp" . number_format($user->BALANCE ,2,',','.')}}</div>
                        @error('mode')
                            <label class="label">
                                <span class="font-bold text-error text-lg ">{{ $message }}</span>
                            </label>
                        @enderror
                        <button
                            class="inline-block w-full btn btn-success transition duration-200 ease mt-3"  data-rounded="rounded-lg">
                            Subscribe Now!
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
