@extends('layout.master')

@section('title', 'Beehive Freelance Marketplace')

@section('body')
    {{-- MK --}}
    <section class="w-full px-6 pb-12 antialiased bg-white" data-tails-scripts="//unpkg.com/alpinejs">
        <div class="mx-auto max-w-7xl">
            <nav class="relative z-50 h-24 select-none" x-data="{ showMenu: false }">
                <div
                    class="container relative flex flex-wrap items-center justify-between h-24 mx-auto overflow-hidden font-medium border-b border-gray-200 md:overflow-visible lg:justify-center sm:px-4 md:px-2 lg:px-0">
                    <div class="flex items-center justify-start w-1/4 h-full pr-4">
                        <a href="" class="inline-block py-4 md:py-0">
                            <span class="p-1 text-xl font-black leading-none text-gray-900">
                                <img src="{{ url('assets/logo.jpg') }}" alt="Ini lebah ngeeng" class="w-24">
                            </span>
                        </a>
                    </div>
                    <div class="top-0 left-0 items-start hidden w-full h-full p-4 text-sm bg-gray-900 bg-opacity-50 md:items-center md:w-3/4 md:absolute lg:text-base md:bg-transparent md:p-0 md:relative md:flex"
                        :class="{ 'flex fixed': showMenu, 'hidden': !showMenu }">
                        <div
                            class="flex-col w-full h-auto overflow-hidden bg-white rounded-lg md:bg-transparent md:overflow-visible md:rounded-none md:relative md:flex md:flex-row">
                            <a href=""
                                class="inline-flex items-center block w-auto h-16 px-6 text-xl font-black leading-none text-gray-900 md:hidden">Beehive<span
                                    class="text-indigo-600">.</span>
                            </a>
                            <div
                                class="flex flex-col items-start justify-center w-full space-x-6 text-center lg:space-x-8 md:w-2/3 md:mt-0 md:flex-row md:items-center">
                                <a href=""
                                    class="inline-block w-full py-2 mx-0 ml-6 font-medium text-left text-primary md:ml-0 md:w-auto md:px-0 md:mx-2 lg:mx-3 md:text-center">Home</a>
                                <a href="#faq"
                                    class="inline-block w-full py-2 mx-0 font-medium text-left text-gray-700 md:w-auto md:px-0 md:mx-2 hover:text-primary lg:mx-3 md:text-center">FAQ</a>
                                <a href="#testimonials"
                                    class="inline-block w-full py-2 mx-0 font-medium text-left text-gray-700 md:w-auto md:px-0 md:mx-2 hover:text-primary lg:mx-3 md:text-center">Testimonials</a>
                                <a href="#contacts"
                                    class="inline-block w-full py-2 mx-0 font-medium text-left text-gray-700 md:w-auto md:px-0 md:mx-2 hover:text-primary lg:mx-3 md:text-center">Our
                                    Team</a>
                                <a href=""
                                    class="absolute top-0 left-0 hidden py-2 mt-6 ml-10 mr-2 text-gray-600 lg:inline-block md:mt-0 md:ml-2 lg:mx-3 md:relative">
                                    <svg class="inline w-5 h-5" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </a>
                            </div>
                            @if ($user == '')
                                <div
                                    class="flex flex-col items-start justify-end w-full pt-4 md:items-center md:w-1/3 md:flex-row md:py-0">
                                    <a href="{{ url('/login') }}"
                                        class="w-full px-3 py-2 mr-0 text-gray-700 md:mr-2 lg:mr-3 md:w-auto">Sign In</a>
                                    <a href="{{ url('/register') }}"
                                        class="inline-flex items-center w-full px-6 py-3 text-sm font-medium leading-4 text-white bg-primary md:px-3 md:w-auto md:rounded-full lg:px-5 hover:bg-indigo-500 focus:outline-none md:focus:ring-2 focus:ring-0 focus:ring-offset-2 focus:ring-indigo-600">Sign
                                        Up</a>
                                </div>
                            @else
                            <div class="flex flex-col items-start justify-end w-full pt-4 md:items-center md:w-1/3 md:flex-row md:py-0">
                                <a href="{{url($toApp)}}"
                                    class="inline-flex items-center w-full px-6 py-3 text-sm font-medium leading-4 text-white  md:px-3 md:w-auto rounded-lg lg:px-5 hover:bg-indigo-500 focus:outline-none md:focus:ring-2 focus:ring-0 focus:ring-offset-2 focus:ring-indigo-600 bg-primary">To App</a>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div @click="showMenu = !showMenu"
                        class="absolute right-0 flex flex-col items-center items-end justify-center w-10 h-10 bg-white rounded-full cursor-pointer md:hidden hover:bg-gray-100">
                        <svg class="w-6 h-6 text-gray-700" x-show="!showMenu" fill="none" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="w-6 h-6 text-gray-700" x-show="showMenu" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </div>
                </div>
            </nav>
            <div class="container max-w-lg px-4 py-32 mx-auto mt-px text-left md:max-w-none md:text-center">
                <h1
                    class="text-5xl font-extrabold leading-10 tracking-tight text-left text-gray-900 md:text-center sm:leading-none md:text-6xl lg:text-7xl">
                    <span class="inline md:block tails-relative">Turn your idea into money</span>
                    <span
                        class="relative mt-2 text-transparent bg-clip-text bg-gradient-to-b from-primary to-secondary md:inline-block">Meet
                        great business partner at Beehive</span>
                </h1>
                <div class="mx-auto mt-5 text-gray-500 md:mt-12 md:max-w-lg md:text-center lg:text-lg">
                    The place where you can find any type of business!
                </div>
                {{-- <div class="flex flex-col items-center mt-12 text-center">
                    <span class="relative inline-flex w-full md:w-auto">
                        <a href="" type="button"
                            class="inline-flex items-center justify-center w-full px-8 py-4 text-base font-bold leading-6 text-white bg-primary border border-transparent rounded-full md:w-auto hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                            Purchase Now
                        </a>
                        <span
                            class="absolute top-0 right-0 px-2 py-1 -mt-3 -mr-6 text-xs font-medium leading-tight text-white bg-green-400 rounded-full">only
                            $15/mo
                        </span>
                    </span>
                    <a href="" class="mt-3 text-sm text-secondary">Learn More</a>
                </div> --}}
            </div>
        </div>
    </section>
    <section class="h-auto bg-white">
        <div class="px-10 py-24 mx-auto max-w-7xl">
            <div class="w-full mx-auto text-left md:text-center">
                <h1
                    class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-900 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                    Find <span
                        class="w-full text-transparent bg-clip-text bg-gradient-to-r from-primary-focus via-error to-secondary lg:inline">The
                        most suitable freelancer</span> for<br class="lg:block hidden"> all of your business needs.</h1>
                <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl lg:px-24"> Connect with freelancers with high
                    experience</p>
            </div>
        </div>
    </section>
    {{-- <section class="px-2 py-32 bg-white md:px-0">
        <div class="container items-center max-w-6xl px-8 mx-auto xl:px-5">
            <div class="flex flex-wrap items-center sm:-mx-3">
                <div class="w-full md:w-1/2 md:px-3">
                    <div
                        class="w-full pb-6 space-y-6 sm:max-w-md lg:max-w-lg md:space-y-4 lg:space-y-8 xl:space-y-9 sm:pr-5 lg:pr-0 md:pb-0">
                        <h1
                            class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-4xl lg:text-5xl xl:text-6xl">
                            <span class="block xl:inline">Beautiful Pages to</span>
                            <span class="block text-indigo-600 xl:inline" data-primary="indigo-600">Tell Your Story!</span>
                        </h1>
                        <p class="mx-auto text-base text-gray-500 sm:max-w-md lg:text-xl md:max-w-3xl">It's never been
                            easier to build beautiful websites that convey your message and tell your story.</p>
                        <div class="relative flex flex-col sm:flex-row sm:space-x-4">
                            <a href=""
                                class="flex items-center w-full px-6 py-3 mb-3 text-lg text-white bg-indigo-600 rounded-md sm:mb-0 hover:bg-indigo-700 sm:w-auto"
                                data-primary="indigo-600" data-rounded="rounded-md">
                                Try It Free
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-arrow-right">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                            <a href=""
                                class="flex items-center px-6 py-3 text-gray-500 bg-gray-100 rounded-md hover:bg-gray-200 hover:text-gray-600"
                                data-rounded="rounded-md">
                                Learn More
                            </a>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2">
                    <div class="w-full h-auto overflow-hidden rounded-md shadow-xl sm:rounded-xl"
                        data-rounded="rounded-xl" data-rounded-max="rounded-full">
                        <img src="https://cdn.devdojo.com/images/november2020/hero-image.jpeg">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="flex items-center justify-center py-10 text-white bg-white sm:py-16 md:py-24 lg:py-32">
        <div class="relative max-w-3xl px-10 text-center text-white auto lg:px-0">
            <div class="flex flex-col w-full md:flex-row">
                <div class="flex justify-between">
                    <h1 class="relative flex flex-col text-6xl font-extrabold text-left text-black">
                        Crafting
                        <span>Powerful</span>
                        <span>Business</span>
                        <span>Experiences</span>
                    </h1>
                </div>
                <div class="relative top-0 right-0 h-64 mt-12 md:-mt-16 md:absolute md:h-96">
                    <img src="https://cdn.devdojo.com/images/december2020/designs3d.png"
                        class="object-cover mt-3 mr-5 h-80 lg:h-96">
                </div>
            </div>
            <div class="my-16 border-b border-gray-300 lg:my-24"></div>
            <h2 class="text-left text-gray-500 xl:text-xl">
                Build mutual relation for your next project. We've discover thousands freelancers who love to have a project
                with you!.
            </h2>
        </div>
    </section>
    {{-- FITUR --}}
    {{-- <section class="py-20 bg-white">
        <div class="container max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold tracking-tight text-center">Our Features</h2>
            <p class="mt-2 text-lg text-center text-gray-600">Check out our list of awesome features below.</p>
            <div class="grid grid-cols-4 gap-8 mt-10 sm:grid-cols-8 lg:grid-cols-12 sm:px-8 xl:px-0">
                <div class="relative flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 overflow-hidden bg-gray-100 sm:rounded-xl"
                    data-rounded="rounded-xl" data-rounded-max="rounded-full">
                    <div class="p-3 text-white bg-blue-500 rounded-full" data-primary="blue-500"
                        data-rounded="rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M5 8v-3a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2h-5" />
                            <circle cx="6" cy="14" r="3" />
                            <path d="M4.5 17l-1.5 5l3 -1.5l3 1.5l-1.5 -5" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-medium text-gray-700">Pick your favourite sting!</h4>
                    <p class="text-base text-center text-gray-500">
                        Pilih sting sesuai dengan keinginan Anda!
                    </p>
                </div>
                <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl"
                    data-rounded="rounded-xl" data-rounded-max="rounded-full">
                    <div class="p-3 text-white bg-blue-500 rounded-full" data-primary="blue-500"
                        data-rounded="rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18 8a3 3 0 0 1 0 6" />
                            <path d="M10 8v11a1 1 0 0 1 -1 1h-1a1 1 0 0 1 -1 -1v-5" />
                            <path
                                d="M12 8h0l4.524 -3.77a0.9 .9 0 0 1 1.476 .692v12.156a0.9 .9 0 0 1 -1.476 .692l-4.524 -3.77h-8a1 1 0 0 1 -1 -1v-4a1 1 0 0 1 1 -1h8" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-medium text-gray-700">Notifications</h4>
                    <p class="text-base text-center text-gray-500">Send out notifications to all your customers to keep
                        them engaged.</p>
                </div>
                <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl"
                    data-rounded="rounded-xl" data-rounded-max="rounded-full">
                    <div class="p-3 text-white bg-blue-500 rounded-full" data-primary="blue-500"
                        data-rounded="rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <polyline points="12 3 20 7.5 20 16.5 12 21 4 16.5 4 7.5 12 3" />
                            <line x1="12" y1="12" x2="20" y2="7.5" />
                            <line x1="12" y1="12" x2="12" y2="21" />
                            <line x1="12" y1="12" x2="4" y2="7.5" />
                            <line x1="16" y1="5.25" x2="8" y2="9.75" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-medium text-gray-700">Bundles</h4>
                    <p class="text-base text-center text-gray-500">High-quality bundles of awesome tools to help you out.
                    </p>
                </div>
                <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl"
                    data-rounded="rounded-xl" data-rounded-max="rounded-full">
                    <div class="p-3 text-white bg-blue-500 rounded-full" data-primary="blue-500"
                        data-rounded="rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 9l3 3l-3 3" />
                            <line x1="13" y1="15" x2="16" y2="15" />
                            <rect x="3" y="4" width="18" height="16" rx="2" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-medium text-gray-700">Developer Tools</h4>
                    <p class="text-base text-center text-gray-500">Developer tools to help grow your application and keep
                        it up-to-date.</p>
                </div>
                <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl"
                    data-rounded="rounded-xl" data-rounded-max="rounded-full">
                    <div class="p-3 text-white bg-blue-500 rounded-full" data-primary="blue-500"
                        data-rounded="rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="9.5" y1="11" x2="9.51" y2="11" />
                            <line x1="14.5" y1="11" x2="14.51" y2="11" />
                            <path d="M9.5 15a3.5 3.5 0 0 0 5 0" />
                            <path
                                d="M7 5h1v-2h8v2h1a3 3 0 0 1 3 3v9a3 3 0 0 1 -3 3v1h-10v-1a3 3 0 0 1 -3 -3v-9a3 3 0 0 1 3 -3" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-medium text-gray-700">Building Blocks</h4>
                    <p class="text-base text-center text-gray-500">The right kind of building blocks to take your company
                        to the next level.</p>
                </div>
                <div class="flex flex-col items-center justify-between col-span-4 px-8 py-12 space-y-4 bg-gray-100 sm:rounded-xl"
                    data-rounded="rounded-xl" data-rounded-max="rounded-full">
                    <div class="p-3 text-white bg-blue-500 rounded-full" data-primary="blue-500"
                        data-rounded="rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 " viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="15" y1="5" x2="15" y2="7" />
                            <line x1="15" y1="11" x2="15" y2="13" />
                            <line x1="15" y1="17" x2="15" y2="19" />
                            <path
                                d="M5 5h14a2 2 0 0 1 2 2v3a2 2 0 0 0 0 4v3a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-3a2 2 0 0 0 0 -4v-3a2 2 0 0 1 2 -2" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-medium text-gray-700">Coupons</h4>
                    <p class="text-base text-center text-gray-500">Coupons system to provide special offers and discounts
                        for your app.</p>
                </div>
            </div>
        </div>
    </section> --}}
    <section class="relative py-20 overflow-hidden bg-white">
        <span class="absolute top-0 right-0 flex flex-col items-end mt-0 -mr-16 opacity-60">
            <span
                class="container hidden w-screen h-32 max-w-xs mt-20 transform rounded-full rounded-r-none md:block md:max-w-xs lg:max-w-lg 2xl:max-w-3xl bg-blue-50"></span>
        </span><span class="absolute bottom-0 left-0"> </span>
        <div class="relative px-16 mx-auto max-w-7xl">
            <p class="font-medium tracking-wide text-blue-500 uppercase" id="contacts">OUR TEAM</p>
            <h2 class="relative max-w-lg mt-5 mb-10 text-4xl font-semibold leading-tight lg:text-5xl">An incredible team of
                <br>amazing individuals
            </h2>
            <div class="grid w-full grid-cols-2 gap-10 sm:grid-cols-3 lg:grid-cols-4">
                <div class="flex flex-col items-center justify-center col-span-1">
                    <div class="relative p-5">
                        <div class="absolute z-10 w-full h-full -mt-5 -ml-5 rounded-full rounded-tr-none bg-blue-50"></div>
                        <img class="relative z-20 w-full rounded-full" src="{{ URL::asset('/assets/enrico.png') }}" />
                    </div>
                    <div class="mt-3 space-y-2 text-center">
                        <div class="space-y-1 text-lg font-medium leading-6">
                            <h3>Enrico Adi</h3>
                            <p class="text-blue-600">220180499</p>
                        </div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center col-span-1">
                    <div class="relative p-5">
                        <div class="absolute z-10 w-full h-full -mt-5 -ml-5 rounded-full rounded-tr-none bg-green-50">
                        </div>
                        <img class="relative z-20 w-full rounded-full" src="{{ URL::asset('/assets/timothy.png') }}" />
                    </div>
                    <div class="mt-3 space-y-2 text-center">
                        <div class="space-y-1 text-lg font-medium leading-6">
                            <h3>Timothy Axel</h3>
                            <p class="text-blue-600">220180507</p>
                        </div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center col-span-1">
                    <div class="relative p-5">
                        <div class="absolute z-10 w-full h-full -mt-5 -ml-5 rounded-full rounded-tr-none bg-pink-50"></div>
                        <img class="relative z-20 w-full rounded-full" src="{{ URL::asset('/assets/jb.png') }}" />
                    </div>
                    <div class="mt-3 space-y-2 text-center">
                        <div class="space-y-1 text-lg font-medium leading-6">
                            <h3>Jonathan Bryan</h3>
                            <p class="text-blue-600">220180517</p>
                        </div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col items-center justify-center col-span-1">
                    <div class="relative p-5">
                        <div class="absolute z-10 w-full h-full -mt-5 -ml-5 rounded-full rounded-tr-none bg-green-50">
                        </div>
                        <img class="relative z-20 w-full rounded-full" src="{{ URL::asset('/assets/mk.jpg') }}" />
                    </div>
                    <div class="mt-3 space-y-2 text-center">
                        <div class="space-y-1 text-lg font-medium leading-6">
                            <h3>Michael Kevin</h3>
                            <p class="text-blue-600">220180521</p>
                        </div>
                        <div class="relative flex items-center justify-center space-x-3">
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                                </svg>
                            </a>
                            <a href="" class="text-gray-300 hover:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                                    <path
                                        d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- SIGN UP --}}
    {{-- <section class="w-full bg-white">
        <div class="mx-auto max-w-7xl">
            <div class="flex flex-col lg:flex-row">
                <div
                    class="relative w-full bg-cover lg:w-6/12 xl:w-7/12 bg-gradient-to-r from-white via-white to-gray-100">
                    <div
                        class="relative flex flex-col items-center justify-center w-full h-full px-10 my-20 lg:px-16 lg:my-0">
                        <div class="flex flex-col items-start space-y-8 tracking-tight lg:max-w-3xl">
                            <div class="relative">
                                <p class="mb-2 font-medium text-gray-700 uppercase">Work smarter</p>
                                <h2 class="text-5xl font-bold text-gray-900 xl:text-6xl">Features to help you work smarter
                                </h2>
                            </div>
                            <p class="text-2xl text-gray-700">We've created a simple formula to follow in order to gain
                                more out of your business and your application.</p>
                            <a href=""
                                class="inline-block px-8 py-5 text-xl font-medium text-center text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 ease"
                                data-primary="blue-600" data-rounded="rounded-lg">Get Started Today</a>
                        </div>
                    </div>
                </div>
                <div class="w-full bg-white lg:w-6/12 xl:w-5/12">
                    <div class="flex flex-col items-start justify-start w-full h-full p-10 lg:p-16 xl:p-24">
                        <h4 class="w-full text-3xl font-bold">Signup</h4>
                        <p class="text-lg text-gray-500">or, if you have an account you can <a href="{{ url('/login') }}"
                                class="text-blue-600 underline" data-primary="blue-600">sign in</a></p>
                        <div class="relative w-full mt-10 space-y-8">
                            <div class="relative">
                                <label class="font-medium text-gray-900">Name</label>
                                <input type="text"
                                    class="block w-full px-4 py-4 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                    data-primary="blue-600" data-rounded="rounded-lg" placeholder="Enter Your Name" />
                            </div>
                            <div class="relative">
                                <label class="font-medium text-gray-900">Email</label>
                                <input type="text"
                                    class="block w-full px-4 py-4 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                    data-primary="blue-600" data-rounded="rounded-lg"
                                    placeholder="Enter Your Email Address" />
                            </div>
                            <div class="relative">
                                <label class="font-medium text-gray-900">Password</label>
                                <input type="password"
                                    class="block w-full px-4 py-4 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                                    data-primary="blue-600" data-rounded="rounded-lg" placeholder="Password" />
                            </div>
                            <div class="relative">
                                <a href=""
                                    class="inline-block w-full px-5 py-4 text-lg font-medium text-center text-white transition duration-200 bg-blue-600 rounded-lg hover:bg-blue-700 ease"
                                    data-primary="blue-600" data-rounded="rounded-lg">Create Account</a>
                                <a href=""
                                    class="inline-block w-full px-5 py-4 mt-3 text-lg font-bold text-center text-gray-900 transition duration-200 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 ease"
                                    data-rounded="rounded-lg">Sign up with Google</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="w-full px-8 py-16 bg-gray-100 xl:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="flex flex-col items-center md:flex-row">
                <div class="w-full space-y-5 md:w-3/5 md:pr-16">
                    <p class="font-medium text-blue-500 uppercase" data-primary="blue-500">Building Businesses</p>
                    <h2 class="text-2xl font-extrabold leading-none text-black sm:text-3xl md:text-5xl">
                        Changing The Way People Do Business.</h2>
                    <p class="text-xl text-gray-600 md:pr-16">Learn how to engage with your visitors and teach them about
                        your mission. We're revolutionizing the way customers and businesses interact.</p>
                </div>
                <div class="w-full mt-16 md:mt-0 md:w-2/5">
                    <div class="relative z-10 h-auto p-8 py-10 overflow-hidden bg-white border-b-2 border-gray-300 rounded-lg shadow-2xl px-7"
                        data-rounded="rounded-lg" data-rounded-max="rounded-full">
                        <h3 class="mb-6 text-2xl font-medium text-center">Sign in to your Account</h3>
                        <input type="text" name="email" id="email"
                            class="block w-full px-4 py-3 mb-4 border border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none"
                            data-rounded="rounded-lg" data-primary="blue-500" placeholder="Email address">
                        <input type="password" name="password" id="password"
                            class="block w-full px-4 py-3 mb-4 border border-2 border-transparent border-gray-200 rounded-lg focus:ring focus:ring-blue-500 focus:outline-none"
                            data-rounded="rounded-lg" data-primary="blue-500" placeholder="Password">
                        <div class="block">
                            <button class="w-full px-3 py-4 font-medium text-white bg-blue-600 rounded-lg"
                                data-primary="blue-600" data-rounded="rounded-lg">Log Me In</button>
                        </div>
                        <p class="w-full mt-4 text-sm text-center text-gray-500">Don't have an account? <a href=""
                                class="text-blue-500 underline">Sign up here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <section class="py-20 bg-white">
        <div class="px-4 mx-auto text-center max-w-7xl sm:px-6 lg:px-8">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl xl:text-6xl">
                The New Standard for Design</h2>
            <p class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                Use our award-winning tools to help you maximize your profits. We've uncovered the correct recipe for
                converting visitors into customers.</p>
            <div class="flex justify-center mt-8 space-x-3">
                <a href="#"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow hover:bg-indigo-700"
                    data-primary="indigo-600" data-rounded="rounded-md">Sign Up Today</a>
                <a href="#"
                    class="inline-flex items-center justify-center px-5 py-3 text-base font-medium text-indigo-700 bg-indigo-100 border border-transparent rounded-md hover:bg-indigo-200"
                    data-primary="indigo-600" data-rounded="rounded-md">Learn more</a>
            </div>
        </div>
    </section> --}}
    <section class="flex items-center justify-center py-16 bg-gray-100 min-w-screen" id="testimonials">
        <div class="max-w-6xl px-12 mx-auto bg-gray-100 md:px-16 xl:px-10">
            <div class="flex flex-col items-center lg:flex-row">
                <div class="flex flex-col items-start justify-center w-full h-full pr-8 mb-10 lg:mb-0 lg:w-1/2">
                    <p class="mb-2 text-base font-medium tracking-tight text-indigo-500 uppercase"
                        data-primary="indigo-500">Our customers love our product</p>
                    <h2
                        class="text-4xl font-extrabold leading-10 tracking-tight text-gray-900 sm:text-5xl sm:leading-none md:text-6xl lg:text-5xl xl:text-6xl">
                        Testimonials</h2>
                    <p class="my-6 text-lg text-gray-600">Don't just take our word for it, read from our extensive list of
                        case studies and customer testimonials.</p>
                </div>
                <div class="w-full lg:w-1/2">
                    <blockquote class="flex items-center justify-between w-full col-span-1 p-6 bg-white rounded-lg shadow"
                        data-rounded="rounded-lg" data-rounded-max="rounded-full">
                        <div class="flex flex-col pr-8">
                            <div class="relative pl-12">
                                <svg class="absolute left-0 w-10 h-10 text-indigo-500 fill-current"
                                    data-primary="indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
                                    <path
                                        d="M30.7 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2C12.7 83.1 5 72.6 5 61.5c0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S30.7 31.6 30.7 42zM82.4 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2-11.8 0-19.5-10.5-19.5-21.6 0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S82.4 31.6 82.4 42z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600 sm:text-base lg:text-sm xl:text-base">
                                    Luar biasa!
                                    Waktu pengerjaan cepat dan hasilnya sangat sesuai.
                                </p>
                            </div>
                            <h3
                                class="pl-12 mt-3 text-sm font-medium leading-5 text-gray-800 truncate sm:text-base lg:text-sm lg:text-base">
                                Bill Gates
                            </h3>
                        </div>
                    </blockquote>
                    <blockquote
                        class="flex items-center justify-between w-full col-span-1 p-6 mt-4 bg-white rounded-lg shadow"
                        data-rounded="rounded-lg" data-rounded-max="rounded-full">
                        <div class="flex flex-col pr-10">
                            <div class="relative pl-12">
                                <svg class="absolute left-0 w-10 h-10 text-indigo-500 fill-current"
                                    data-primary="indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
                                    <path
                                        d="M30.7 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2C12.7 83.1 5 72.6 5 61.5c0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S30.7 31.6 30.7 42zM82.4 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2-11.8 0-19.5-10.5-19.5-21.6 0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S82.4 31.6 82.4 42z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600 sm:text-base lg:text-sm xl:text-base">
                                    Tempat ini merupakan tempat yang sangat cocok bagi semua orang yang memiliki berbagai
                                    keahlian dan ingin membuahkan sesuatu dari hal itu. Very recommended.
                                </p>
                            </div>
                            <h3
                                class="pl-12 mt-3 text-sm font-medium leading-5 text-gray-800 truncate sm:text-base lg:text-sm lg:text-base">
                                Alexander Kevin
                            </h3>
                        </div>
                    </blockquote>
                    <blockquote
                        class="flex items-center justify-between w-full col-span-1 p-6 mt-4 bg-white rounded-lg shadow"
                        data-rounded="rounded-lg" data-rounded-max="rounded-full">
                        <div class="flex flex-col pr-10">
                            <div class="relative pl-12">
                                <svg class="absolute left-0 w-10 h-10 text-indigo-500 fill-current"
                                    data-primary="indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 125">
                                    <path
                                        d="M30.7 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2C12.7 83.1 5 72.6 5 61.5c0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S30.7 31.6 30.7 42zM82.4 42c0 6.1 12.6 7 12.6 22 0 11-7.9 19.2-18.9 19.2-11.8 0-19.5-10.5-19.5-21.6 0-19.2 18-44.6 29.2-44.6 2.8 0 7.9 2 7.9 5.4S82.4 31.6 82.4 42z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600 sm:text-base lg:text-sm xl:text-base">
                                    Sangat banyak orang-orang yang memiliki talenta yang luar biasa disini. Hebat!
                                </p>
                            </div>
                            <h3
                                class="pl-12 mt-3 text-sm font-medium leading-5 text-gray-800 truncate sm:text-base lg:text-sm lg:text-base">
                                Raymond William
                            </h3>
                        </div>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
    <section class="relative py-16 bg-white min-w-screen animation-fade animation-delay">
        <div class="container px-0 px-8 mx-auto sm:px-12 xl:px-5">
            <p class="text-xs font-bold text-left text-pink-500 uppercase sm:mx-6 sm:text-center sm:text-normal sm:font-bold"
                data-primary="pink-500">
                Got a Question? We’ve got answers.</p>
            <h3 id="faq"
                class="mt-1 text-2xl font-bold text-left text-gray-800 sm:mx-6 sm:text-3xl md:text-4xl lg:text-5xl sm:text-center sm:mx-0">
                Frequently Asked Questions</h3>
            <div class="w-full px-6 py-6 mx-auto mt-10 bg-white border border-gray-200 rounded-lg sm:px-8 md:px-12 sm:py-8 sm:shadow lg:w-5/6 xl:w-2/3"
                data-rounded="rounded-lg" data-rounded-max="rounded-full">
                <h3 class="text-lg font-bold text-purple-500 sm:text-xl md:text-2xl" data-primary="purple-500">
                    Bagaimana cara kerja Beehive?
                </h3>
                <p class="mt-2 text-base text-gray-600 sm:text-lg md:text-normal">
                    Platform kami akan menyediakan berbagai freelancer yang terpercaya dan tentunya memiliki skill yang luar
                    biasa.
                    Anda hanya perlu memilih freelancer yang sesuai dengan keinginan Anda, buat kesepakatan,
                    selesai! Sangat simpel bukan.
                </p>
            </div>
            <div class="w-full px-6 py-6 mx-auto mt-10 bg-white border border-gray-200 rounded-lg sm:px-8 md:px-12 sm:py-8 sm:shadow lg:w-5/6 xl:w-2/3"
                data-rounded="rounded-lg" data-rounded-max="rounded-full">
                <h3 class="text-lg font-bold text-purple-500 sm:text-xl md:text-2xl" data-primary="purple-500">
                    Apa saja fitur yang disediakan?
                </h3>
                <p class="mt-2 text-base text-gray-600 sm:text-lg md:text-normal">
                    Terdapat banyak fitur di platform Beehive. Anda dapat menawarkan jasa, membeli jasa, bahkan Anda dapat melelang sting!</p>
            </div>
            <div class="w-full px-6 py-6 mx-auto mt-10 bg-white border border-gray-200 rounded-lg sm:px-8 md:px-12 sm:py-8 sm:shadow lg:w-5/6 xl:w-2/3"
                data-rounded="rounded-lg" data-rounded-max="rounded-full">
                <h3 class="text-lg font-bold text-purple-500 sm:text-xl md:text-2xl" data-primary="purple-500">Bagaimana apabila hasil sting yang didapat tidak sesuai harapan?</h3>
                <p class="mt-2 text-base text-gray-600 sm:text-lg md:text-normal">
                    Kami berharap hal tersebut tidak terjadi, namun apabila terjadi, Beehive menyediakan fitur revisi agar Anda dapat berdiskusi kembali mengenai sting Anda!
                </p>
            </div>
            {{-- Mungkin bisa ditambah lagi --}}
        </div>
    </section>
    <section class="bg-white">
        <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8">
            <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                <div class="px-5 py-2">
                    <a href="#" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        About
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Testimonial
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Team
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Pricing
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Contact
                    </a>
                </div>
                <div class="px-5 py-2">
                    <a href="#" class="text-base leading-6 text-gray-500 hover:text-gray-900">
                        Terms
                    </a>
                </div>
            </nav>
            <div class="flex justify-center mt-8 space-x-6">
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Facebook</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Instagram</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Twitter</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">GitHub</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Dribbble</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z"
                            clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
            <p class="mt-8 text-base leading-6 text-center text-gray-400">
                &copy; 2022 Beehive. All rights reserved.</p>
        </div>
    </section>
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
