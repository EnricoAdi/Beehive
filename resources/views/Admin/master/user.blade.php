@extends('Admin.layout.masterapp')
@section('title', 'Master User Beehive')

@section('content')
    @php
        $farmers = $users->where('STATUS', 1);
        $beeworkers = $users->where('STATUS', 2);
        $admins = $users->where('STATUS', 3);

        $beeworkerActive = '';
        $farmerActive = '';
        $adminActive = '';
        if ($filter == 'Beeworker') {
            $beeworkerActive = 'bg-secondary rounded-lg mb-2 mt-2 text-black font-bold';
        }
        if ($filter == 'Farmer') {
            $farmerActive = 'bg-secondary rounded-lg mb-2 mt-2 text-black font-bold';
        }
        if ($filter == 'Admin') {
            $adminActive = 'bg-secondary rounded-lg mb-2 mt-2 text-black font-bold';
        }
    @endphp
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Master User</h1> <br>

    <div class="tabs tabs-boxed text-2xl ml-20 block font-semibold w-fit bg-base-100">
        <a class="tab {{ $farmerActive }}" href="{{ url('/admin/master/user?filter=Farmer') }}">Farmer</a>
        <a class="tab {{ $beeworkerActive }}" href="{{ url('/admin/master/user?filter=Beeworker') }}">Beeworker</a>
        <a class="tab {{ $adminActive }}" href="{{ url('/admin/master/user?filter=Admin') }}">Admin</a>
    </div>
    @if ($filter == 'Admin')

        <div class="indicator mt-4 ml-20">
            @if ($errors->any())
                <span class="indicator-item badge badge-error"></span>
            @endif
            <button
                class="block btn btn-secondary capitalize w-72"
                type="button" data-modal-toggle="authentication-modal">
                Add Admin!
            </button>
        </div>
    @endif
    <div class="overflow-x-auto p-10 ml-10">
        <table class="table table-zebra w-full rounded-md">
            <!-- head -->
            <thead>
                @if ($filter == 'Farmer')
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Subscribed</th>
                        <th>Verified At</th>
                        <th>Action</th>
                    </tr>
                @endif
                @if ($filter == 'Beeworker')
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Rating</th>
                        <th>Verified At</th>
                        <th>Action</th>
                    </tr>
                @endif
                @if ($filter == 'Admin')
                    <tr>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                @endif
            </thead>
            <tbody>

                @if ($filter == 'Farmer')
                    @foreach ($farmers as $u)
                        <tr>
                            <td>{{ $u->EMAIL }}</td>
                            <td>{{ $u->NAMA }}</td>
                            <td>{{ $u->SUBSCRIBED == 1 ? 'Subscribed' : 'Free User' }}</td>
                            <td>{{ $u->EMAIL_VERIFIED_AT ?? 'Not Yet Verified' }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn bg-secondary"
                                        onclick="detailUser('{{ $u->EMAIL }}','{{ $filter }}')">Detail</button>
                                    <button class="btn hover:bg-error"
                                        onclick="deleteUser('{{ $u->EMAIL }}','{{ $filter }}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                @if ($filter == 'Beeworker')
                    @foreach ($beeworkers as $u)
                        <tr>
                            <td>{{ $u->EMAIL }}</td>
                            <td>{{ $u->NAMA }}</td>
                            <td><i class="fa-solid fa-star text-secondary"></i>&nbsp;{{ $u->RATING }}</td>
                            <td>{{ $u->EMAIL_VERIFIED_AT }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn bg-secondary"
                                        onclick="detailUser('{{ $u->EMAIL }}','{{ $filter }}')">Detail</button>
                                    <button class="btn hover:bg-error"
                                        onclick="deleteUser('{{ $u->EMAIL }}','{{ $filter }}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                @if ($filter == 'Admin')
                    @foreach ($admins as $u)
                        <tr>
                            <td>{{ $u->EMAIL }}</td>
                            <td>{{ $u->NAMA }}</td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn bg-secondary"
                                        onclick="detailUser('{{ $u->EMAIL }}','{{ $filter }}')">Detail</button>
                                    <button class="btn hover:bg-error"
                                        onclick="deleteUser('{{ $u->EMAIL }}','{{ $filter }}')">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                @endif

            </tbody>
        </table>


    </div>


@endsection
@section('modal')

    @if ($filter == 'Admin')
        <div class="p-10 ml-10">

            <!-- Main modal -->
            <div id="authentication-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 p-4 w-full md:inset-0 h-modal md:h-full">
                <div class="relative w-full max-w-md h-full md:h-auto">
                    <!-- Modal content -->
                    <div class="relative bg-accent rounded-lg shadow-2xl">
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="authentication-modal">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="py-6 px-6 lg:px-8">
                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Add New Admin</h3>
                            <form class="w-full  p-2 sm:p-6 lg:p-8" method="post" action="">
                                @csrf
                                <input type="hidden" name="addAdmin" value="true">
                                <div class="">
                                    <label class="font-medium text-gray-900 w-1/2">Email</label>
                                    <input type="text" name="email"
                                        class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50 mb-4"
                                        data-primary="blue-600" data-rounded="rounded-lg"
                                        placeholder="Enter Admin Email Address" value="{{ old('email') }}" required />
                                    <label class="label w-full">
                                        @error('email')
                                            <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                        @enderror
                                    </label>
                                    <label class="font-medium text-gray-900 mt-5">Name</label>


                                    <input type="text" name="nama"
                                        class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                        data-primary="blue-600" data-rounded="rounded-lg" placeholder="Enter Admin Name"
                                        value="{{ old('nama') }}"required />

                                    <label class="label w-full">
                                        @error('nama')
                                            <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                        @enderror
                                    </label>
                                </div>


                                <div class=" mt-3">
                                    <label class="font-medium text-gray-900 w-1/2">Password</label>

                                        <input type="password" name="password"
                                            class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                            data-primary="blue-600" data-rounded="rounded-lg"
                                            placeholder="Enter Admin Password" value="{{ old('password') }}" required />

                                        <label class="label w-full">
                                            @error('password')
                                                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                            @enderror
                                        </label>
                                </div>


                                <div class=" mt-3">
                                     <label class="font-medium text-gray-900 w-1/2">Confirm Password</label>

                                        <input type="password" name="confirm"
                                            class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                            data-primary="blue-600" data-rounded="rounded-lg"
                                            placeholder="Enter Admin Confirmation Password" value="{{ old('confirm') }}"
                                            required />

                                        <label class="label w-full">
                                            @error('confirm')
                                                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                            @enderror
                                        </label>
                                </div>
                                <button
                                    class="btn btn-secondary inline-block w-full font-medium text-center  transition duration-200 rounded-lg ease mt-4"  data-rounded="rounded-lg">
                                    Add Admin
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    @endif
    </div>

@endsection
@section('script')

    <script>
        function deleteUser(email, from) {
            let navigator = "{{ url('/') }}";
            let conf = confirm("Apakah anda yakin untuk menghapus user " + email + "?\nThis action cannot be undone");
            if (conf) {
                window.location.href = navigator + "/admin/master/user/delete/" + email + "/" + from;
            }
        }

        function detailUser(email, from) {
            let navigator = "{{ url('/') }}";
            window.location.href = navigator + "/admin/master/user/detail/" + email + "/" + from;
        }
    </script>
@endsection
