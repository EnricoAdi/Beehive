{{-- ENRICO --}}
@extends('layout.masterapp')
{{-- INI UNTUK MASTER APP SELLER, semua page seller extends dari sini --}}
@php
// INI UNTUK DEFINE ROUTE SUPAYA NAVBAR SAMA SELLER BISA NYAMBUNG
$navbarRoute = [
    [
        'name' => 'Dashboard',
        'url' => '/seller',
        'icon' => 'fa-solid fa-chart-line',
        'subMenu' => '',
    ],
    [
        'name' => 'Sting',
        'url' => '/seller/sting',
        'icon' => 'fa-solid fa-briefcase',
        'subMenu' => [
            [
                'name' => 'List',
                'url' => '/seller/sting',
                'icon' => 'fa-solid fa-list',
            ],
            [
                'name' => 'Upload',
                'url' => '/seller/sting/upload',
                'icon' => 'fa-solid fa-upload',
            ],
        ],
    ],
    [
        'name' => 'Order',
        'url' => '/seller/order',
        'icon' => 'fa-solid fa-cart-shopping',
        'subMenu' => '',
    ],
    [
        'name' => 'Report',
        'url' => '/seller/report',
        'icon' => ' fa-solid fa-file ',
        'subMenu' => '',
    ],
    [
        'name' => 'Auction Sting',
        'url' => '/seller/auction',
        'icon' => 'fa-solid fa-comments-dollar',
        'subMenu' => '',
    ],
];
$routeString = '';
foreach ($route as $value) {
    $routeString .= '/' . $value;
}
@endphp
@section('navbar')
    @foreach ($navbarRoute as $nav)
        @if ($nav['subMenu'] == '')
            <li><a href="{{ url($nav['url']) }}"
                    @if ($routeString == $nav['url']) class="text-blue-700" @endif>{{ $nav['name'] }}</a></li>
        @else
            <li>
            <li class="dropdown dropdown-end">
                <label tabindex="0" class="capitalize">{{ $nav['name'] }}
                    <i
                    class="fa-solid fa-caret-down flex-shrink-0 w-6 h-6 mt-3 ml-2 text-gray-700 transition duration-75 group-hover:text-gray-900"></i>

                </label>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52  ">

                    @foreach ($nav['subMenu'] as $sub)
                        <li>
                            <a @if ($routeString == $sub['url']) class="text-blue-700" @endif href="{{ url($sub['url']) }}">
                                {{ $sub['name'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
            </li>
        @endif
    @endforeach
    <div tabindex="0" class="dropdown dropdown-end bg-secondary rounded-lg pr-3 pl-2 py-1">
        <div class="flex justify-center items-center gap-2">
            <label class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    @if ($user->PICTURE == '')
                        @if (env("APP_ENV")=="production")
                            <img src="{{ asset('profile-pictures/DEFAULT.JPG') }}" alt="">
                        @else
                            <img src="{{ asset('storage/profile-pictures/DEFAULT.JPG') }}" alt="">
                        @endif
                        </div>
                    @else
                        @if (env("APP_ENV")=="production")
                            <img src="{{ asset("profile-pictures/$user->PICTURE") }}" />
                        @else
                            <img src="{{ asset("storage/profile-pictures/$user->PICTURE") }}" />
                        @endif
                    @endif
        </div>
        </label>
        <label for="" class=" font-semibold">{{ $user->NAMA }}</label>
    </div>
    <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-full">
        <li><a href="{{url("/seller/profile")}}"><i class="fa-solid fa-user"></i>Profile</a></li>
        <li><a href="{{url("/logout")}}" class="text-red-500"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
    </ul>
    </div>
@endsection

@section('sidebar')
    @foreach ($navbarRoute as $nav)
        @if ($nav['subMenu'] == '')
            {{-- <li><a href="{{ url($nav['url']) }}"
                        @if ($routeString == $nav['url']) class="text-blue-700" @endif>{{ $nav['name'] }}</a></li> --}}
            <a href="{{ url($nav['url']) }}">
                <ul class="space-y-2">
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group text-gray">
                            @if ($routeString == $nav['url'])
                                <i
                                    class="{{ $nav['icon'] }} flex-shrink-0 w-6 h-6 mt-3 ml-7 text-blue-700 transition duration-75 group-hover:text-blue-700"></i>
                            @else
                                <i
                                    class="{{ $nav['icon'] }} flex-shrink-0 w-6 h-6 mt-3 ml-7 text-gray-700 transition duration-75 group-hover:text-gray-900"></i>
                            @endif
                            <span class="flex-1 ml-3 text-left whitespace-nowrap">

                                <p @if ($routeString == $nav['url']) class="text-blue-700" @endif> {{ $nav['name'] }}
                                </p>
                            </span>
                        </button>
                    </li>
                </ul>
            </a>
        @else
            <ul class="space-y-2">
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group  text-gray "
                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example{{ $nav['name'] }}">
                        @if ($routeString == $nav['url'])
                            <i
                                class="{{ $nav['icon'] }} flex-shrink-0 w-6 h-6 mt-3 ml-7 text-blue-700 transition duration-75 group-hover:text-blue-700"></i>
                        @else
                            <i
                                class="{{ $nav['icon'] }} flex-shrink-0 w-6 h-6 mt-3 ml-7 text-gray-700 transition duration-75 group-hover:text-gray-900"></i>
                        @endif
                        <span class="flex-1 ml-3 text-left whitespace-nowrap">

                            <p @if ($routeString == $nav['url']) class="text-blue-700" @endif> {{ $nav['name'] }}</p>
                        </span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <ul id="dropdown-example{{ $nav['name'] }}" class="hidden py-2 space-y-2">
                        @foreach ($nav['subMenu'] as $sub)
                            <li>

                                <a class="flex items-center w-full p-2 text-base font-normal  transition duration-75 rounded-lg pl-11 group hover:bg-gray-500 focus:bg-gray-500 "
                                    href="{{ url($sub['url']) }}">
                                    @if ($routeString == $sub['url'])
                                        <i
                                            class="{{ $sub['icon'] }} flex-shrink-0 w-6 h-6 mt-3 ml-7 text-blue-700 transition duration-75 group-hover:text-blue-700"></i>
                                    @else
                                        <i
                                            class="{{ $sub['icon'] }} flex-shrink-0 w-6 h-6 mt-3 ml-7 text-gray-700 transition duration-75 group-hover:text-gray-900"></i>
                                    @endif
                                    <span @if ($routeString == $sub['url']) class="text-blue-700" @endif>
                                        {{ $sub['name'] }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        @endif
    @endforeach

    <div tabindex="0" class="dropdown dropdown-end bg-primary rounded-lg pr-3 pl-2 py-3">
        <div class="flex justify-center items-center gap-2 space-x-3">
            <label class="btn btn-ghost btn-circle avatar">
                <div class="w-12 rounded-full">
                    @if ($user->PICTURE == '')
                        @if (env("APP_ENV")=="production")
                            <img src="{{ asset('profile-pictures/DEFAULT.JPG') }}" alt="">
                        @else
                            <img src="{{ asset('storage/profile-pictures/DEFAULT.JPG') }}" alt="">
                        @endif
                        </div>
                    @else
                        @if (env("APP_ENV")=="production")
                            <img src="{{ asset("profile-pictures/$user->PICTURE") }}" />
                        @else
                            <img src="{{ asset("storage/profile-pictures/$user->PICTURE") }}" />
                        @endif
                    @endif
                </div>
            </label>
            <label for="" class="  font-semibold text-xl text-neutral">{{ $user->NAMA }}</label>
        </div>
        <ul tabindex="0" class="mt-4 p-2 shadow menu menu-compact dropdown-content bg-neutral rounded-box w-full">
            <li><a href="{{url("/seller/profile")}}"><i class="fa-solid fa-user"></i>Profile</a></li>
            <li><a href="{{url("/logout")}}" class="text-red-500"><i class="fa-solid fa-right-from-bracket "></i>Logout</a></li>
        </ul>
    </div>
@endsection

@section('content')
    @yield('content')
@endsection
