@extends('Seller.layout.masterapp')
@section('title', 'Add List Sting Beeworker')




@section('content')

    <datalist id="categories-complete">
        @foreach ($categories as $c)
            <option>{{ $c->NAMA_CATEGORY }}</option>
        @endforeach
    </datalist>
    <input type="hidden" id="categoriesinArray" value="@foreach ($categories as $c){{ $c->NAMA_CATEGORY . ',' }} @endforeach">
    <form method="POST" action="{{ url('/seller/sting/upload') }}" enctype="multipart/form-data" class="overflow-y-auto">
        @csrf
        <h1 class="text-2xl ml-20 mt-5 font-bold">Add Sting</h1>
        <div class="px-20 pb-20 pt-4 w-full flex justify-evenly">
            <div class="flex-initial w-1/3">
                <label class="">Sting title:</label><br>
                <input type="text" name="title" placeholder="Masukkan judul sting"
                    class="input input-bordered input-primary w-full max-w-xl" value="{{ old('title') }}" />
                <span style="color: red;" class="errorInput">{{ $errors->first('title') }}</span> <br><br>

                <label class="">Deskripsi Sting</label><br>
                <textarea name="deskripsi" class="textarea textarea-primary w-full max-w-xl"
                    placeholder="Deskripsikan stingmu dengan detail" value="{{ old('deskripsi') }}" />{{ old('deskripsi') }}</textarea>
                <span style="color: red;" class="errorInput">{{ $errors->first('deskripsi') }}</span><br><br>


                {{-- opsi 1 --}}
                {{-- <div class="w-full max-w-xl">
                    <div class="flex justify-center items-center w-45">
                        <label for="dropzone-file"
                            class="flex flex-col justify-center items-center w-full h-57 bg-gray-50 rounded-lg border-2 border-gray-300 border-dashed cursor-pointer ">
                            <div class="flex flex-col justify-center items-center pt-5 pb-6">
                                <svg aria-hidden="true" class="mb-3 w-10 h-10 text-gray-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                        to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPEG or JPG (MAX. 800x400px)
                                </p>
                            </div>
                            <input name="foto" id="dropzone-file" type="file" class="hidden" />
                            <span style="color: red;" class="errorInput">{{ $errors->first('foto') }}</span>
                        </label>
                    </div>
                </div> --}}

                {{-- opsi 2 --}}
                <label class="" for="file_input">Upload Thumbnail</label> &nbsp;<span
                    style="color: red;">{{ $errors->first('foto') }}</span>
                <input class="input input-bordered input-primary w-full max-w-xl mb-3" id="file_input" type="file"
                    name="foto">


                <label class="" for="file_input">Upload Gambar 1</label>&nbsp;<span
                    style="color: red;">{{ $errors->first('media1') }}</span>
                <input class="input input-bordered input-primary w-full max-w-xl mb-3" id="file_input" type="file"
                    name="media1">


                <label class="" for="file_input">Upload Gambar 2</label>&nbsp;<span
                    style="color: red;">{{ $errors->first('media2') }}</span>
                <input class="input input-bordered input-primary w-full max-w-xl mb-3" id="file_input" type="file"
                    name="media2">


                <label class="" for="file_input">Upload Gambar 3</label>&nbsp;<span
                    style="color: red;">{{ $errors->first('media3') }}</span>
                <input class="input input-bordered input-primary w-full max-w-xl mb-3" id="file_input" type="file"
                    name="media3">


                <label class="" for="file_input">Upload Gambar 4</label>&nbsp;<span
                    style="color: red;">{{ $errors->first('media4') }}</span>
                <input class="input input-bordered input-primary w-full max-w-xl mb-3" id="file_input" type="file"
                    name="media4">




                <div class="wrapper mt-7">
                    <h3 class="">Inputkan Kategori</h3>
                    <p class="info ">tulis kategori dan tekan enter</p>
                    <input type="text" id="hashtags" autocomplete="off" onkeydown="return event.key != 'Enter';"
                        class="textarea textarea-primary w-full max-w-xl" list="categories-complete">
                    <div class="tag-container flex space-x-2 mt-2">
                        <span style="color: red;" class="errorInput">{{ $errors->first('category') }}</span>
                    </div>
                </div>

                <input type="hidden" class="temp" name="category" id="category" value="">




            </div>



            <div class="flex-initial w-1/3">
                <div class="card w-96 text-primary-content mt-3 bg-secondary">
                    <div class="card-body">
                        <h2 class="card-title">Basic Plan</h2>
                        <input type="text" placeholder="Harga Plan"
                            class="input input-bordered w-full max-w-xl number-separator1" value="{{ old('harga1') }}"
                            required /> <span style="color: red;" class="errorInput">{{ $errors->first('harga1') }}</span>
                        <input name="revisi1" type="number" placeholder="Revisi Max"
                            class="input input-bordered w-full max-w-xl" value="{{ old('revisi1') }}" required /> <span
                            style="color: red;" class="errorInput">{{ $errors->first('revisi1') }}</span>
                        <textarea name="desk1" class="textarea textarea-primary w-full max-w-xl" placeholder="Deskripsi Basic Plan"
                            value="{{ old('desk1') }}">{{ old('desk1') }}</textarea> <span style="color: red;"
                            class="errorInput">{{ $errors->first('desk1') }}</span>

                    </div>
                </div>

                <div class="card w-96 text-primary-content mt-3 bg-secondary">
                    <div class="card-body">
                        <h2 class="card-title">Premium Plan</h2>
                        <input type="text" placeholder="Harga Plan"
                            class="input input-bordered w-full max-w-xl number-separator2" value="{{ old('harga2') }}" /> <span
                            style="color: red;" class="errorInput">{{ $errors->first('harga2') }}</span>
                        <input name="revisi2" type="number" placeholder="Revisi Max"
                            class="input input-bordered w-full max-w-xl" value="{{ old('revisi2') }}" /> <span
                            style="color: red;" class="errorInput">{{ $errors->first('revisi2') }}</span>
                        <textarea name="desk2" class="textarea textarea-primary w-full max-w-xl" placeholder="Deskripsi Basic Plan"
                            value="{{ old('desk2') }}">{{ old('desk2') }}</textarea> <span style="color: red;"
                            class="errorInput">{{ $errors->first('desk2') }}</span>
                    </div>
                </div>
                <button type="submit" class="text-1xl btn btn-secondary mt-10 btn-lg w-96 h-30">Add Sting</button>

            </div>
        </div>

        <input type="hidden" id="result_input1" name="harga1">
        <input type="hidden" id="result_input2" name="harga2">
    </form>



