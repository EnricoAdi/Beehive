@extends('Admin.layout.masterapp')
@section('title', 'Report Admin Beehive')

@section('content')
    
    <div class="w-full px-14 p-3 overflow-y-auto">
        <h1 class="text-3xl mt-5 font-semibold block">Report Topup</h1>
        <br>
        
            <div class="w-full flex rounded-md bg-primary items-end p-3">
                <form action='{{url("/admin/report/topup")}}' method="POST" class="w-full flex rounded-md bg-primary items-end">
                    @csrf
                    <div class="form-control w-full mr-3">
                        <label class="label">
                            <span class="label-text text-base-100">Tanggal awal</span>
                        </label>
                        <input type="date" placeholder="Type here" name="tgl1" class="input input-bordered w-full" value="{{old("tgl1")}}" />
                    </div>
                    <div class="form-control w-full mr-3">
                        <label class="label">
                            <span class="label-text text-base-100">Tanggal akhir</span>
                        </label>
                        <input type="date" placeholder="Type here" name="tgl2" class="input input-bordered w-full" value="{{old("tgl2")}}" />
                    </div>
                    <button class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search!</button>
                </form>
                
                <button onclick="window.print()" class="btn btn-accent ml-3"><i class="fa-solid fa-print"></i>&nbsp;Print</button>
            </div>
        <br>
        {{-- <div class="w-full flex justify-center items-center rounded-md bg-primary p-3 h-96">
            Tempat chart
        </div> --}}
        {{-- <br> --}}
        <div class="w-full p-3 rounded-md bg-primary">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu Transaksi</th>
                        <th>Pendapatan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($topup as $t)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <th>{{$no}}</th>
                            <td>{{$t->CREATED_AT}}</td>
                            <td>{{"Rp" . number_format($t->CREDIT, 2, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    @if ($no == 0)
                        <tr>
                            <td colspan="3" class="text-center">Empty</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="3" class="text-right font-bold text-success text-lg">Total Pendapatan : {{"Rp" . number_format($totalTopup, 2, ',', '.')}}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

@endsection