{{-- Jonathan Bryan --}}
@extends('Seller.layout.masterapp')
@section('title', 'Order Beeworker Beehive')

@section('content')
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Oncoming Order</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5 ml-10">
        @forelse ($arrOrder as $key => $orderan)
            @php
                $pic = $orderan[0]->farmer->PICTURE;
            @endphp
            <div data-modal-toggle="detail-modal-{{ $orderan[0]->ID_TRANSACTION }}"
                class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 hover:bg-primary-focus text-base-100 hover:shadow-none {{ $orderan[0]->IS_PREMIUM ? 'bg-primary font-semibold' : 'bg-primary' }}">
                <div class="flex space-x-4">
                    @if (env('APP_ENV') == 'production')
                        <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @else
                        <img src="{{ asset("storage/profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @endif
                    <div class="flex flex-col items-center justify-center">
                        <a rel="noopener noreferrer" href="#" class="text-lg font-semibold">{{ $orderan[1] }}</a>
                    </div>
                </div>
                <p class="h-24 text-sm text-ellipsis overflow-hidden">{{ $orderan[0]->REQUIREMENT_PROJECT }}</p>
                <div class="">
                    @foreach ($orderan[0]->sting->sting_category as $c)
                        <span class="badge font-semibold">{{$c->category->NAMA_CATEGORY}}</span>
                    @endforeach
                </div>
                <div class="flex text-lg font-semibold">
                    <span>Starting at&nbsp;</span>
                    <div>{{"Rp" . number_format($orderan[0]->COMMISION ,2,',','.')}}</div>
                </div>
            </div>
        @empty
            <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                <h2>Belum Ada Oncoming Order!</h2>
            </div>
        @endforelse


    </div>


    <h1 class="text-3xl ml-20 mt-5 font-semibold block">On Progress Order</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5 ml-10">
        @forelse ($acceptedOrder as $key => $orderan)
            @php
                $pic = $orderan[0]->farmer->PICTURE;
            @endphp
            <div data-modal-toggle="detail-modal-{{ $orderan[0]->ID_TRANSACTION }}"
                class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 hover:bg-primary-focus text-base-100 hover:shadow-none {{ $orderan[0]->IS_PREMIUM ? 'bg-primary font-semibold' : 'bg-primary' }}">
                <div class="flex space-x-4">
                    @if (env('APP_ENV') == 'production')
                        <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @else
                        <img src="{{ asset("storage/profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @endif
                    <div class="flex flex-col items-center justify-center">
                        <a rel="noopener noreferrer" href="#" class="text-lg font-semibold">{{ $orderan[1] }}</a>
                    </div>
                </div>
                <p class="h-24 text-sm text-ellipsis overflow-hidden">{{ $orderan[0]->REQUIREMENT_PROJECT }}</p>
                <div class="">
                    @foreach ($orderan[0]->sting->sting_category as $c)
                        <span class="badge font-semibold">{{$c->category->NAMA_CATEGORY}}</span>
                    @endforeach
                </div>
                <div class="flex text-lg font-semibold">
                    <div>{{"Rp" . number_format($orderan[0]->COMMISION ,2,',','.')}}</div>
                </div>
                
            </div>
        @empty
            <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                <h2>Tidak ada order dalam proses!</h2>
            </div>
        @endforelse

    </div>


    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Finished Order</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5 ml-10">
        @forelse ($doneOrder as $key => $orderan)
            @php
                $pic = $orderan[0]->farmer->PICTURE;
            @endphp
            <div data-modal-toggle="detail-modal-{{ $orderan[0]->ID_TRANSACTION }}"
                class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 hover:bg-primary-focus text-base-100 hover:shadow-none {{ $orderan[0]->IS_PREMIUM ? 'bg-primary font-semibold' : 'bg-primary' }}">
                <div class="flex space-x-4">
                    @if (env('APP_ENV') == 'production')
                        <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @else
                        <img src="{{ asset("storage/profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @endif
                    <div class="flex flex-col items-center justify-center">
                        <a rel="noopener noreferrer" href="#" class="text-lg font-semibold">{{ $orderan[1] }}</a>
                    </div>
                </div>
                <div class="h-36">
                    <div class="flex justify-between">
                        <h2 class="mb-1 text-xl font-semibold"></h2>
                    </div>
                    <p class="text-sm">{{ $orderan[0]->REQUIREMENT_PROJECT }}</p>
                </div>
                <div class="flex justify-between text-lg">
                    <div>{{"Rp" . number_format($orderan[0]->COMMISION ,2,',','.')}}</div>
                    <div class="flex gap-1 items-center">
                        <i class="fa-solid fa-star text-secondary"></i>
                        <span>{{number_format($orderan[0]->RATE ,2,'.','.')}}</span>
                    </div>
                </div>
                
                <div class="pt-4 pb-2">
                    @foreach ($orderan[0]->sting->sting_category as $c)
                        <span class="badge font-semibold">{{$c->category->NAMA_CATEGORY}}</span>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                <h2>Tidak ada order selesai!</h2>
            </div>
        @endforelse

    </div>

    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Declined Order</h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10 xl:gap-5 ml-10">
        @forelse ($declinedOrder as $key => $orderan)
        @php
            $pic = $orderan[0]->farmer->PICTURE;
        @endphp
            <div data-modal-toggle="detail-modal-{{ $orderan[0]->ID_TRANSACTION }}"
                class="flex flex-col cursor-pointer max-w-sm p-6 space-y-6 overflow-hidden rounded-lg shadow-lg shadow-gray-300 hover:bg-error-focus text-base-100 hover:shadow-none bg-error }}">
                <div class="flex space-x-4">
                    @if (env('APP_ENV') == 'production')
                        <img src="{{ asset("profile-pictures/$pic") }}" alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @else
                        <img src="{{ asset("storage/profile-pictures/$pic") }}"
                            alt="Picture of {{ $user->NAMA }}"
                            class="object-cover w-12 h-12 rounded-full shadow-md shadow-grey-400 dark:bg-gray-500">
                    @endif
                    <div class="flex flex-col items-center justify-center">
                        <a rel="noopener noreferrer" href="#" class="text-lg font-semibold">{{ $orderan[1] }}</a>
                    </div>
                </div>
                <p class="h-24 text-sm text-ellipsis overflow-hidden">{{ $orderan[0]->REQUIREMENT_PROJECT }}</p>
            </div>
        @empty
            <div class="bg-red-100 rounded-lg py-5 px-4 text-base text-red-700 mb-3" role="alert">
                <h2>Tidak ada order ditolak!</h2>
            </div>
        @endforelse

    </div>
@endsection
@section('modal')
    @foreach ($arrOrder as $key => $orderan)
        @php
            $order = $orderan[0];
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -2) {
                $statusColor = 'text-red-700';
                $status = 'Canceled';
            } elseif ($order->STATUS == -1) {
                $status = 'Rejected';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'In Revision';
                $statusColor = 'text-blue-800';
            } elseif ($order->STATUS == 3) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_TRANSACTION }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed text-base-100 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-base-100 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-base-100">
                        <h4 class="mb-4 text-xs font-medium text-base-100 dark:text-white">{{ $order->ID_TRANSACTION }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium text-base-100 dark:text-white">
                            {{ $order->sting->TITLE_STING }}</h3>

                        <div class="flex gap-3 text-lg">
                            <div class="mt-2 font-semibold">By {{ $order->sting->author->NAMA }} </div>
                            <div class="flex gap-1 items-center mt-2">
                                <i class="fa-solid fa-star"></i>
                                <span>{{ $order->sting->RATING }}</span>
                            </div>
                        </div>

                        <div class="mt-2">{{ $order->IS_PREMIUM == '1' ? 'Premium' : 'Basic' }} service </div>
                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }}">Status : {{ $status }}
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-secondary"
                                onclick="accept('{{ $order->ID_TRANSACTION }}')">Accept</button>
                            <button class="btn btn-error"
                                onclick="decline('{{ $order->ID_TRANSACTION }}')">Decline</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($acceptedOrder as $key => $orderan)
        @php
            $order = $orderan[0];
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -2) {
                $statusColor = 'text-red-700';
                $status = 'Canceled';
            } elseif ($order->STATUS == -1) {
                $status = 'Rejected';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'In Revision';
                $statusColor = 'text-blue-800';
            } elseif ($order->STATUS == 3) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_TRANSACTION }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed text-base-100 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-base-100 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-base-100">
                        <h4 class="mb-4 text-xs font-medium text-base-100 dark:text-white">Order-{{ $order->ID_TRANSACTION }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium text-base-100">
                            {{ $order->sting->TITLE_STING }}</h3>

                        <div class="flex gap-3 text-lg">
                            <div class="mt-2 font-semibold">By {{ $order->sting->author->NAMA }} </div>
                            <div class="flex gap-1 items-center mt-2">
                                <i class="fa-solid fa-star"></i>
                                <span>{{ $order->sting->RATING }}</span>
                            </div>
                        </div>

                        <div class="mt-2">{{ $order->IS_PREMIUM == '1' ? 'Premium' : 'Basic' }} service </div>
                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }}">Status : {{ $status }}
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-secondary" onclick="detail('{{ $order->ID_TRANSACTION }}')">Open
                                Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($doneOrder as $key => $orderan)
        @php
            $order = $orderan[0];
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -2) {
                $statusColor = 'text-red-700';
                $status = 'Canceled';
            } elseif ($order->STATUS == -1) {
                $status = 'Rejected';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'In Revision';
                $statusColor = 'text-blue-800';
            } elseif ($order->STATUS == 3) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_TRANSACTION }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed text-base-100 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-base-100 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  "
                        data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-base-100">
                        <h4 class="mb-4 text-xs font-medium text-base-100  ">Order-{{ $order->ID_TRANSACTION }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium text-base-100 dark:text-white">
                            {{ $order->sting->TITLE_STING }}</h3>

                        <div class="flex gap-3 text-lg">
                            <div class="mt-2 font-semibold">By {{ $order->sting->author->NAMA }} </div>

                        </div>

                        <div class="mt-2">{{ $order->IS_PREMIUM == '1' ? 'Premium' : 'Basic' }} service </div>
                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }}">Status : {{ $status }}
                        </div>
                        <div class="mt-2">
                            <button class="btn btn-secondary" onclick="detail('{{ $order->ID_TRANSACTION }}')">Open
                                Detail</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    @foreach ($declinedOrder as $key => $orderan)
        @php
            $order = $orderan[0];
            $status = '';
            $statusColor = '';
            if ($order->STATUS == -2) {
                $statusColor = 'text-red-700';
                $status = 'Canceled';
            } elseif ($order->STATUS == -1) {
                $status = 'Rejected';
                $statusColor = 'text-red-600';
            } elseif ($order->STATUS == 0) {
                $status = 'Pending';
                $statusColor = 'text-yellow-400';
            } elseif ($order->STATUS == 1) {
                $status = 'In Progress';
                $statusColor = 'text-amber-800';
            } elseif ($order->STATUS == 2) {
                $status = 'In Revision';
                $statusColor = 'text-blue-800';
            } elseif ($order->STATUS == 3) {
                $status = 'Selesai';
                $statusColor = 'text-primary';
            } else {
                $status = 'Unknown';
            }
        @endphp
        <div id="detail-modal-{{ $order->ID_TRANSACTION }}" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed text-base-100 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-red-300 rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-base-100 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8 text-black">
                        <h4 class="mb-4 text-xs font-medium text-black dark:text-white">Order-{{ $order->ID_TRANSACTION }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium text-black dark:text-white">
                            {{ $order->sting->TITLE_STING }}</h3>

                        <div class="flex gap-3 text-lg">
                            <div class="mt-2 font-semibold">By {{ $order->sting->author->NAMA }} </div>
                            <div class="flex gap-1 items-center mt-2">
                                <i class="fa-solid fa-star"></i>
                                <span>{{ $order->sting->RATING }}</span>
                            </div>
                        </div>

                        <div class="mt-2">{{ $order->IS_PREMIUM == '1' ? 'Premium' : 'Basic' }} service </div>
                        <div class="mt-2">{{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}
                        </div>
                        <div class="mt-2">Requirement : <br>{{ $order->REQUIREMENT_PROJECT }} </div>
                        <div class="mt-2 {{ $statusColor }}">Status : {{ $status }}
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
            let conf = confirm("Apakah anda yakin untuk menerima order sting ini?");
            if (conf) {
                window.location.href = navigator + "/seller/order/accept/" + id;
            }
        }

        function decline(id) {
            let navigator = "{{ url('/') }}";
            let conf = confirm("Apakah anda yakin untuk me-reject order sting ini?");
            if (conf) {
                window.location.href = navigator + "/seller/order/decline/" + id;
            }
        }

        function detail(id) {
            let navigator = "{{ url('/') }}";
            window.location.href = navigator + "/seller/sting/detail/" + id;
        }
    </script>
@endsection
