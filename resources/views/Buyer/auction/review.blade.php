@extends('Buyer.layout.masterapp')
@section('title', 'Auction Review Farmer Beehive')

@section('content')
    {{-- Enrico --}}
    <div class="flex justify-center h-screen">
        <div class="mt-8">
            <form action="" method="post">
                @csrf
                <div class="block px-6 pb-6 rounded-lg shadow-lg bg-secondary max-w-md mt-4 w-96">
                    <div class="text-lg font-bold text-center mb-6 text-whiteColor"><br> Rate and Review Auction!</div>
                    <div class="flex">
                        <h3 class="text-xl">Input Rating</h3>
                        <div class="rating rating-xl ml-4 gap-x-2">
                            <input type="radio" name="rating" value="1" class="mask mask-star-2 bg-success  checked:bg-primary  " />
                            <input type="radio" name="rating" value="2" class="mask mask-star-2 bg-success  checked:bg-primary  " />
                            <input type="radio" name="rating" value="3" class="mask mask-star-2 bg-success checked:bg-primary  " />
                            <input type="radio" name="rating" value="4" class="mask mask-star-2 bg-success checked:bg-primary  " />
                            <input type="radio" name="rating" value="5" class="mask mask-star-2 bg-success checked:bg-primary  " checked />
                        </div>

                        @error('rating')
                            <label class="label">
                                <span class="label-text-alt text-red-500 text-lg">{{ $message }}</span>
                            </label>
                        @enderror
                    </div> <br>
                    <div class="">
                        <textarea name="review"
                            class="block w-full px-4 py-2 mt-2 text-xl placeholder-gray-400 bg-gray-200 rounded-lg focus:outline-none focus:ring-4 focus:ring-blue-600 focus:ring-opacity-50"
                            id="review" cols="30" rows="5" placeholder="Review About Beeworker Performance" required></textarea>
                    </div> <br>
                    <button
                        class="inline-block w-full btn btn-success"  data-rounded="rounded-lg">
                        Submit!
                    </button>
                    <div class="mt-3 text-center">Pastikan anda memberikan rating dan review dengan jujur</div>
                </div>
            </form>
            <a class="inline-block w-full px-5 py-2 text-lg font-medium text-center text-white transition duration-200 bg-red-500 rounded-lg hover:bg-error ease mt-3"
                data-rounded="rounded-lg" href="{{ url("buyer/auction/detail/$id") }}">
                Back
            </a>
        </div>
    </div>
@endsection
