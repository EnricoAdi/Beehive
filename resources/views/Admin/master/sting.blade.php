@extends('Admin.layout.masterapp')
@section('title', 'Master Sting Beehive')

@section('content')
    @php
        foreach ($arrCat as $key => $cat) {
            // dump($cat->ID_STING);
            // dump($cat->ID_CATEGORY);
            switch ($cat->ID_CATEGORY) {
                case 1:
                    $Programming[] = $cat->ID_STING;
                    break;
                case 2:
                    $Editor[] = $cat->ID_STING;
                    break;
                case 3:
                    $Writer[] = $cat->ID_STING;
                    break;
                case 4:
                    $Voice[] = $cat->ID_STING;
                    break;
                case 5:
                    $Illustrator[] = $cat->ID_STING;
                    break;
            }
        }
        // $beeworkers = $users->where('STATUS', 2);
        // $admins = $users->where('STATUS', 3);

        $allActive = '';
        $progActive = '';
        $editActive = '';
        $writerActive = '';
        $voiceActive = '';
        $illusrActive = '';

        if ($catt == 'all') {
            $allActive = 'bg-secondary rounded-lg  text-black font-bold';
        }
        if ($catt == 'proggramming') {
            $progActive = 'bg-secondary rounded-lg   text-black font-bold';
        }
        if ($catt == 'editor') {
            $editActive = 'bg-secondary rounded-lg  text-black font-bold';
        }
        if ($catt == 'writer') {
            $writerActive = 'bg-secondary rounded-lg  text-black font-bold';
        }
        if ($catt == 'voice') {
            $voiceActive = 'bg-secondary rounded-lg   text-black font-bold';
        }
        if ($catt == 'illustrator') {
            $illusrActive = 'bg-secondary rounded-lg  text-black font-bold';
        }
    @endphp
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Master Sting</h1>

    <div class="tabs tabs-boxed text-2xl ml-20 font-semibold w-fit mt-2 bg-base-100">
        <a class="tab {{ $allActive }}" href="{{ url('/admin/master/sting?catt=all') }}">All</a>
        <a class="tab {{ $progActive }}" href="{{ url('/admin/master/sting?catt=proggramming') }}">Programming</a>
        <a class="tab {{ $editActive }}" href="{{ url('/admin/master/sting?catt=editor') }}">Editor</a>
        <a class="tab {{ $writerActive }}" href="{{ url('/admin/master/sting?catt=writer') }}">Writer</a>
        <a class="tab {{ $voiceActive }}" href="{{ url('/admin/master/sting?catt=voice') }}">Voice Actor</a>
        <a class="tab {{ $illusrActive }}" href="{{ url('/admin/master/sting?catt=illustrator') }}">Illustrator</a>
    </div>

    <div class="overflow-x-auto p-10 ml-10">
        <table class="table table-zebra w-full rounded-md">
            <!-- head -->
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Owner</th>
                    <th>Price</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <!-- body -->
            <tbody>
                @if ($catt == 'all')
                    @foreach ($stings as $s)
                        <tr>
                            <td>{{ $s->TITLE_STING }}</td>
                            <td>{{ $s->EMAIL_BEEWORKER  }}</td>
                            <td>{{ 'Rp ' . number_format($s->PRICE_BASIC, 2, ',', '.') }} - {{ 'Rp ' . number_format($s->PRICE_PREMIUM, 2, ',', '.') }}</td>
                            <td>
                                {{-- @for ($i = 0; $i < 1*$s->RATING; $i++)
                                👌
                                @endfor
                                 --}}

                                <i class="fa-solid fa-star text-secondary"></i>
                                {{$s->RATING}}
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn bg-yellow-400"
                                    onclick="detailSting('{{ $s->ID_STING }}')">Detail</button>
                                <button class="btn hover:bg-red-500"
                                    onclick="deleteSting('{{ $s->ID_STING }}','{{ $catt }}')">Delete</button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @elseif ($catt == 'proggramming')
                    @foreach ($Programming as $p)
                        @php
                            $kucing = $stings->where('ID_STING',$p)->first();

                        @endphp
                        {{-- @dump($kucing) --}}
                        <tr>
                            <td>{{ $kucing->TITLE_STING }}</td>
                            <td>{{ $kucing->EMAIL_BEEWORKER  }}</td>
                            <td>{{ 'Rp ' . number_format($kucing->PRICE_BASIC, 2, ',', '.') }} - {{ 'Rp ' . number_format($kucing->PRICE_PREMIUM, 2, ',', '.') }}</td>
                            <td>
                                {{-- @for ($i = 0; $i < 1*$kucing->RATING; $i++)
                                👌
                                @endfor --}}
                                <i class="fa-solid fa-star text-secondary"></i>
                                {{$kucing->RATING}}
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn bg-yellow-400"
                                    onclick="detailSting('{{ $p }}')">Detail</button>
                                <button class="btn hover:bg-red-500"
                                    onclick="deleteSting('{{ $p }}','{{ $catt }}')">Delete</button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @elseif ($catt == 'editor')
                    @foreach ($Editor as $p)
                        @php
                            $kucing = $stings->where('ID_STING',$p)->first();

                        @endphp
                        {{-- @dump($kucing) --}}
                        <tr>
                            <td>{{ $kucing->TITLE_STING }}</td>
                            <td>{{ $kucing->EMAIL_BEEWORKER  }}</td>
                            <td>{{ 'Rp ' . number_format($kucing->PRICE_BASIC, 2, ',', '.') }} - {{ 'Rp ' . number_format($kucing->PRICE_PREMIUM, 2, ',', '.') }}</td>
                            <td>
                                {{-- @for ($i = 0; $i < 1*$kucing->RATING; $i++)
                                👌
                                @endfor --}}

                                <i class="fa-solid fa-star text-secondary"></i>
                                {{$kucing->RATING}}
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn bg-yellow-400"
                                    onclick="detailSting('{{ $p }}')">Detail</button>
                                <button class="btn hover:bg-red-500"
                                    onclick="deleteSting('{{ $p }}','{{ $catt }}')">Delete</button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @elseif ($catt == 'writer')
                    @foreach ($Writer as $p)
                        @php
                            $kucing = $stings->where('ID_STING',$p)->first();

                        @endphp
                        {{-- @dump($kucing) --}}
                        <tr>
                            <td>{{ $kucing->TITLE_STING }}</td>
                            <td>{{ $kucing->EMAIL_BEEWORKER  }}</td>
                            <td>{{ 'Rp ' . number_format($kucing->PRICE_BASIC, 2, ',', '.') }} - {{ 'Rp ' . number_format($kucing->PRICE_PREMIUM, 2, ',', '.') }}</td>
                            <td>
                                {{-- @for ($i = 0; $i < 1*$kucing->RATING; $i++)
                                👌
                                @endfor --}}

                                <i class="fa-solid fa-star text-secondary"></i>
                                {{$kucing->RATING}}
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn bg-yellow-400"
                                    onclick="detailSting('{{ $p }}')">Detail</button>
                                <button class="btn hover:bg-red-500"
                                    onclick="deleteSting('{{ $p }}','{{ $catt }}')">Delete</button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @elseif ($catt == 'voice')
                    @foreach ($Voice as $p)
                        @php
                            $kucing = $stings->where('ID_STING',$p)->first();

                        @endphp
                        {{-- @dump($kucing) --}}
                        <tr>
                            <td>{{ $kucing->TITLE_STING }}</td>
                            <td>{{ $kucing->EMAIL_BEEWORKER  }}</td>
                            <td>{{ 'Rp ' . number_format($kucing->PRICE_BASIC, 2, ',', '.') }} - {{ 'Rp ' . number_format($kucing->PRICE_PREMIUM, 2, ',', '.') }}</td>
                            <td>
                                {{-- @for ($i = 0; $i < 1*$kucing->RATING; $i++)
                                👌
                                @endfor --}}
                                <i class="fa-solid fa-star text-secondary"></i>
                                {{$kucing->RATING}}
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn bg-yellow-400"
                                    onclick="detailSting('{{ $p }}')">Detail</button>
                                <button class="btn hover:bg-red-500"
                                    onclick="deleteSting('{{ $p }}','{{ $catt }}')">Delete</button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @elseif ($catt == 'illustrator')
                    @foreach ($Illustrator as $p)
                        @php
                            $kucing = $stings->where('ID_STING',$p)->first();

                        @endphp
                        {{-- @dump($kucing) --}}
                        <tr>
                            <td>{{ $kucing->TITLE_STING }}</td>
                            <td>{{ $kucing->EMAIL_BEEWORKER  }}</td>
                            <td>{{ 'Rp ' . number_format($kucing->PRICE_BASIC, 2, ',', '.') }} - {{ 'Rp ' . number_format($kucing->PRICE_PREMIUM, 2, ',', '.') }}</td>
                            <td>
                                {{-- @for ($i = 0; $i < 1*$kucing->RATING; $i++)
                                👌
                                @endfor --}}

                                <i class="fa-solid fa-star text-secondary"></i>
                                {{$kucing->RATING}}
                            </td>
                            <td>
                                <div class="btn-group">
                                <button class="btn bg-yellow-400"
                                    onclick="detailSting('{{ $p }}')">Detail</button>
                                <button class="btn hover:bg-red-500"
                                    onclick="deleteSting('{{ $p }}','{{ $catt }}')">Delete</button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

@endsection
@section('script')

    <script>
        function deleteSting(id, catt) {
            let navigator = "{{ url('/') }}";
            let conf = confirm("Apakah anda yakin untuk menghapus Sting " + id + "?\nThis action cannot be undone");
            if (conf) {
                window.location.href = navigator + "/admin/master/sting/delete/" + id + "/" + catt;
            }
        }

        function detailSting(id) {
            let navigator = "{{ url('/') }}";
            window.location.href = navigator + "/admin/master/sting/" + id;
        }
    </script>
@endsection
