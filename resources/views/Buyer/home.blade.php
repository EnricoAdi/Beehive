@extends('Buyer.layout.masterapp')
@section('title', 'Home Buyer Beehive')

@section('content')
    {{-- JB --}}
    <div class="flex flex-col gap-3 py-5 px-10 overflow-y-auto">
        <div class="flex gap-5 w-full">
            <div class="card bg-secondary w-3/4 shadow-md">
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Popular Categories</h2>
                    <div class="flex gap-x-3 flex-wrap gap-y-2">
                        <a href="{{ url('/buyer/sting/category/1') }}"
                            class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl cursor-pointer">
                            <img src="https://fiverr-res.cloudinary.com/npm-assets/@fiverr/logged_out_homepage_perseus/apps/programming.9362366.svg"
                                style="width: 80px; height: 80px;" alt="Programming &amp; Tech" loading="lazy">
                            <h2 class="card-title">Programming</h2>
                        </a>
                        <a href="{{ url('/buyer/sting/category/2') }}"
                            class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl cursor-pointer">
                            <img src="https://fiverr-res.cloudinary.com/npm-assets/@fiverr/logged_out_homepage_perseus/apps/video-animation.f0d9d71.svg"
                                style="width: 100px; height: 80px;" alt="Video &amp; Animation" loading="lazy">
                            <h2 class="card-title">Editor</h2>
                        </a>
                        <a href="{{ url('/buyer/sting/category/3') }}"
                            class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl cursor-pointer">
                            <img src="https://fiverr-res.cloudinary.com/npm-assets/@fiverr/logged_out_homepage_perseus/apps/writing-translation.32ebe2e.svg"
                                style="width: 80px; height: 80px;" alt="Writing &amp; Translation" loading="lazy">
                            <h2 class="card-title">Writer</h2>
                        </a>
                        <a href="{{ url('/buyer/sting/category/4') }}"
                            class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl cursor-pointer">
                            <img src="https://fiverr-res.cloudinary.com/npm-assets/@fiverr/logged_out_homepage_perseus/apps/music-audio.320af20.svg"
                                style="width: 80px; height: 80px;" alt="Music &amp; Audio" loading="lazy">
                            <h2 class="card-title">Voice Actor</h2>
                        </a>
                        <a href="{{ url('/buyer/sting/category/5') }}"
                            class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl cursor-pointer">
                            <img src="https://fiverr-res.cloudinary.com/npm-assets/@fiverr/logged_out_homepage_perseus/apps/graphics-design.d32a2f8.svg"
                                style="width: 80px; height: 80px;" alt="Graphics &amp; Design" loading="lazy">
                            <h2 class="card-title">Illustrator</h2>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card w-1/4 text-black bg-coffee bg-secondary h-full shadow-md">
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Active Sting</h2>
                    <div class="content-center">
                        @if ($onGoing != null)
                            <a href="{{ url('/buyer/sting/ordered/detail/' . $onGoing->ID_TRANSACTION) }}"
                                class="btn btn-primary text-base-100 mt-3"> To Active Sting
                                {{ '[' . $onGoing->ID_TRANSACTION . ']' }}</a>
                        @else
                            <div class="btn btn-error text-black mt-3">No Active Stings Found</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full rounded-xl bg-secondary text-black bg-coffee px-10 shadow-md">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Recomended Sting For You</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-5 p-1">
                    @foreach ($listSting as $s)
                        <div class="h-full flex flex-col justify-between max-w-sm p-6 rounded-lg shadow-gray-300 bg-primary hover:bg-primary-focus hover:text-base-100 hover:shadow-none cursor-pointer text-white"
                            onclick="redirect('{{ $s->ID_STING }}')">
                            <div class="flex space-x-2>
                                @php
                                    $pic = $s->author->PICTURE;
                                @endphp
                                @if (env('APP_ENV') == 'production')
                                    <img alt="" src="{{ asset("profile-pictures/$pic") }}"
                                        class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                                @else
                                    <img alt="" src="{{ asset("storage/profile-pictures/$pic") }}"
                                        class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                                @endif
                                <div class="flex flex-col items-center justify-center">
                                    <a rel="noopener noreferrer" href="#"
                                        class="text-md font-semibold">{{ $s->author->NAMA }}</a>
                                </div>
                            </div>
                            <div class="">
                                @if (env('APP_ENV') == 'production')
                                    <img src="{{ asset("sting-thumbnails/$s->NAMA_THUMBNAIL") }}" alt="Thumbnail Sting"
                                        class="object-cover w-full mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                                @else
                                    <img src="{{ asset("storage/sting-thumbnails/$s->NAMA_THUMBNAIL") }}"
                                        alt="Thumbnail Sting"
                                        class="object-cover w-full mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                                @endif
                                <div class="flex justify-between items-center">
                                    <h2 class="mb-1 text-md font-semibold text-start truncate">{{ $s->TITLE_STING }}</h2>
                                    <div class="flex gap-1 items-center">
                                        <i class="fa-solid fa-star"></i>
                                        <span>{{ $s->RATING }}</span>
                                    </div>
                                </div>
                                <p class="text-sm text-start">{{ $s->DESKRIPSI }}</p>
                            </div>
                            <div class="w-full flex items-center mt-3 gap-x-1">
                                @foreach ($s->sting_category as $c)
                                    <span class="badge font-semibold">{{ $c->category->NAMA_CATEGORY }}</span>
                                @endforeach
                            </div>
                            <div class="flex text-lg bottom-0">
                                <span>Starting at&nbsp;</span>
                                <div class="font-semibold">{{ 'Rp' . number_format($s->PRICE_BASIC, 2, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <div class="w-full flex gap-5">
        <div class="card w-1/3 bg-secondary text-black bg-coffee shadow-md">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Most Ordered Sting</h2>
                <p class="mt-10">{{$mostBought}}</p>
            </div>
        </div>
        <div class="card w-1/3 bg-secondary text-black bg-coffee shadow-md">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Total Lelang Sting diambil</h2>
                <p class="mt-10">{{$jumlahLelang}} Lelang</p>
            </div>
        </div>
        <div class="card w-1/3 bg-secondary text-black bg-coffee shadow-md">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Jumlah Transaksi Pemasukkan Anda Dalam Rupiah</h2>
                <p class="mt-10">{{"Rp" . number_format($pendapatan ,2,',','.')}}</p>
            </div>
        </div>
    </div> --}}
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        // Untuk click ke detail sting, mungkin berubah
        function redirect(param) {
            let navigator = "{{ url('/') }}";
            // window.location.href = `/buyer/sting/${param}`;
            window.location.href = navigator + "/buyer/sting/" + param;
        }
    </script>
@endsection
