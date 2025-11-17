@extends('layouts.user')

@section('title', __('messages.home') . ' | anxietive')

@section('content')

<!-- HERO -->
<section class="relative w-full">

    <!-- DESKTOP HERO -->
    <img 
        src="{{ asset('images/home/home001.png') }}" 
        alt="Anxietive Hero" 
        class="w-full hidden md:block object-cover"
    >

    <!-- MOBILE HERO -->
    <div class="relative md:hidden h-screen w-full overflow-hidden">

        <img 
            src="{{ asset('images/home/home002.jpg') }}" 
            alt="Anxietive Mobile Hero"
            class="absolute inset-0 w-full h-full object-cover"
        >

        <img 
            src="{{ asset('images/logo/anxietive_logo.PNG') }}" 
            class="absolute top-6 right-6 w-20 opacity-95 z-20"
        >

        <div class="absolute inset-0 flex items-center justify-center px-6 z-20">
            <p class="text-white text-2xl font-semibold text-center drop-shadow-xl leading-relaxed">
                {{ __('messages.home_mobile_text') }}
            </p>
        </div>

    </div>

</section>

<!-- CTA -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-6 text-center max-w-2xl">

        <h3 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4">
            {{ __('messages.home_cta_title') }}
        </h3>

        <p class="text-gray-600 mb-8">
            {{ __('messages.home_cta_text') }}
        </p>

        <a 
            href="{{ route('booking') }}"
            class="inline-block px-10 py-3.5 bg-gray-900 text-white rounded-lg text-lg font-medium
                   shadow-lg hover:shadow-xl hover:bg-gray-800 active:scale-95 transition-all duration-200"
        >
            {{ __('messages.home_cta_button') }}
        </a>

    </div>
</section>

<!-- DESCRIPTION -->
<section class="text-center py-12 px-6 md:px-0">

    <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-700 leading-relaxed px-1">
        <span class="font-semibold text-gray-900">Anxietive</span>
        {{ __('messages.home_description') }}
    </p>

    <div 
        class="mt-6 text-[10px] md:text-sm text-gray-500 tracking-widest uppercase
               text-center px-4 whitespace-nowrap"
    >
        {{ __('messages.home_keywords') }}
    </div>

</section>

@endsection