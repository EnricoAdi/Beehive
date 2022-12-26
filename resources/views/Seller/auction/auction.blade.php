@extends('Seller.layout.masterapp')
@section('title', 'Auction BeeWorker Beehive')

@section('content')
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Auction For Beeworker</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5 ml-10">
        @if (count($arrLelang) == 0)
            <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                <h2>Belum Ada Sting Yang Dilelang!</h2>
            </div>
        @else
            @foreach ($arrLelang as $key => $lelang)
                <div data-modal-toggle="detail-modal-{{ $lelang->ID_LELANG_STING }}"
                    class="flex cursor-pointer flex-col max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-primary
                    hover:bg-primary-focus text-base-100 hover:shadow-none">
                    <div class="flex space-x-4">
                        @php
                            $pic = $lelang->PICTURE;
                        @endphp
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("profile-pictures/$pic") }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img src="{{ asset("storage/profile-pictures/$pic") }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-lg font-semibold">{{ $lelang->NAMA }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-xl font-semibold">{{ $lelang->TITLE_STING }}</h2>
                        </div>
                        <p class="text-sm">{{ $lelang->REQUIREMENT_PROJECT }}</p>
                    </div>
                    <div class="flex text-lg">
                        <span>Starting at&nbsp;</span>
                        <div>Rp {{ $lelang->COMMISION }}</div>
                    </div>
                    <div class="pt-4 pb-2">
                        {{-- @foreach ($lelang->lelang_category as $c)
                        @endforeach --}}
                        <span
                            class="inline-block bg-gray-300 rounded-full px-3 py-1
                                text-sm font-semibold text-gray-700 mr-2 mb-2">
                            {{ $lelang->NAMA_CATEGORY }}</span>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Accepted Auction</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5 ml-10">
        @if (count($onProgressLelang) == 0)
            <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                <h2>Belum Ada Lelang Sting yang diterima!</h2>
            </div>
        @else
            @foreach ($onProgressLelang as $lelang)
                <div data-modal-toggle="detail-modal-{{ $lelang->ID_LELANG_STING }}"
                    class="flex flex-col max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 bg-primary hover:bg-primary-focus text-base-100 hover:shadow-none">
                    <div class="flex space-x-4">
                        @php
                            $pic = $lelang->farmer->PICTURE;
                        @endphp
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("profile-pictures/$pic") }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @else
                            <img src="{{ asset("storage/profile-pictures/$pic") }}"
                                class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                        @endif
                        <div class="flex flex-col items-center justify-center">
                            <div class="text-lg font-semibold">{{ $lelang->NAMA }}</div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between">
                            <h2 class="mb-1 text-xl font-semibold">{{ $lelang->TITLE_STING }}</h2>
                        </div>
                        <p class="text-sm">{{ $lelang->REQUIREMENT_PROJECT }}</p>
                    </div>
                    <div class="flex text-lg">
                        <span>Starting at&nbsp;</span>
                        <div>Rp {{ $lelang->COMMISION }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
@section('modal')
    @foreach ($arrLelang as $order)
        @php
            $status = '';
            $statusColor = '';
            if ($order->LELANGSTATUS == -1) {
                $status = 'Deleted';
                $statusColor = 'text-red-600';
            } elseif ($order->LELANGSTATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->LELANGSTATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->LELANGSTATUS == 2) {
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
                            <button class="btn btn-success" onclick="accept('{{ $order->ID_LELANG_STING }}')">Take</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($onProgressLelang as $order)
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
@endsection

@section('script')
    <script>
        function accept(id) {
            let navigator = "{{ url('/') }}";
            let conf = confirm("Apakah anda yakin untuk mengambil lelang sting ini?");
            if (conf) {
                window.location.href = navigator + "/seller/auction/take/" + id;
            }
        }

        function detail(id) {
            let navigator = "{{ url('/') }}";
            window.location.href = navigator + "/seller/auction/detail/" + id;
        }
    </script>
@endsection
