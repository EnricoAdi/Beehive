@extends('Seller.layout.masterapp')
@section('title', 'Sting Beeworker Beehive')

@section('content')

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10">

    @forelse ($stings as $s)
    <div class="h-full cursor-pointer flex flex-col max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-secondary hover:bg-primary-focus hover:text-base-100 hover:shadow-none" onclick="redirect('{{$s->ID_STING}}')">
            <div class="flex space-x-2">
                @if (env("APP_ENV")=="production")
                    <img alt="" src="{{ asset("profile-pictures/$user->PICTURE") }}" alt="" class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                @else
                    <img alt="" src="{{ asset("storage/profile-pictures/$user->PICTURE") }}" alt="" class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                @endif
                <div class="flex flex-col items-center justify-center">
                <a rel="noopener noreferrer" href="#" class="text-lg font-semibold">{{$user->NAMA}}</a>
                </div>
            </div>
            <div>
                @if (env("APP_ENV")=="production")
                    <img src="{{ asset("sting-thumbnails/$s->NAMA_THUMBNAIL") }}" alt="" class="object-cover w-full mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                @else
                    <img src="{{ asset("storage/sting-thumbnails/$s->NAMA_THUMBNAIL") }}" alt="" class="object-cover w-full mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                @endif
                <div class="flex justify-between">
                <h2 class="mb-1 text-xl font-semibold">{{$s->TITLE_STING}}</h2>
                    <div class="flex gap-1 items-center">
                        <i class="fa-solid fa-star"></i>
                        <span>{{$s->RATING}}</span>
                        <span>({{sizeof($s->doneTransaction)}})</span>
                    </div>
                </div>
                <p class="text-sm">{{$s->DESKRIPSI}}</p>
            </div>
            <div >
                <span>Basic Price&nbsp;</span>
                <span>Rp {{$s->PRICE_BASIC}}</span> <br>
                <span>Basic Revision&nbsp;</span>
                <span>{{$s->MAX_REVISION_BASIC}}</span>
            </div>
            <div >
                <span>Premium Price&nbsp;</span>
                <span>Rp {{$s->PRICE_PREMIUM}}</span> <br>
                <span>Premium Revision&nbsp;</span>
                <span>{{$s->MAX_REVISION_PREMIUM}}</span>
            </div>

            <div class="pt-4 pb-2">
                @foreach ($s->sting_category as $c)
                <span
                    class="inline-block bg-gray-300 rounded-full px-3 py-1
                        text-sm font-semibold text-gray-700 mr-2 mb-2">
                    {{$c->category->NAMA_CATEGORY}}</span>
                @endforeach
            </div>
        </div>
        @empty
        <div class="bg-red-100 rounded-lg p-8 text-base text-red-700 mb-3" role="alert">
            <h2>Belum Ada Sting Yang Anda Upload!</h2>
        </div>
    @endforelse
</div>

    <script type="text/javascript">
    // Untuk click ke detail sting, mungkin berubah
        function redirect(param) {
            let navigator = "{{ url('/') }}";
        window.location.href = `${navigator}/seller/sting/edit/${param}`;
        }
    </script>

@endsection
