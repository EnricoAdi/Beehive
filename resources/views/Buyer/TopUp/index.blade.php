@extends('Buyer.layout.masterapp')
@section('title', 'Top Up Beehive')

@section('content')
    {{-- Enrico --}}
    <div class="flex justify-center">
        <div class="mt-8">
            <form action="{{ url('/buyer/topup/pay') }}" method="post">
                @csrf
                <div class="block px-6 pb-6 rounded-lg shadow-lg bg-secondary max-w-md mt-4 w-96">
                    <div class="text-lg font-bold text-center  text-whiteColor"><br> Top Up!</div>
                    <div class="text-lg font-bold text-center mb-6  text-whiteColor"> Your Balance :
                        {{ 'Rp' . number_format($user->BALANCE, 2, ',', '.') }}</div>
                    <div class="">
                        <input type="text"
                            class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50 number-separator1"
                            min="0" data-primary="blue-600" data-rounded="rounded-lg" required
                            placeholder="Input Nominal" />
                    </div> <br>

                    <button class="inline-block w-full btn btn-success transition duration-200  shadow-md ease "
                        data-rounded="rounded-lg">
                        Top Up!
                    </button>

                </div>
                <input type="hidden" id="result_input1" name="CREDIT">
            </form>
        </div>
    </div>
    <br><br><br>
    <div class="w-full px-10">
        <div class="w-full p-3 rounded-md bg-secondary">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal Topup</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($listTopup as $t)
                            @php
                                $no++;
                            @endphp
                            <tr>
                                <th>{{ $no }}</th>
                                <td>{{ $t->CREATED_AT }}</td>
                                <td>{{ 'Rp' . number_format($t->CREDIT, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        @if ($no == 0)
                            <tr>
                                <td colspan="3" class="text-center">Empty</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">
        easyNumberSeparator({
            selector: '.number-separator1',
            separator: ',',
            decimalSeparator: '.',
            resultInput: '#result_input1',
        })
    </script>
@endsection
