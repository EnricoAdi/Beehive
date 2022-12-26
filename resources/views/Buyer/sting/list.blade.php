@extends('Buyer.layout.masterapp')
@section('title', 'Sting Buyer Beehive')

@section('content')
    <div class="w-full px-2 py-3 overflow-y-auto">
        <br>
        <div class="bg-primary rounded-md p-3 mx-10">
            <form action='{{url("/buyer/sting")}}' method="POST" class="w-full flex justify-between rounded-md bg-primary items-end">
                @csrf
                <div class="form-control w-1/3 mr-3">
                    <label class="label">
                        <span class="label-text text-base-100">Nama Sting</span>
                    </label>
                    <input type="text" placeholder="Masukkan nama sting" name="nama" class="input input-bordered w-full" value="{{old("nama")}}" />
                </div>
                {{-- <div class="form-control w-full mr-3">
                    <label class="label">
                        <span class="label-text text-base-100">Category</span>
                    </label>
                    <select class="select select-bordered" name="category">
                        <option selected value="all">All</option>
                        @foreach ($listCategory as $c)
                            <option value="{{$c->ID_CATEGORY}}">{{$c->NAMA_CATEGORY}}</option>
                        @endforeach
                    </select>
                </div> --}}
                <button class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search!</button>
            </form>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10">
            @foreach ($listSting as $s)
                <div class="h-full flex flex-col max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-secondary hover:bg-primary-focus hover:text-base-100 hover:shadow-none cursor-pointer" onclick="redirect('{{$s->ID_STING}}')">
                    <div class="flex space-x-2">
                        @php
                            $pic = $s->author->PICTURE;
                        @endphp
                        @if (env("APP_ENV")=="production")
                            <img alt="" src="{{ asset("profile-pictures/$pic") }}" class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img alt="" src="{{ asset("storage/profile-pictures/$pic") }}" class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <a rel="noopener noreferrer" href="#" class="text-md font-semibold">{{$s->author->NAMA}}</a>
                        </div>
                    </div>
                    <div class="h-96">
                        @if (env("APP_ENV")=="production")
                            <img src="{{ asset("sting-thumbnails/$s->NAMA_THUMBNAIL") }}" alt="Thumbnail Sting" class="object-cover w-full mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @else
                            <img src="{{ asset("storage/sting-thumbnails/$s->NAMA_THUMBNAIL") }}" alt="Thumbnail Sting" class="object-cover w-full mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @endif
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-md font-semibold truncate">{{$s->TITLE_STING}}</h2>
                            <div class="flex gap-1 items-center">
                                <i class="fa-solid fa-star"></i>
                                <span>{{$s->RATING}}</span>
                                <span>({{sizeof($s->doneTransaction)}})</span>
                            </div>
                        </div>
                        <p class="text-sm">{{$s->DESKRIPSI}}</p>
                    </div>
                    <div class="w-full flex items-center mt-3 gap-x-1">
                        @foreach ($s->sting_category as $c)
                            <span class="badge font-semibold">{{$c->category->NAMA_CATEGORY}}</span>
                        @endforeach
                    </div>
                    <div class="flex text-lg bottom-0">
                        <span>Starting at&nbsp;</span>
                        <div class="font-semibold">{{"Rp" . number_format($s->PRICE_BASIC ,2,',','.')}}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    <script type="text/javascript">
    // Untuk click ke detail sting, mungkin berubah
        function redirect(param) {
        let navigator = "{{ url('/') }}";
        // window.location.href = `/buyer/sting/${param}`;
        window.location.href = navigator + "/buyer/sting/" + param;
        }
    </script>
@endsection
