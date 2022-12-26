{{-- ENRICO --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lemonade">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="http://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/logo.jpg') }}">

    <title>Login to Beehive</title>
    {{-- <link rel="stylesheet" href="https://mhs.sib.stts.edu/k3behive/build/assets/app.9326155c.css"> --}}
    @vite('resources/css/app.css')
    <style>
        .font-poppins {
            font-family: 'Poppins';
        }

        .bg {
            animation: slide 3s ease-in-out infinite alternate;
            background-image: linear-gradient(-60deg, #F7B94A 50%, #3E7C17 50%);
            bottom: 0;
            left: -50%;
            opacity: .5;
            position: fixed;
            right: -50%;
            top: 0;
            z-index: -1;
        }

        .bg2 {
            animation-direction: alternate-reverse;
            animation-duration: 4s;
        }

        .bg3 {
            animation-duration: 5s;
        }

        .content {
            border-radius: .25em;
            box-sizing: border-box;
            left: 50%;
            padding: 10vmin;
            position: fixed;
            text-align: center;
            top: 50%;
            transform: translate(-50%, -50%);
        }


        @keyframes slide {
            0% {
                transform: translateX(-25%);
            }

            100% {
                transform: translateX(25%);
            }
        }
    </style>
</head>

<body class="">

    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>
    <div class="content">
        <form class="flex w-full justify-center  " method="post" action="">
            @csrf
            <div class="relative z-10 p-8 py-10 overflow-hidden bg-slate-200 border-b-2 border-gray-300 rounded-lg shadow-2xl mx-8 w-96 md:w-full mt-16 "
                data-rounded="rounded-lg" data-rounded-max="rounded-full">
                <h3 class="mb-6 text-2xl font-medium text-center">
                    Sign in to your <a href={{ url('/') }} class="underline">Beehive</a> Account
                </h3>
                <input type="email" name="email" id="email"
                    class="block w-full px-4 py-3 mb-4 border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none"
                    data-rounded="rounded-lg" data-primary="blue-500" placeholder="Email address"
                    value="{{ old('email') }}">

                @error('email')
                    <label class="label">
                        <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                    </label>
                @enderror
                <input type="password" name="password" id="password"
                    class="block w-full px-4 py-3 mb-4  border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none"
                    data-rounded="rounded-lg" data-primary="blue-500" placeholder="Password">

                @error('password')
                    <label class="label">
                        <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                    </label>
                @enderror
                <div class="block">
                    <button class="btn btn-secondary w-full px-3 py-4 font-medium   rounded-lg"
                        data-rounded="rounded-lg">Log Me In</button>
                </div>
                <p class="w-full mt-4 text-sm text-center text-gray-500">Don't have an account? <a
                        href="{{ url('/register') }}" class="text-blue-500 underline">Sign up here</a></p>
                <p class="w-full mt-4 text-sm text-center text-gray-500">Forgot Password? <a href="{{ url('/forgot') }}"
                        class="text-blue-500 underline">Click here</a></p>
            </div>
        </form>
    </div>
    @include('components.message')
    @include('components.modal')





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
        integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>

</body>

</html>
