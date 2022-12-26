@extends('Seller.layout.masterapp')
@section('title', 'Add List Sting Beeworker')




@section('content')
    <h1 class="text-3xl font-bold ml-20 mt-5">Edit Sting {{ $sting->TITLE_STING }}</h1>
    <a href="{{ url("/seller/sting/edit/$sting->ID_STING") }}" class="btn btn-secondary w-28 ml-20 mt-4">Back</a>

    <div class="px-20 mt-10  w-full ">
        <div class="flex justify-center">
            <form action="{{ url("/seller/sting/thumbnail/$sting->ID_STING") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div>
                    @if (env('APP_ENV') == 'production')
                        <img src="{{ asset("sting-thumbnails/$sting->NAMA_THUMBNAIL") }}" alt=""
                            class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                    @else
                        <img src="{{ asset("storage/sting-thumbnails/$sting->NAMA_THUMBNAIL") }}" alt=""
                            class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                    @endif



                    <input type="file" class="file-input w-full max-w-xs" name="foto" />
                    <br>
                    <button class="btn btn-success">Edit Thumbnail</button>


                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 p-10">
            <div>
                @if ($media1 != null)
                    <form action="{{ url("/seller/sting/media1/$sting->ID_STING") }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("sting-media/$media1->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @else
                            <img src="{{ asset("storage/sting-media/$media1->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @endif
                        <input type="file" class="file-input w-full max-w-xs" name="foto" />
                        <br>
                        <button class="btn btn-success">Edit Picture 1</button>
                    </form>
                @endif
            </div>

            <div>
                @if ($media2 != null)

                    <form action="{{ url("/seller/sting/media2/$sting->ID_STING") }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("sting-media/$media2->FILENAME") }}" alts=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @else
                            <img src="{{ asset("storage/sting-media/$media2->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @endif
                        <input type="file" class="file-input w-full max-w-xs" name="foto" />
                        <br>
                        <button class="btn btn-success">Edit Picture 2</button>
                    </form>
                @endif
            </div>

            <div>
                @if ($media3 != null)

                    <form action="{{ url("/seller/sting/media3/$sting->ID_STING") }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("sting-media/$media3->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @else
                            <img src="{{ asset("storage/sting-media/$media3->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @endif
                        <input type="file" class="file-input w-full max-w-xs" name="foto" />
                        <br>
                        <button class="btn btn-success">Edit Picture 3</button>
                    </form>
                @endif
            </div>

            <div>
                @if ($media4 != null)

                    <form action="{{ url("/seller/sting/media4/$sting->ID_STING") }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if (env('APP_ENV') == 'production')
                            <img src="{{ asset("sting-media/$media4->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @else
                            <img src="{{ asset("storage/sting-media/$media4->FILENAME") }}" alt=""
                                class="object-cover w-80 mb-4 h-60 sm:h-52 dark:bg-gray-500 shadow-lg rounded-md">
                        @endif
                        <input type="file" class="file-input w-full max-w-xs" name="foto" />
                        <br>
                        <button class="btn btn-success">Edit Picture 4</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
