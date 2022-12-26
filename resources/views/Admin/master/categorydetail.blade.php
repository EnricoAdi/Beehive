@extends('Admin.layout.masterapp')
@section('title', 'Master Category Beehive')

@section('content')

    <div class="h-full">
        <h1 class="text-3xl ml-20 mt-5 font-semibold block">Category {{ $c->NAMA_CATEGORY }} Detail</h1>
        <a href="{{ url('/admin/master/category') }}"><button class="btn btn-secondary ml-20 mt-3">Back</button></a>
        <div class="border-b-2 block md:flex">


            <form action="" method="post" class="w-full md:w-3/5 p-8 bg-accent rounded-lg ml-20 mt-5">
                @csrf
                @method('PATCH')
                <div class="rounded p-6">
                    <div class="pb-6">
                        <label class="font-semibold text-gray-700 block pb-1">Nama Category</label>
                        <div class="flex">
                            <input name="nama" class="border-1  rounded-r px-4 py-2 w-full" type="text"
                                value="{{ $c->NAMA_CATEGORY }}" />
                            @error('nama')
                                <label class="label">
                                    <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                                </label>
                            @enderror
                        </div>
                    </div>

                    <div class="pb-6">
                        <label for="name" class="font-semibold text-gray-700 block pb-1">Category Created At</label>
                        <div class="flex">
                            <input type="datetime-local" name="created"
                                class="input input-primary block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400  rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                data-rounded="rounded-lg" value="{{ $c->CREATED_AT }}" disabled />

                        </div>
                    </div>
                    <label class="font-semibold text-gray-700 block pb-1">Stings Related : {{ sizeof($c->stingsRelated) }}
                        sting(s)</label>

                    <button class="btn btn-secondary">Save Changes</button>

                </div>
            </form>
        </div>
    </div>

@endsection