@endsection
@section('script')

    <script>
        easyNumberSeparator({
            selector: '.number-separator1',
            separator: ',',
            decimalSeparator: '.',
            resultInput: '#result_input1',
        })
        easyNumberSeparator({
            selector: '.number-separator2',
            separator: ',',
            decimalSeparator: '.',
            resultInput: '#result_input2',
        })
    </script>
    <script type="text/javascript">
        let input, hashtagArray, container, t;
        input = document.querySelector('#hashtags');
        container = document.querySelector('.tag-container');
        listCategoryAvailable = [];
        hashtagArray = [];
        window.onload = (event) => {
            let gets = document.getElementById("categoriesinArray").value;
            let tempArr = gets.split(", ");
            //ini buat array untuk cek sblm di submit
            for (let i = 0; i < tempArr.length; i++) {
                const element = tempArr[i];
                if (!(element == " " || element == "")) {
                    listCategoryAvailable.push(element.toLowerCase());
                }
            }
            // console.log(listCategoryAvailable);
        };

        setTimeout(() => {
            let errArray = document.getElementsByClassName("errorInput");
            for (let i = 0; i < errArray.length; i++) {
                const err = errArray[i];
                err.style.display = "none";
            }
        }, 6000);
        input.addEventListener('keyup', () => {
            if (event.which == 13 && input.value.length > 0) {
                var text = document.createTextNode(input.value);
                var p = document.createElement('p');
                if (listCategoryAvailable.includes(input.value.toLowerCase())) {
                    if (!hashtagArray.includes(input.value.toLowerCase())) {

                        container.appendChild(p);
                        p.appendChild(text);
                        p.classList.add('tag');

                        hashtagArray.push(input.value.toLowerCase());


                        //save data di input type hidden
                        let kategori = document.getElementById('category');
                        kategori.value = '';
                        hashtagArray.forEach(element => {
                            kategori.value = kategori.value + element + ',';
                        });

                        input.value = '';

                        let deleteTags = document.querySelectorAll('.tag');

                        for (let i = 0; i < deleteTags.length; i++) {
                            deleteTags[i].addEventListener('click', () => {
                                container.removeChild(deleteTags[i]);
                                hashtagArray.splice(i, 1);
                                let kategori = document.getElementById('category');
                                kategori.value = '';
                                hashtagArray.forEach(element => {
                                    kategori.value = kategori.value + element + ',';
                                });
                            });
                        }
                    } else {
                        alert("Anda sudah menambahkan kategori " + input.value.toLowerCase() + "!")
                    }
                } else {
                    alert("Tidak ada kategori " + input.value)
                }
            }
        });
    </script>
@endsection
