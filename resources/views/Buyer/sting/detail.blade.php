@extends('Buyer.layout.masterapp')
@section('title', 'Sting Farmer Beehive')

@section('content')


    <div class="p-10 flex flex-col gap-3 w-full text-base-100 overflow-y-auto">
        <a href="{{ url('/buyer/sting') }}" class="btn btn-secondary w-28">Back</a>
        <div class="flex gap-3">
            <div class="w-2/3 shadow-lg shadow-gray-300 rounded-lg flex flex-col">
                <div class="text-xl font-semibold flex flex-col gap-2 bg-primary p-5 rounded-t-lg">
                    <div class="flex items-center justify-between">
                        <div>{{ $sting->TITLE_STING }}</div>
                        <div class="flex gap-1 items-center">
                            <i class="fa-solid fa-star"></i>
                            <span>{{ $sting->RATING }}</span>
                            <span>({{sizeof($sting->doneTransaction)}})</span>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        @php
                            $pic = $sting->author->PICTURE;
                        @endphp
                        @if (env('APP_ENV') == 'production')
                            <a href="{{ url("/buyer/sting/owner/$id") }}" >
                                <img alt="" src="{{ asset("profile-pictures/$pic") }}"
                                    class="object-cover w-10 h-10 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                            </a>
                        @else
                            <a href="{{ url("/buyer/sting/owner/$id") }}" >
                                <img alt="" src="{{ asset("storage/profile-pictures/$pic") }}"
                                    class="object-cover w-10 h-10 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                            </a>
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <a rel="noopener noreferrer" href="{{ url("/buyer/sting/owner/$id") }}"
                                class="text-sm hover:text-gray-300">{{ $sting->author->NAMA }}</a>
                        </div>

                    </div>

                    <div class="pt-4 pb-2">
                        @foreach ($sting->sting_category as $c)
                            <span class="badge font-semibold">{{$c->category->NAMA_CATEGORY}}</span>
                        @endforeach
                    </div>
                </div>
                <div class="p-5 bg-base-100 w-full rounded-b-lg text-black flex flex-col gap-5">
                    <div class="carousel w-full rounded-md shadow-lg shadow-gray-400 mb-5">
                        @php
                            $no = 1;
                        @endphp
                        @forelse ($foto as $f)
                            <div id="slide{{$no}}" class="carousel-item relative w-full">
                                @if (env("APP_ENV")=="production")
                                    <img src="{{ asset("sting-media/$f->FILENAME") }}" class="w-full" />
                                @else
                                    <img src="{{ asset('storage/sting-media/gambar12.jpg') }}" class="w-full" />
                                @endif
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    @php
                                        $a = $no - 1;
                                        $b = $no + 1;
                                    @endphp
                                    @if ($no == 1)
                                        <a href="#slide{{count($foto)}}" class="btn btn-circle">❮</a>
                                        <a href="#slide{{$b}}" class="btn btn-circle">❯</a>
                                    @elseif ($no == count($foto))
                                        <a href="#slide{{count($foto) - 1}}" class="btn btn-circle">❮</a>
                                        <a href="#slide1" class="btn btn-circle">❯</a>
                                    @else
                                        <a href="#slide{{$a}}" class="btn btn-circle">❮</a>
                                        <a href="#slide{{$b}}" class="btn btn-circle">❯</a>
                                    @endif

                                </div>
                            </div>
                            @php
                                $no += 1;
                            @endphp
                        @empty
                            <div id="slide1" class="carousel-item relative w-full">
                                <img src="{{ url('assets/bg/gambar12.jpg') }}" class="w-full" />
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide3" class="btn btn-circle">❮</a>
                                    <a href="#slide2" class="btn btn-circle">❯</a>
                                </div>
                            </div>
                            <div id="slide2" class="carousel-item relative w-full">
                                <img src="{{ url('assets/bg/gambar13.jpg') }}" class="w-full" />
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide1" class="btn btn-circle">❮</a>
                                    <a href="#slide3" class="btn btn-circle">❯</a>
                                </div>
                            </div>
                            <div id="slide3" class="carousel-item relative w-full">
                                <img src="{{ url('assets/bg/gambar16.png') }}" class="w-full" />
                                <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                                    <a href="#slide2" class="btn btn-circle">❮</a>
                                    <a href="#slide1" class="btn btn-circle">❯</a>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <div>
                        <div class="text-lg font-semibold">Deskripsi</div>
                        <div>
                            {{ $sting->DESKRIPSI }}
                        </div>
                    </div>
                    <a href="{{ url("/buyer/sting/$kode/buy?mode=Premium") }}" class="btn btn-primary shadow-md text-white">Buy Premium
                        Sting!</a>
                    <a href="{{ url("/buyer/sting/$kode/buy?mode=Basic") }}" class="btn btn-secondary shadow-md">Buy Basic
                        Sting!</a>

                </div>
            </div>
            {{-- <div class="w-1/3 rounded-lg shadow-lg shadow-gray-400 p-5"> --}}
            <div class="w-1/3">
                <div class="bg-accent h-fit rounded-lg shadow-lg shadow-gray-300 p-5 sticky top-0 text-black">
                    <div class="flex flex-col gap-3 h-1/2">
                        <div class="text-lg font-semibold">Plans</div>
                        <div class="flex flex-col gap-3">
                            <details class="w-full border border-secondary rounded-lg" open>
                                <summary class="p-4 focus:outline-none focus-visible:ring-violet-400">Premium</summary>
                                <p class="px-4 py-6 pt-0 ml-4 -mt-4 text-black">
                                    {{ $sting->DESKRIPSI_PREMIUM }}
                                    <br><br>
                                    <span class="font-semibold text-lg">Price:
                                        {{ 'Rp' . number_format($sting->PRICE_PREMIUM, 2, ',', '.') }}</span>
                                </p>
                            </details>
                            <details class="w-full border border-secondary rounded-lg">
                                <summary class="px-4 py-6 focus:outline-none focus-visible:ring-violet-400">Basic</summary>
                                <p class="px-4 py-6 pt-0 ml-4 -mt-4 text-black">
                                    {{ $sting->DESKRIPSI_BASIC }}
                                    <br><br>
                                    <span class="font-semibold text-lg">Price:
                                        {{ 'Rp' . number_format($sting->PRICE_BASIC, 2, ',', '.') }}</span>
                                </p>
                            </details>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
