{{-- ENRICO --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="lemonade">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="http://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ url('/assets/logo.jpg') }}">

    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css"
        integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q=="
        crossorigin="anonymous"referrerpolicy="no-referrer" /> --}}
    {{-- <link rel="stylesheet" href="https://mhs.sib.stts.edu/k3behive/build/assets/app.9326155c.css"> --}}
    <title>@yield('title')</title>

    @vite('resources/css/app.css')
    <style>
        /* INI BUAT ANIMASI 404 */
        .emoji-404 {
            position: relative;
            animation: mymove 2.5s infinite;
        }

        .font-poppins {
            font-family: 'Poppins';
        }

        @keyframes mymove {
            33% {
                top: 0px;
            }

            66% {
                top: 20px;
            }

            100% {
                top: 0px;
            }
        }



        .tag {
            pointer-events: none;
            background-color: #519259;
            color: white;
            padding: 6px;
            margin: 5px;
        }

        .tag::before {
            pointer-events: all;
            display: inline-block;
            content: 'x';
            height: 23px;
            width: 23px;
            margin-right: 6px;
            text-align: center;
            color: #ccc;
            background-color: #2e5032;
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-neutral">
    {{-- bg-gradient-to-r from-amber-100 to-gray-300 --}}
    @yield('body')
    @include('components.message') {{-- INI UNTUK MEMANGGIL MESSAGE --}}
    @include('components.modal') {{-- INI UNTUK MEMANGGIL MODAL --}}





    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"
        integrity="sha512-FHZVRMUW9FsXobt+ONiix6Z0tIkxvQfxtCSirkKc5Sb4TKHmqq1dZa8DphF0XqKb3ldLu/wgMa8mT6uXiLlRlw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('modal')

    <script type="text/javascript">
        function easyNumberSeparator(config) {
            // Currency Separator
            let commaCounter = 10;

            const obj = {
                selector: config.selector || ".number-separator",
                separator: config.separator || ",",
                decimalSeparator: config.decimalSeparator || ".",
                resultInput: config.resultInput
            }

            function numberSeparator(num) {
                for (let i = 0; i < commaCounter; i++) {
                    num = num.replace(obj.separator, "");
                }

                x = num.split(obj.decimalSeparator);
                y = x[0];
                z = x.length > 1 ? obj.decimalSeparator + x[1] : "";
                let rgx = /(\d+)(\d{3})/;

                while (rgx.test(y)) {
                    y = y.replace(rgx, "$1" + obj.separator + "$2");
                }
                commaCounter++;

                if (obj.resultInput) {
                    const resInput = document.querySelector(obj.resultInput)

                    if (resInput) {
                        resInput.value = num.replace(obj.separator, "")
                        resInput.value = num.replace(obj.decimalSeparator, ".")
                    }
                }

                return y + z;
            }

            function listenFields() {
                document.querySelectorAll(obj.selector).forEach(function(el) {
                    el.addEventListener("input", function(e) {
                        const reg = new RegExp(
                            `^-?\\d*[${obj.separator}${obj.decimalSeparator}]?(\\d{0,3}${obj.separator})*(\\d{3}${obj.separator})?\\d{0,3}$`
                        );

                        const key = e.data || this.value.substr(-1)

                        if (reg.test(key)) {
                            e.target.value = numberSeparator(e.target.value);
                        } else {
                            e.target.value = e.target.value.substring(0, e.target.value.length - 1);
                            e.preventDefault();
                            return false;
                        }
                    });
                    el.value = numberSeparator(el.value);
                });
            }

            listenFields()

            // Fire separator when every element append to page
            document.addEventListener("DOMNodeInserted", function(e) {
                if ((e.target).classList.contains(obj.selector.replace('.', ''))) {
                    listenFields()
                }
            });
        }
    </script>
    @yield('script')
</body>

</html>
