@extends('layouts.user')

@section('title', __('messages.about_title') . ' | anxietive')

@section('content')

<!-- HERO -->
<section>
    <div class="container mx-auto max-w-3xl px-6 text-center py-16">
        <p class="text-sm tracking-widest text-gray-600 font-medium">
            {{ __('messages.about_full_story') }}
        </p>
        <h1 class="mt-4 text-4xl md:text-6xl font-bold text-gray-900">
            {{ __('messages.about_title') }}
        </h1>
        <p class="mt-6 text-gray-600 leading-relaxed">
            {{ __('messages.about_intro') }}
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
                <img src="{{ asset('images/about/'.$images[0]) }}" 
                     alt="{{ pathinfo($images[0], PATHINFO_FILENAME) }}"
                     class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gray-100"></div>
                @endif
            </div>
        </div>

        <!-- TEXT -->
        <div class="col-span-12 md:col-span-6 relative flex items-center justify-center py-12 md:py-0 order-2 md:order-2">
            <div class="text-center px-6 md:px-24 max-w-xl">
                <h2 class="text-3xl md:text-4xl font-bold">
                    {{ __('messages.about_section1_title') }}
                </h2>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    {{ __('messages.about_section1_text1') }}
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    {{ __('messages.about_section1_text2') }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SECTION 2: Text left, image right -->
<section class="relative border-t border-gray-200">
    <div class="grid grid-cols-1 md:grid-cols-12 min-h-[40rem]">
        <!-- TEXT -->
        <div class="col-span-12 md:col-span-6 relative flex items-center justify-center py-12 md:py-0 order-2 md:order-1 z-10">
            <div class="text-center px-6 md:px-24 max-w-xl">
                <h2 class="text-3xl md:text-4xl font-bold">
                    {{ __('messages.about_section2_title') }}
                </h2>
                <p class="mt-6 text-gray-600 leading-relaxed">
                    {{ __('messages.about_section2_text1') }}
                </p>
                <p class="mt-4 text-gray-600 leading-relaxed">
                    {{ __('messages.about_section2_text2') }}
                </p>
            </div>
        </div>

        <!-- IMAGE -->
        <div class="col-span-12 md:col-span-6 relative order-1 md:order-2 h-64 md:h-full">
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                @if(isset($images[1]))
                <img src="{{ asset('images/about/'.$images[1]) }}" 
                     alt="{{ pathinfo($images[1], PATHINFO_FILENAME) }}"
                     class="w-full h-full object-cover">
                @else
                <div class="w-full h-full bg-gray-100"></div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection