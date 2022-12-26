@extends('Buyer.layout.masterapp')
@section('title', 'Home Buyer Beehive')

@section('content')
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Ordered Sting</h1>

    <div class="overflow-x-auto p-10 ml-10">
        <table class="table table-zebra w-full">
            <thead>
                <tr>
                    <th>Date Ordered</th>
                    <th>Sting</th>
                    <th>Beeworker</th>
                    <th>Type</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ordered as $order) 
                    <tr class="cursor-pointer">
                        <td data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">{{ $order->CREATED_AT }}</td>
                        <td data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                            {{ Str::substr($order->sting->TITLE_STING, 0, 10) }}..</td>
                        <td data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                            {{ $order->sting->author->NAMA }}</td>
                        <td data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                            {{ $order->IS_PREMIUM == '1' ? 'Premium' : 'Basic' }}</td>
                        <td data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                            {{ 'Rp' . number_format($order->COMMISION + $order->TAX, 2, ',', '.') }}</td>
                        @php
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
                        <td class="{{ $statusColor }} font-semibold" data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                            {{ $status }}</td>
                        <td>

                            <div class="btn-group">
                                @if ($order->STATUS > -1)
                                <button class="btn btn-secondary"  onclick="detail('{{ $order->ID_TRANSACTION }}')">Detail</button>

                                @else
                                <button class="btn btn-secondary"  disabled>Detail</button>

                                @endif
                                 @if ($order->STATUS == 0)
                                    <button class="btn hover:bg-red-500"
                                        onclick="cancel('{{ $order->ID_TRANSACTION }}')">Cancel</button>
                                @else
                                    <button class="btn hover:bg-red-500" disabled>Cancel</button>
                                @endif

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum Ada Order Dipesan!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>




    </div>
@endsection
@section('modal')
    @foreach ($ordered as $order)
        @php
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
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
            <div class="relative w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-primary rounded-lg shadow dark:bg-gray-700">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                        data-modal-toggle="detail-modal-{{ $order->ID_TRANSACTION }}">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="py-6 px-6 lg:px-8">
                        <h4 class="mb-4 text-md font-medium text-gray-900 dark:text-white">{{ $order->ID_TRANSACTION }}
                        </h4>
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">

                            {{ $order->sting->TITLE_STING }}
                        </h3>

                        <div class="mt-2">By {{ $order->sting->author->NAMA }} </div>
                        <div class="flex gap-1 items-center mt-2">
                            <i class="fa-solid fa-star"></i>
                            <span>{{ $order->sting->RATING }}</span>
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
    <script type="text/javascript">
        function cancel(param) {
            let ask = confirm("Apakah anda yakin untuk membatalkan order sting ini?");
            if (ask) {
                let navigator = "{{ url('/') }}";
                window.location.href = navigator + "/buyer/sting/ordered/cancel/" + param;
            }

        }
        function detail(param) {
                let navigator = "{{ url('/') }}";
                window.location.href = navigator + "/buyer/sting/ordered/detail/" + param;

        }
    </script>
@endsection
