@extends('Buyer.layout.masterapp')
@section('title', 'Buy Sting Beehive')

@section('content')
    <h1 class="text-3xl ml-20 mt-5 font-bold block  ">Order A Sting</h1>
    <a href="{{ url("/buyer/sting/$kode") }}" class="btn btn-secondary ml-20 w-24 mt-5">Back</a>
    <form method="POST" class="mt-5 ml-20 flex gap-3 ">
        @csrf
        <div class="p-5 bg-secondary shadow-md rounded-md
        w-3/4">
            <h2 class="card-title">{{ $sting->TITLE_STING }}</h2>
            <div class="mt-2">By {{ $sting->author->NAMA }} </div>
            <div class="flex gap-1 items-center mt-2">
                <i class="fa-solid fa-star"></i>
                <span>{{$sting->RATING}}</span>
            </div>
            <div class="mt-2">{{ $mode }} Service</div>
            <div class="mt-2">"{{ strtolower($mode) == 'premium' ? $sting->DESKRIPSI_PREMIUM : $sting->DESKRIPSI_BASIC }}"
            </div>
            <div class="font-bold mt-2">
                {{ strtolower($mode) == 'premium'
                    ? 'Rp' . number_format($sting->PRICE_PREMIUM, 2, ',', '.')
                    : 'Rp' . number_format($sting->PRICE_BASIC, 2, ',', '.') }}
            </div>

            @php
                $textalertcolor = '';
                $prices = strtolower($mode) == 'premium' ? $sting->PRICE_PREMIUM : $sting->PRICE_BASIC;
                if ($user->BALANCE < $prices) {
                    $textalertcolor = 'text-red-800';
                }
            @endphp
            <div class="mt-2 {{ $textalertcolor }}">Your Balance : {{ 'Rp' . number_format($user->BALANCE, 2, ',', '.') }}
            </div>

            <textarea name="REQUIREMENT_PROJECT"
            class="input input-primary border-1 rounded-md px-4 py-2 mt-5 w-full h-32"
                required placeholder="Input your project requirement!"></textarea>
            @error('REQUIREMENT_PROJECT')
                <label class="label">
                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                </label>
            @enderror
            <br>
            <button class="btn btn-success w-full mt-3 shadow-md">Buy Sting!</button>
    </form>
    </div>
@endsection
