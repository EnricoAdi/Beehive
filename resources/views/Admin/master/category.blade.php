@extends('Admin.layout.masterapp')
@section('title', 'Master Category Beehive')

@section('content')

    {{-- <tr>
    <th>1</th>
    <td>Cy Ganderton</td>
    <td>Buat Mobile app</td>
    <td>Premium</td>
    <td>Rp 3.000.000</td>
    <td>
        <div class="btn-group">
            <button class="btn text-neutral bg-primary hover:bg-primary-focus">Accept</button>
            <button class="btn text-neutral bg-error hover:bg-red-500">Decline</button>
        </div>
    </td>
</tr> --}}
    <h1 class="text-3xl ml-20 mt-5 font-semibold block">Master Category</h1>
    <div class="overflow-x-auto p-10 ml-10">
        <table class="table table-zebra w-full rounded-md">
            <!-- head -->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Stings Related</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $c)
                    <tr>
                        <th>{{ $c->ID_CATEGORY }}</th>
                        <td>{{ $c->NAMA_CATEGORY }}</td>
                        <td>{{ $c->CREATED_AT }}</td>
                        <td>{{ sizeof($c->stingsRelated) }} Stings Related</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn bg-secondary"
                                    onclick="detailCategory('{{ $c->ID_CATEGORY }}')">Detail</button>
                                <button class="btn hover:bg-error"
                                    onclick="deleteCategory('{{ $c->ID_CATEGORY }}')">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $categories->links() }}


        <h1 class="text-2xl mt-5 font-semibold block">Add Category</h1>

        <div class="indicator mt-4">
            @if ($errors->any())
                <span class="indicator-item badge badge-error"></span>
            @endif
            <button
                class="block  focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg  px-5 py-2.5 btn btn-secondary"
                type="button" data-modal-toggle="authentication-modal">
                Add Category!
            </button>
        </div>


    </div>
@endsection
@section('modal')
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
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Add New Category</h3>
                    <form class="w-full   p-4 sm:p-6 lg:p-8  " method="post" action="">
                        @csrf
                        <input type="hidden" name="addAdmin" value="true">
                        <div class="">
                            <div class="flex w-full gap-x-3">
                                <label class="font-medium text-gray-900">Nama Category</label>
                            </div>

                            <div class="flex gap-x-3">
                                <input type="text" name="nama"
                                    class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                    data-primary="blue-600" data-rounded="rounded-lg" placeholder="Input Nama Category"
                                    value="{{ old('nama') }}"required />
                            </div>
                            @error('nama')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>

                        <button
                            class="inline-block w-full  font-medium text-center transition duration-200  rounded-lg  ease mt-4 btn btn-secondary"  data-rounded="rounded-lg">
                            Add Category
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        function deleteCategory(id) {
            let navigator = "{{ url('/') }}";
            let conf = confirm("Apakah anda yakin untuk menghapus category ini?\nThis action cannot be undone");
            if (conf) {
                window.location.href = navigator + "/admin/master/category/delete/" + id;
            }
        }

        function detailCategory(id) {
            let navigator = "{{ url('/') }}";
            window.location.href = navigator + "/admin/master/category/detail/" + id;
        }
    </script>
@endsection
