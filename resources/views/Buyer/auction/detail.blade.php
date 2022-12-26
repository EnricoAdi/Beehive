@extends('Buyer.layout.masterapp')
@section('title', 'Lelang Sting Detail Farmer Beehive')

@section('content')
    <a href="{{ url('/buyer/auction') }}" class="btn btn-secondary w-28 ml-10 mt-4">Back</a>
    <div class="p-10 flex gap-5 w-full text-base-100">
        <div class="w-2/3  shadow-gray-300 rounded-lg flex flex-col">
            <div class="text-xl font-semibold flex flex-col gap-2 bg-primary p-5 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <div class="text-lg">{{ $lelang->TITLE_STING }}</div>
                    <div class="flex gap-1 items-center">
                        {{ 'Rp' . number_format($lelang->COMMISION + $lelang->TAX, 2, ',', '.') }}
                    </div>
                </div>

            </div>
            <div class="p-5 bg-accent shadow-lg w-full rounded-b-lg text-black flex flex-col gap-5">

                <div>
                    <div class="text-lg font-semibold">Beeworker : {{ $lelang->beeworker->NAMA }}
                        ({{ $lelang->beeworker->EMAIL }})
                    </div>
                    <div class="text-lg font-normal">Project Requirement from You : </div>
                    <div class="ml-2 mt-3">
                        {{ $lelang->REQUIREMENT_PROJECT }}
                    </div>
                    <div class="mt-3">
                        <hr class="h-1 bg-gray-300 border-0">
                    </div>
                    <table class="table table-zebra w-full rounded-md mt-4">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>Ordered At</th>
                                <th>Accepted At</th>
                                <th>Revision Left</th>
                            </tr>
                        </thead>
                        <!-- body -->
                        <tbody>
                            <tr>
                                <td> {{ $orderDate }} </td>
                                <td>{{ $acceptedDate }} </td>
                                <td> {{ $revisionLeft }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="bg-accent h-fit rounded-lg shadow-lg shadow-gray-300 p-5 sticky top-0 text-black mt-3">
                <div class="flex flex-col gap-3 h-1/2">

                    <div class="text-lg font-semibold {{ $statusColor }}">Status : {{ $status }} </div>
                    @if ($lelang->FILENAME_FINAL != '')
                        <a href="{{ url("/buyer/auction/detail/download/$lelang->FILENAME_FINAL") }}" target="_blank"
                            class="btn btn-secondary ml-1">Download Latest Deliver</a>
                        @if ($revisionWaiting < 1)
                            <div class="flex gap-1">

                                @if ($lelang->STATUS != 2)
                                    @if ($revisionLeft > 0)
                                        <button class="btn btn-error w-1/2" data-modal-toggle="detail-modal-decline">Decline
                                            Work</button>
                                    @else
                                        <button class="btn btn-error w-1/2" disabled>Decline
                                            Work</button>
                                    @endif

                                    <button class="btn btn-success w-1/2"
                                        onclick="accept('{{ $lelang->ID_LELANG_STING }}')">Accept Work</button>
                                @endif
                            </div>
                        @endif
                    @else
                        <p class="text-gray-700" disabled>There is no work delivered yet</p>
                    @endif
                </div>
            </div>
            <div class="bg-accent h-fit rounded-lg shadow-lg shadow-gray-300 p-5 sticky top-0 text-black mt-3">
                <div class="flex flex-col gap-3 h-1/2">
                    <div class="text-lg font-semibold">Latest Complain From You </div>
                    @php
                        $counterComplain = 1;
                    @endphp
                    @forelse ($complains as $c)
                        <div class="mt-4">
                            <hr class="h-1 bg-gray-500 border-0">
                            <div class="mt-2">Complain For Revision #{{ $counterComplain }}</div>
                            <div>Complained At {{ $c->CREATED_AT }}</div>
                            <div>Message : {{ $c->COMPLAIN }}</div>
                            @if ($c->FILE_REVISION != '')
                                <div>Resolved At {{ $c->UPDATED_AT }}</div>
                                <a href="{{ url("/buyer/auction/detail/download/$c->FILE_REVISION") }}" target="_blank"
                                    class="btn btn-success w-full mt-2">Download Revision</a>
                            @endif
                        </div>
                        @php

                            $counterComplain += 1;
                        @endphp
                    @empty
                        <div class="mt-2">Belum ada complain yang diajukan</div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="bg-accent h-fit rounded-lg shadow-lg shadow-gray-300 p-5 sticky top-0 text-black ">
            <div class="text-lg font-semibold">Discussion With Beeworker </div>
            {{-- KOMPONEN CHAT --}}
            <div class="mt-3 bg-base-100 rounded-lg max-h-96
             overflow-y-auto p-4" id="container-chat">
                @foreach ($chats as $c)
                    @if ($c->EMAIL == $user->EMAIL)
                        <div class="mb-3">
                            <div class="flex justify-end">
                                <div class="dropdown dropdown-end">
                                    <label tabindex="0" class="">

                                        <div class="bg-accent p-3 rounded-lg cursor-pointer hover:bg-secondary">
                                            @if ($c->REPLY_TO != null)
                                                <div class="text-gray-400">Replying : {{ $c->reply->BODY }}
                                                </div>
                                                <hr class="h-1 bg-gray-50 mt-2 mb-2">
                                            @endif
                                            {{ $c->BODY }}
                                            @if ($c->ID_COMPLAIN != null)
                                                <hr class="h-1 bg-gray-50 mt-2 mb-2">
                                                <div class="text-gray-400 text-sm">Reference From Complain
                                                    "{{ $c->complain->COMPLAIN }}"</div>
                                            @endif
                                        </div>
                                    </label>
                                    <ul tabindex="0"
                                        class="dropdown-content menu p-2 shadow bg-secondary rounded-box w-36 mt-2">
                                        <li class="p-2 cursor-pointer"
                                            onclick="reply({{ $c->ID_CHAT }},'{{ $c->BODY }}')">Reply</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex justify-end text-gray-400 text-sm">
                                {{ date_format(date_create($c->CREATED_AT), 'd M Y') }}</div>
                        </div>
                    @else
                        <div class="mb-3">
                            <div class="flex justify-start">
                                <div class="dropdown dropdown-start">
                                    <label tabindex="0" class="">

                                        <div class="bg-accent p-3 rounded-lg cursor-pointer hover:bg-secondary">
                                            @if ($c->REPLY_TO != null)
                                                <div class="text-gray-400">Replying : {{ $c->reply->BODY }}
                                                </div>
                                                <hr class="h-1 bg-gray-50 mt-2 mb-2">
                                            @endif
                                            {{ $c->BODY }}
                                            @if ($c->ID_COMPLAIN != null)
                                                <hr class="h-1 bg-gray-50 mt-2 mb-2">
                                                <div class="text-gray-400 text-sm">Reference From Complain
                                                    "{{ $c->complain->COMPLAIN }}"</div>
                                            @endif
                                        </div>
                                    </label>
                                    <ul tabindex="0"
                                        class="dropdown-content menu p-2 shadow bg-secondary rounded-box w-36 mt-2">
                                        <li class="p-2 cursor-pointer"
                                            onclick="reply({{ $c->ID_CHAT }},'{{ $c->BODY }}')">Reply</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex justify-start text-gray-400 text-sm">
                                {{ date_format(date_create($c->CREATED_AT), 'd M Y') }}</div>
                        </div>
                    @endif
                @endforeach



            </div>

            {{-- KOMPONEN CHAT --}}
            <form action="{{ url("/buyer/sting/ordered/detail/chat/$id") }}" method="post">
                @csrf
                <div class="mt-3 bg-base-100 rounded-lg  p-4">
                    <div class="text-gray-400" id="section-reply">Replying to :
                        <input type="text" id="replying" class="border-none" readonly value="asd">
                        <input type="hidden" name="replying" id="replyingID" class="border-none" readonly value="-1">
                        <div class="underline ml-4 cursor-pointer" onclick="cancelReply()">
                            cancel</div>
                    </div>
                    <textarea name="chat" class="input input-primary border-1 rounded-md px-4 py-2 mt-5 w-full h-12" required
                        placeholder="Input chat"></textarea>
                    @error('chat')
                        <label class="label">
                            <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                        </label>
                    @enderror
                    From Complain
                    <select name="reference"
                        class="block w-full px-4  mt-2 text-md placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                        data-primary="blue-600" data-rounded="rounded-lg">
                        <option value=""></option>
                        @foreach ($complains as $c)
                            <option value="{{ $c->ID_COMPLAIN }}">{{ $c->COMPLAIN }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-secondary w-full px-3 py-2 font-medium  mt-3">Send</button>


                </div>
            </form>
        </div>
    </div>
@endsection
@section('modal')

    <div id="detail-modal-decline" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed text-base-100 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
        <div class="relative w-full max-w-md h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-base-100  rounded-lg shadow-2xl dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 right-2.5 text-gray-900 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center  "
                    data-modal-toggle="detail-modal-decline">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="py-6 px-6 lg:px-8 text-black">
                    <form action="{{ url("/buyer/auction/detail/decline/$id") }}" method="post">
                        @csrf
                        <label class="block mb-2 pt-5 text-lg font-medium text-gray-900 " for="complain">Decline
                            Submission</label>

                        <input type="text" name="complain" id="complain"
                            class="block mb-5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer focus:ring focus:ring-blue-500 focus:outline-none"
                            data-rounded="rounded-lg" data-primary="blue-500"
                            placeholder="Berikan alasan penolakan submission order" required>
                        <button class="btn btn-error w-full">Submit!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        var txtReply = document.getElementById("replying");
        var idReply = document.getElementById("replyingID");
        var sectionReply = document.getElementById("section-reply");

        window.onload = function() {
            sectionReply.style.display = "none";
        }

        function accept(param) {
            let ask = confirm("Apakah anda yakin untuk menerima hasil kerja lelang sting ini?");
            if (ask) {
                let navigator = "{{ url('/') }}";
                window.location.href = navigator + "/buyer/auction/accept/" + param;
            }
        }

        function cancelReply() {
            idReply.value = -1;
            txtReply.value = "";
            sectionReply.style.display = "none";
        }

        function reply(paramId, paramIsi) {
            idReply.value = paramId;
            txtReply.value = paramIsi;
            sectionReply.style.display = "block";
        }
    </script>
@endsection
