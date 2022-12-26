@extends('Buyer.layout.masterapp')
@section('title', 'Sting Owner Beehive')

@section('content')
    <div class="h-full">
        <a href="{{ url("buyer/sting/$id") }}" class="btn btn-error capitalize mt-5 ml-20 w-24">Back</a> <br>

        <h1 class="text-3xl ml-20 mt-5 font-semibold block">Sting Owner</h1>
        <div class="flex  gap-x-4">

            <div class="text-lg ml-20 mt-7 flex gap-x-7 w-1/2 shadow-xl bg-secondary p-8">
                <div class="">
                    @if (env('APP_ENV') == 'production')
                        <img src="{{ asset("profile-pictures/$author->PICTURE") }}" alt="Picture of {{ $author->NAMA }}"
                            class="w-36 shadow-lg ">
                    @else
                        <img src="{{ asset("storage/profile-pictures/$author->PICTURE") }}"
                            alt="Picture of {{ $author->NAMA }}" class="w-36 shadow-lg ">
                    @endif
                </div>
                <div>
                    <div class="flex gap-1 items-center">
                        <span>{{ $author->NAMA }}</span>
                    </div>
                    <div class="flex gap-1 items-center mt-2">
                        <i class="fa-solid fa-star"></i>
                        <span>{{ $rating }} ({{ $jumlahPemberiRating }})</span>
                    </div>
                    <div class="flex gap-1 items-center mt-2">
                        <span>Member since {{ $joinDate }}</span>
                    </div>
                    <div class="flex gap-1 items-center mt-2">
                        <span>Expertize in in
                            <ul class="list-disc ml-5">
                                @foreach ($categoryInvolve as $c)
                                    <li> {{ $c }}</li>
                                @endforeach
                            </ul>

                        </span>
                    </div>
                    <hr class="mt-3 mb-3 bg-gray-400 h-1 w-full">
                    <div class="flex gap-1 items-center">
                        <span>{{ $author->BIO }}</span>
                    </div>
                </div>
            </div>

            <div class="text-md ml-20 mt-7 w-1/3 shadow-xl bg-secondary p-8 h-96 overflow-y-auto">

                <div class="text-lg">Some Reviews</div>

                @forelse ($reviews as $r)
                    <div class="flex gap-x-3 mt-4 ">
                        <div>
                            @if (env('APP_ENV') == 'production')
                                <img src="{{ asset("profile-pictures/$r->PICTURE") }}"
                                    alt="Picture of {{ $r->NAMA }}" class="w-14 shadow-lg ">
                            @else
                                <img src="{{ asset("storage/profile-pictures/$r->PICTURE") }}"
                                    alt="Picture of {{ $r->NAMA }}" class="w-14 shadow-lg ">
                            @endif
                        </div>
                        <div>
                            <div class="font-bold">{{ $r->NAMA }}</div>
                            <div>{{ $r->REVIEW }}</div>
                        </div>
                    </div>
                    <hr class="h-1 bg-gray-300 mt-3">
                @empty
                    <div>Belum ada review untuk Beeworker ini</div>
                @endforelse

            </div>
        </div>
    </div>
@endsection
