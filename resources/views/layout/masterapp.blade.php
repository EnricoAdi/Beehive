{{-- ENRICO --}}
@extends('layout.master')

@section('body')
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col ">
            <!-- Navbar -->
            <div class="w-full navbar bg-accent">
                <div class="flex-none lg:hidden ">
                    <label for="my-drawer-3" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-6 h-6 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1 px-2 mx-2 ">
                    <a href={{url("/")}}>
                        <img src="{{ url('assets/logo.jpg') }}" alt="Ini lebah ngeeng" class="w-24 -my-2">
                    </a>
                </div>
                <div class="flex-none hidden lg:block">
                    <ul class="menu menu-horizontal  ">
                        <!-- Navbar menu content here -->
                            @yield('navbar')
                    </ul>
                </div>
            </div>
            <!-- Page content here -->
            @yield('content')
        </div>
        <div class="drawer-side" id="drawer-navigation" tabindex="-1" aria-labelledby="drawer-navigation-label">
            <label for="my-drawer-3" class="drawer-overlay"></label>
            <ul class="menu p-4 overflow-y-auto w-80 bg-accent">
                <!-- Sidebar content here -->
                @yield('sidebar')

            </ul>

        </div>
    </div>
@endsection
