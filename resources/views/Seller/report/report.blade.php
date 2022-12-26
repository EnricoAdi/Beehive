@extends("Seller.layout.masterapp")
@section("title","Report Seller Beehive")

@section("content")
    <div class="w-full px-14 p-3 overflow-y-auto">
        <h1 class="text-3xl mt-5 font-semibold block">Beeworker's Report</h1>
        <br>
        
            <div class="w-full flex rounded-md bg-primary items-end p-3">
                <form action='{{url("/seller/report")}}' method="POST" class="w-full flex rounded-md bg-primary items-end">
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
        
        <div class="w-full p-3 rounded-md bg-primary">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Waktu Transaksi</th>
                        <th>Pendapatan Kotor</th>
                        <th>Pendapatan Bersih</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @foreach ($transaksi as $t)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <th>{{$no}}</th>
                            <td>{{$t->CREATED_AT}}</td>
                            <td>{{"Rp" . number_format($t->COMMISION, 2, ',', '.')}}</td>
                            <td>{{"Rp" . number_format(($t->COMMISION - $t->TAX), 2, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    @if ($no == 0)
                        <tr>
                            <td colspan="4" class="text-center">Empty</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4" class="text-right font-bold text-success text-lg">Total Pendapatan Bersih : {{"Rp" . number_format($totalPendapatanBersih, 2, ',', '.')}}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
