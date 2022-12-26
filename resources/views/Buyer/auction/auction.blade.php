@extends('Buyer.layout.masterapp')
@section('title', "BeeQueen's Auction")

@section('content')
    <input type="checkbox" id="modalSubscribe" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Beehive</h3>
            <p class="py-4">You dont have access to this feature</p>
            <div class="modal-action">
                <a href="{{ url('/buyer/subscribe') }}" class="btn btn-success mt-6 shadow-md">Upgrade Now</a>
            </div>
        </div>
    </div>
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Beequeen's Auction </h1>
    <div class="ml-20">
        @if ($user->SUBSCRIBED == 0)
            <button class="btn btn-secondary w-24 mt-5 blur-sm cursor-default">Create</button>
        @else
            <a href="{{ url('/buyer/auction/make') }}" class="btn btn-secondary w-24 mt-5">Create</a>
        @endif

        <h1 class="text-3xl mt-5 font-semibold block  @if ($user->SUBSCRIBED == 0) blur-sm @endif">Auction waiting for
            beeworker </h1>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5  @if ($user->SUBSCRIBED == 0) blur-sm @endif">
            @forelse ($auctionPending as $key => $auction)
                @php
                    $pic = $auction->farmer->PICTURE;
                @endphp
                <div data-modal-toggle="detail-modal-{{ $auction->ID_LELANG_STING }}"
                    class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-primary hover:bg-primary-focus text-base-100 hover:shadow-none">
                    <div class="flex space-x-4">
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img src="{{ asset("storage/profile-pictures/$pic") }}"
                                alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-lg font-semibold">{{ $auction->farmer->NAMA }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-xl font-semibold"></h2>
                        </div>
                        <p class="text-sm">{{ $auction->REQUIREMENT_PROJECT }}</p>
                    </div>
                    <div class="text-lg">
                        Rp {{ $auction->COMMISION }}
                    </div>
                    <div class="text-md">Since {{ date_format(date_create($auction->CREATED_AT), 'd M Y') }}
                    </div>
                    <div class="pt-4 pb-2">
                        @foreach ($auction->lelang_category as $c)
                        <span
                            class="inline-block bg-gray-300 rounded-full px-3 py-1
                                text-sm font-semibold text-gray-700 mr-2 mb-2">
                            {{$c->category->NAMA_CATEGORY}}</span>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                    <h2>Belum Ada Lelang!</h2>
                </div>
            @endforelse
        </div>

        <h1 class="text-3xl mt-5 font-semibold block  @if ($user->SUBSCRIBED == 0) blur-sm @endif">Auction on progress
        </h1>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5  @if ($user->SUBSCRIBED == 0) blur-sm @endif">
            @forelse ($auctionProgress as $key => $auction)
                @php
                    $pic = $auction->farmer->PICTURE;
                @endphp
                <div data-modal-toggle="detail-modal-{{ $auction->ID_LELANG_STING }}"
                    class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-primary hover:bg-primary-focus text-base-100 hover:shadow-none">
                    <div class="flex space-x-4">
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img src="{{ asset("storage/profile-pictures/$pic") }}"
                                alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-lg font-semibold">{{ $auction->farmer->NAMA }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-xl font-semibold"></h2>
                        </div>
                        <p class="text-sm">{{ $auction->REQUIREMENT_PROJECT }}</p>
                    </div>
                    <div class="text-lg">
                        Rp {{ $auction->COMMISION }}
                    </div>
                    <div class="text-md">Since {{ date_format(date_create($auction->CREATED_AT), 'd M Y') }}
                    </div>

                    <div class="pt-4 pb-2">
                        @foreach ($auction->lelang_category as $c)
                            <span
                                class="inline-block bg-gray-300 rounded-full px-3 py-1
                        text-sm font-semibold text-gray-700 mr-2 mb-2">
                                {{ $c->category->NAMA_CATEGORY }}</span>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                    <h2>Belum Ada Lelang!</h2>
                </div>
            @endforelse


        </div>


        <h1 class="text-3xl mt-5 font-semibold block  @if ($user->SUBSCRIBED == 0) blur-sm @endif">Auction done</h1>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5  @if ($user->SUBSCRIBED == 0) blur-sm @endif">
            @forelse ($auctionDone as $key => $auction)
                @php
                    $pic = $auction->farmer->PICTURE;
                @endphp
                <div data-modal-toggle="detail-modal-{{ $auction->ID_LELANG_STING }}"
                    class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-primary hover:bg-primary-focus text-base-100 hover:shadow-none">
                    <div class="flex space-x-4">
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img src="{{ asset("storage/profile-pictures/$pic") }}"
                                alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-lg font-semibold">{{ $auction->farmer->NAMA }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-xl font-semibold"></h2>
                        </div>
                        <p class="text-sm">{{ $auction->REQUIREMENT_PROJECT }}</p>
                    </div>
                    <div class="text-lg">
                        Rp {{ $auction->COMMISION }}
                    </div>
                    <div class="text-lg">Since {{ date_format(date_create($auction->CREATED_AT), 'd M Y') }}
                    </div>
                    <div class="pt-4 pb-2">
                        @foreach ($auction->lelang_category as $c)
                        <span
                            class="inline-block bg-gray-300 rounded-full px-3 py-1
                                text-sm font-semibold text-gray-700 mr-2 mb-2">
                            {{$c->category->NAMA_CATEGORY}}</span>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                    <h2>Belum Ada Lelang!</h2>
                </div>
            @endforelse
        </div>


        <h1 class="text-3xl mt-5 font-semibold block  @if ($user->SUBSCRIBED == 0) blur-sm @endif">Auction Canceled
        </h1>
        <div
            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5  @if ($user->SUBSCRIBED == 0) blur-sm @endif">
            @forelse ($auctionCanceled as $key => $auction)
                @php
                    $pic = $auction->farmer->PICTURE;
                @endphp
                <div data-modal-toggle="detail-modal-{{ $auction->ID_LELANG_STING }}"
                    class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-primary hover:bg-primary-focus text-base-100 hover:shadow-none">
                    <div class="flex space-x-4">
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img src="{{ asset("storage/profile-pictures/$pic") }}"
                                alt="Picture of {{ $auction->farmer->NAMA }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-lg font-semibold">{{ $auction->farmer->NAMA }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-xl font-semibold"></h2>
                        </div>
                        <p class="text-sm">{{ $auction->REQUIREMENT_PROJECT }}</p>
                    </div>
                    <div class="text-lg">
                        Rp {{ $auction->COMMISION }}
                    </div>
                    <div class="text-lg">Since {{ date_format(date_create($auction->CREATED_AT), 'd M Y') }}
                    </div>
                </div>
            @empty
                <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                    <h2>Belum Ada Lelang!</h2>
                </div>
            @endforelse


        </div>

    </div>
@endsection

@section('modal')
    @foreach ($auctionPending as $order)
        @php
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -1) {
                $status = 'Deleted';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_LELANG_STING }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow-2xl dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="detail-modal-{{ $order->ID_LELANG_STING }}">

                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-white">
                        <h4 class="mb-4 text-md font-medium  ">{{ $order->ID_LELANG_STING }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium  ">
                            {{ $order->TITLE_STING }}</h3>

                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }} font-bold">Status : {{ $status }}
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-error"
                                onclick="decline('{{ $order->ID_LELANG_STING }}')">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($auctionProgress as $order)
        @php
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -1) {
                $status = 'Deleted';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_LELANG_STING }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow-2xl dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="detail-modal-{{ $order->ID_LELANG_STING }}">

                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-white">
                        <h4 class="mb-4 text-md font-medium  ">{{ $order->ID_LELANG_STING }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium  ">
                            {{ $order->TITLE_STING }}</h3>

                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }} font-bold">Status : {{ $status }}
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-secondary"
                                onclick="detail('{{ $order->ID_LELANG_STING }}')">Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    @foreach ($auctionDone as $order)
        @php
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -1) {
                $status = 'Deleted';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_LELANG_STING }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow-2xl dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="detail-modal-{{ $order->ID_LELANG_STING }}">

                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-white">
                        <h4 class="mb-4 text-md font-medium  ">{{ $order->ID_LELANG_STING }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium  ">
                            {{ $order->TITLE_STING }}</h3>

                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }} font-bold">Status : {{ $status }}
                        </div>
                        <div class="mt-2">
                            {{-- <button class="btn btn-secondary"
                                onclick="detail('{{ $order->ID_LELANG_STING }}')">Detail</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    @foreach ($auctionCanceled as $order)
        @php
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -1) {
                $status = 'Deleted';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_LELANG_STING }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow-2xl dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="detail-modal-{{ $order->ID_LELANG_STING }}">

                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-white">
                        <h4 class="mb-4 text-md font-medium  ">{{ $order->ID_LELANG_STING }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium  ">
                            {{ $order->TITLE_STING }}</h3>

                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }} font-bold">Status : {{ $status }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('script')
    @if ($user->SUBSCRIBED == 0)
        <script>
            document.getElementById('modalSubscribe').checked = true;
        </script>
    @endif
    <script type="text/javascript">
        function decline(param) {
            let ask = confirm("Apakah anda yakin untuk meng-cancel lelang sting ini?");
            if (ask) {
                let navigator = "{{ url('/') }}";
                window.location.href = navigator + "/buyer/auction/cancel/" + param;
            }

        }

        function detail(param) {
            let navigator = "{{ url('/') }}";
            window.location.href = navigator + "/buyer/auction/detail/" + param;
        }
    </script>
@endsection
