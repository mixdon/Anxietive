@extends('layouts.app')

@section('title', 'About | anxietive')

@section('content')

<!-- HERO -->
<section>
    <div class="container mx-auto max-w-3xl px-6 text-center py-16">
        <p class="text-sm tracking-widest text-gray-600 font-medium">
            The Full Story
        </p>
        <h1 class="mt-4 text-4xl md:text-6xl font-bold text-gray-900">
            About
        </h1>
        <p class="mt-6 text-gray-600 leading-relaxed">
            Anxietive is a self photo studio built on the belief that every moment no matter how ordinary can be turned into something creative and meaningful. 
            Inspired by the idea of transforming anxiety into art, we provide a space where you can be yourself and capture your truest expressions. 
        </p>
    </div>
</section>

<!-- SECTION 1: Image left, text right -->
<section class="relative border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-12 min-h-[40rem]">
        <!-- IMAGE -->
        <div class="col-span-12 md:col-span-6 relative order-1 md:order-1 h-64 md:h-full">
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                @if(isset($images[0]))
                <img src="{{ asset('images/about/'.$images[0]) }}" alt="{{ pathinfo($images[0], PATHINFO_FILENAME) }}"
                    class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gray-100"></div>
                @endif
            </div>
        </div>

        <!-- TEXT -->
        <div
            class="col-span-12 md:col-span-6 relative flex items-center justify-center py-12 md:py-0 order-2 md:order-2">
            <div class="text-center px-6 md:px-24 max-w-xl">
                <h2 class="text-3xl md:text-4xl font-bold">From Anxiety to Creative</h2>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    The name “Anxietive” comes from the idea of turning nervousness into creativity. 
                    We believe photography is more than just pictures it’s a way to embrace yourself, 
                    overcome insecurities, and celebrate your individuality.
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    In every session, we want you to feel comfortable, free, and empowered to express who you really are. 
                    That’s why our studio is designed for privacy, comfort, and authenticity.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 2: Text left, image right -->
<section class="relative border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-12 min-h-[40rem]">
        <!-- TEXT -->
        <div
            class="col-span-12 md:col-span-6 relative flex items-center justify-center py-12 md:py-0 order-2 md:order-1 z-10">
            <div class="text-center px-6 md:px-24 max-w-xl">
                <h2 class="text-3xl md:text-4xl font-bold">A Space for Your True Self</h2>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    Whether you’re here to create memories with friends, celebrate a milestone, 
                    or simply enjoy a moment of self-expression, Anxietive is here for you. 
                    Every corner of our studio is crafted to inspire creativity and authenticity. 
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    This is not just about photos it’s about capturing the story of who you are today, 
                    so you can look back and remember the confidence, laughter, and creativity you felt in that moment.
                </p>
            </div>
        </div>

        <!-- IMAGE -->
        <div class="col-span-12 md:col-span-6 relative order-1 md:order-2 h-64 md:h-full">
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                @if(isset($images[1]))
                <img src="{{ asset('images/about/'.$images[1]) }}" alt="{{ pathinfo($images[1], PATHINFO_FILENAME) }}"
                    class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gray-100"></div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection