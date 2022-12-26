@extends('Buyer.layout.masterapp')
@section('title', 'Auction Make')

@section('content')

<input type="checkbox" id="modalSubscribe" class="modal-toggle" />
<div class="modal modal-bottom sm:modal-middle">
    <div class="modal-box">
        <h3 class="font-bold text-lg">Beehive</h3>
        <p class="py-4">You dont have access to this feature</p>
        <div class="modal-action">
            <a href="{{ url('/buyer/subscribe') }}" class="btn btn-success mt-6 shadow-md">Upgrade Now</a>
        </div>
    </div>
</div>
    <h1 class="text-3xl ml-20 mt-5 font-semibold block ">Create Auction</h1>

        <a href="{{ url('/buyer/auction') }}" class="btn btn-secondary ml-20 w-24 mt-5  @if ($user->SUBSCRIBED == 0) blur-sm @endif">Back</a>
        <datalist id="categories-complete">
            @foreach ($categories as $c)
                <option>{{ $c->NAMA_CATEGORY }}</option>
            @endforeach
        </datalist>
        <input type="hidden" id="categoriesinArray"
            value="@foreach ($categories as $c){{ $c->NAMA_CATEGORY . ',' }} @endforeach">


        <form method="POST" class="mt-5 ml-20 " action="">
            @csrf
            <div class="p-5 bg-accent shadow-md rounded-md w-1/2">

                <h3 class="font-bold text-lg">Judul Lelang</h3>
                <input type="text" name="title"
                    class="block w-full px-4 py-3 mb-4 border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none mt-5"
                    data-rounded="rounded-lg" data-primary="blue-500" placeholder="Inputkan title lelang sting" required
                    value="{{ old('title') }}">

                @error('title')
                    <label class="label">
                        <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                    </label>
                @enderror

                <h3 class="font-bold text-lg">Requirement Project</h3>
                <textarea name="requirement" class="input input-primary border-1 rounded-md px-4 py-2 mt-5 w-full h-32" required
                    placeholder="Input your project requirement!"></textarea>
                @error('requirement')
                    <label class="label">
                        <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                    </label>
                @enderror
                <br>

                <h3 class="font-bold text-lg mt-3">Harga Project</h3>
                <input type="text" 
                    class="block w-full px-4 py-3 mb-4 border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none mt-5 number-separator1"
                    data-rounded="rounded-lg" data-primary="blue-500" placeholder="Inputkan harga proyek lelang sting"
                    required value="{{ old('price') }}">
                @error('price')
                    <label class="label">
                        <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                    </label>
                @enderror
                <div class="wrapper mt-7">
                    <h3 class="font-bold text-lg">Kategori</h3>
                    <p class="info mb-2">tulis kategori dan tekan enter</p>
                    <input type="text" id="hashtags" autocomplete="off" onkeydown="return event.key != 'Enter';"
                        class="textarea textarea-primary w-full" list="categories-complete" placeholder="Input Kategori">
                    <div class="tag-container flex space-x-2 mt-2">
                        <span style="color: red;" class="errorInput">{{ $errors->first('category') }}</span>
                    </div>

                    <input type="hidden" class="temp" name="category" id="category" value="">
                </div>
                <button class="btn btn-secondary w-full mt-3">Create Auction Sting!</button>
            </div>


            <input type="hidden" id="result_input1" name="price">
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
</script>
@if ($user->SUBSCRIBED == 0)
<script>
    document.getElementById('modalSubscribe').checked = true;
</script>
@endif
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
