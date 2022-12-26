@extends('Seller.layout.masterapp')
@section('title', 'Home Seller Beehive')

@section('content')
    <h1 class="px-10 text-3xl mt-5 font-semibold block">Dashboard Beeworker</h1>
    {{-- DONE -> MK --}}
    <div class="flex flex-col gap-3 py-5 px-10 overflow-y-auto">
        <div class="flex gap-5 w-full">
            <div class="card bg-secondary w-3/4 shadow-md">
                <div class="card-body items-center text-center">
                    <h2 class="card-title">User Overview</h2>
                    <div class="flex gap-x-3 flex-wrap gap-y-2">
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Date Joined</h2>
                            <p>{{$join}}</p>
                        </div>
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Overall Rate</h2>
                            <p>{{$avgRating}}</p>
                        </div>
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Finished Orders</h2>
                            <p>{{$finished}} Orders Finished</p>
                        </div>
                        <div class="card-body items-center text-center bg-neutral shadow-md rounded-md hover:shadow-xl">
                            <h2 class="card-title">Active Orders</h2>
                            <p>{{$onGoing}} Orders ongoing</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card w-1/4 text-black bg-coffee bg-secondary h-full shadow-md">
                <div class="card-body items-center text-center">
                    <h2 class="card-title">Owned Sting</h2>
                    <p class="mt-10">{{$jumlahSting}} Different Stings</p>
                </div>
            </div>
        </div>
        <div class="card w-full bg-secondary text-black bg-coffee px-10 shadow-md">
            <div class="card-body items-center text-center">
                <h2 class="card-title">Average Sting Price</h2>
                <p class="mt-10">{{"Rp" . number_format($averageBasic ,2,',','.')}} and {{"Rp" . number_format($averagePremium ,2,',','.')}}</p>
            </div>
        </div>
        <div class="w-full flex gap-5">
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
        </div>
    </div>
@endsection
