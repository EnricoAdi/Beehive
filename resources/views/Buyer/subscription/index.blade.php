@extends('Buyer.layout.masterapp')
@section('title', 'Upgrade Account Beehive')

@section('content')
    {{-- Enrico --}}
    <div class="flex justify-center h-screen">
        <div class="mt-8">
                @csrf
                <div class="block px-6 pb-6 rounded-lg shadow-lg bg-secondary max-w-md mt-4">
                    @if ($user->SUBSCRIBED==1)

                    <div class="text-2xl font-bold text-center p-10">You're a BeeQueen👑</div>
                    <div class="text-lg text-center p-5">You have subscribed on {{ date_format(date_create($user->SUBSCRIBED_AT), 'd M Y')}}</div>
                    @else

                    <div class="text-2xl font-bold text-center"><br> Get your account to next Level!</div>
                    <div class="text-lg text-center mb-6 "><br>
                        Unlock Auction Sting and grow your project more!
                    </div>

                    <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6 rounded-md">
                        <div class="w-full pt-6 text-4xl font-bold text-center">
                            Rp500.000
                            <span class="text-base">/per user</span>
                        </div>
                        <div class="flex items-center justify-center">
                        </div>
                    </div>
                    <a href="{{url("/buyer/subscribe/confirm")}}">

                    <button
                        class="inline-block w-full btn btn-success transition duration-200  ease mt-3"
                        data-primary="blue-600" data-rounded="rounded-lg">
                        Subscribe Now!
                    </button>
                    </a>
                    @endif

                </div>
        </div>
    </div>
@endsection
