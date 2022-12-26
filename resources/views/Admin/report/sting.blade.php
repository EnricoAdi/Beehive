@extends('Admin.layout.masterapp')
@section('title', 'Report Admin Beehive')

@section('content')
    
    <div class="w-full px-14 p-3 overflow-y-auto">
        <h1 class="text-3xl mt-5 font-semibold block">Report Sting</h1>
        <br>
        <input type="hidden" id="hiddenNama" value="@foreach ($nama as $n){{ $n->TITLE_STING . ';' }} @endforeach">
        {{-- @dump($jumlah)
        @dd($nama) --}}
        <input type="hidden" id="hiddenJumlah" value="@foreach ($jumlah as $j){{ $j->JUMLAH . ';' }} @endforeach">
        <div class="w-full flex rounded-md bg-primary items-end p-3 min-w-fit">
            <form action='{{url("/admin/report/sting")}}' method="POST" class="w-full flex rounded-md bg-primary items-end min-w-fit">
                @csrf
                {{-- <div class="form-control w-full mr-3">
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
                </div> --}}
                <div class="flex w-full items-end justify-between">
                    <div class="form-control w-1/3 mr-3">
                        <label class="label">
                            <span class="label-text text-base-100">Category</span>
                        </label>
                        <select class="select select-primary w-full" name="category">
                            <option selected value="all">All</option>
                            @foreach ($listCategory as $c)
                                <option value="{{$c->ID_CATEGORY}}">{{$c->NAMA_CATEGORY}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-secondary"><i class="fa-solid fa-magnifying-glass"></i>&nbsp;Search!</button>
                </div>
            </form>
            <button onclick="window.print()" class="btn btn-accent ml-3"><i class="fa-solid fa-print"></i>&nbsp;Print</button>
        </div>
        <br>
        <div class="w-full flex justify-center items-center rounded-md bg-primary p-3 h-96">
            <canvas id="myChart"></canvas>
        </div>
        <br>
        <div class="w-full p-3 rounded-md bg-primary">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Sting</th>
                        <th>Author</th>
                        <th>Jumlah dibeli</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                        $no = 0;
                    @endphp
                    @forelse ($top as $t)
                        @php
                            $no++;
                        @endphp
                        <tr>
                            <th>{{$no}}</th>
                            <td>{{$t->TITLE_STING}}</td>
                            <td>{{$t->NAMA}}</td>
                            <td>{{$t->JUMLAH}}x</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Empty</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

@endsection
@section("script")
<script>

    let listNama= []
    let listJumlah= []
    window.onload = (event) => {
        let gets = document.getElementById("hiddenNama").value;
        let tempArr = gets.split("; ");
        for (let i = 0; i < tempArr.length - 1; i++) {
            const element = tempArr[i];
            listNama.push(element.toString());
        }
        let gets2 = document.getElementById("hiddenJumlah").value;
        let tempArr2 = gets2.split("; ");
        for (let i = 0; i < tempArr2.length - 1; i++) {
            const element2 = tempArr2[i];
            listJumlah.push(parseInt(element2));
        }
        const ctx = document.getElementById('myChart');
        const labels = ["Januari", "Februari", "Maret"];
        const data = {
        labels: listNama,
        datasets: [{
            label: 'Top 10 Sting',
            data: listJumlah,
            backgroundColor: 'rgba(240, 187, 98, 1)',
            borderWidth: 1,
            fontColor: "#ffffff",
            hoverBackgroundColor: 'rgb(220, 167, 68, 1)',
        }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        ticks: {
                            color: "#ffffff",
                            callback: function (value){
                                return value + "x";
                            }
                        },
                        grid: {
                            color: "#FFFFFF"
                        },
                    }, 
                    x: {
                        ticks: {
                            color: "#ffffff",
                        },
                        grid: {
                            color: "#FFFFFF"
                        },
                    }
                },responsive: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            color: '#ffffff'
                        }
                    },
                },
                    maintainAspectRatio: true
            },
        };
        var chart = new Chart(myChart, config);
    };

    

</script>
@endsection