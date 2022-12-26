@extends('Buyer.layout.masterapp')
@section('title', 'Upgrade Account Beehive')

@section('content')
    {{-- Enrico --}}

    <div class="flex justify-center h-screen">
        <div class="mt-8">
            <div class="block px-6 pb-6 rounded-lg shadow-lg bg-secondary max-w-md mt-4 w-96">
                <div class="text-lg font-bold text-center mb-6  text-whiteColor"><br> Upgrade Account!</div>
                <div class="">
                    <h1 class="text-2xl ml-10 mt-5 font-semibold block">Nominal = Rp{{ number_format($credit) }}</h1>
                    <input type="hidden" id="kode_topup" value="{{ $kodeTopUp }}">
                </div> <br>

                <button
                    class="inline-block w-full  transition duration-200 btn btn-success ease"  data-rounded="rounded-lg"id="pay-button">
                    Bayar Sekarang
                </button>
            </div>
        </div>
    </div>







    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
    </script>
    <script>
        const payButton = document.querySelector('#pay-button');
        payButton.addEventListener('click', function(e) {
            e.preventDefault();
            snap.pay('{{ $snapToken }}', {
                // Optional
                onSuccess: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    //console.log(result)
                    // const kodetopup = document.getElementById("kode_topup").value;
                    // let urlString = "/buyer/topup/notify-ajax/"+kodetopup+"/success";
                    let url = "{{ url('/buyer/subscribe/notify-ajax/' . $kodeTopUp . '/success') }}";
                    fetch(url)
                        .then(
                            function() {
                                window.location.href = "{{ url('/buyer/subscribe/success') }}";
                            }
                        );
                },
                // Optional
                onPending: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
                    console.log(result)
                },
                // Optional
                onError: function(result) {
                    /* You may add your own js here, this is just example */
                    // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);

                    const kodetopup = document.getElementById("kode_topup").value;
                    let url = "{{ url('/buyer/subscribe/notify-ajax/' . $kodeTopUp . '/failed') }}";
                    fetch(url)
                        .then(
                            function() {
                                window.location.href = "{{ url('/buyer/subscribe/failed') }}";
                            }
                        );
                }
            });
        });
    </script>
@endsection
