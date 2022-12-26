@extends('Admin.layout.masterapp')
@section('title', 'Home Admin Beehive')

@section('content')

    <div class="w-full h-full px-10 p-3 overflow-y-auto">
        <h1 class="text-3xl mt-5 font-semibold block">Dashboard Admin</h1>
        <br>
        <div class="flex gap-5 h-3/6">
            <div class="card w-2/3 h-full text-black bg-secondary">
                <div class="card-body items-center text-center overflow-y-auto">
                    <h2 class="card-title">Beehive Overview</h2>
                    <br>
                    <div class="flex gap-x-3 flex-wrap gap-y-2">
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Total User Registered</h2>
                            <p>{{$userRegistered}} Users</p>
                        </div>
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Total Succeed Transaction</h2>
                            <p>{{$succeedTrans}} Transactions</p>
                        </div>
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Users Joined This Month</h2>
                            <p>{{$userJoinedRecent}} Users</p>
                        </div>
                        {{-- <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <button class="btn btn-primary shadow-md">Generate Report</button>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="card w-1/3 bg-secondary text-black bg-coffee">
                <div class="card-body text-lg text-center flex justify-center items-center">
                    <div class="card-body items-center text-center w-full">
                        <h2 class="font-semibold text-lg"">Jumlah Transaksi Pemasukkan Anda Dalam Rupiah</h2>
                        <p class="mt-10 font-semibold text-4xl">{{"Rp" . number_format($pemasukan,2,',','.')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="card w-full bg-secondary text-black bg-coffee">
            <div class="card-body items-center text-center">
                <h2 class="font-semibold text-lg">Average Sting Price</h2>
                <div class="mt-8 font-semibold text-3xl">
                    <p>Basic : {{"Rp" . number_format($avgBasicPrice,2,',','.')}}</p>
                    <p>Premium : {{"Rp" . number_format($avgPremiumPrice,2,',','.')}}</p>
                </div>
            </div>
        </div>
        <br>
        <div class="w-full flex gap-5">
            <div class="card w-1/2 bg-secondary text-black">
                <div class="card-body items-center text-center w-full">
                    <h2 class="font-semibold text-lg"">Most Ordered Sting</h2>
                    <p class="mt-10 font-semibold text-2xl">{{$mostBought}}</p>
                </div>
            </div>
            <div class="card w-1/2 bg-secondary text-black">
                <div class="card-body items-center text-center w-full">
                    <h2 class="font-semibold text-lg"">Kategori terpopuler</h2>
                    <p class="mt-10 font-semibold text-2xl">{{$kategoriTerpopuler}}</p>
                </div>
            </div>
        </div>
        <br>
    </div>


@endsection
