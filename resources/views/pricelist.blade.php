@extends('layouts.app')

@section('title', 'Pricelist | anxietive')

@section('content')

<!-- HERO FULLSCREEN IMAGE -->
<section class="relative w-full h-screen flex items-center justify-center bg-white">
    <img src="{{ asset('images/logo/pricelist.png') }}" 
         alt="Pricelist" 
         class="max-h-full max-w-full object-contain">
</section>

<!-- EXTRA CONTENT (CTA) -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6 text-center">
        <h3 class="text-2xl md:text-3xl font-bold">Ready to Capture Your Best Moments?</h3>
        <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
            Book your self–portrait session today and create timeless memories with anxietive. 
            Choose your background, strike your pose, and let us handle the rest!
        </p>
        <div class="mt-6">
            <a href="{{ route('booking') }}"
               class="inline-block px-8 py-3 bg-gray-900 text-white rounded-md text-base font-medium hover:bg-gray-700 transition">
               Book Now
            </a>
        </div>
    </div>
</section>

<!-- GALLERY: FULL WIDTH SWIPER (3 visible + peek 4th) -->
<section class="pt-10 bg-white">
    <h2 class="text-3xl md:text-4xl font-bold text-center mb-10">Background Selection</h2>

    <div class="w-full">
        <!-- Swiper container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($gallery as $item)
                    <div class="swiper-slide gallery-item">
                        <img 
                            src="{{ asset('images/pricelist/'.$item['file']) }}" 
                            data-full="{{ asset('images/pricelist/'.$item['file']) }}"
                            alt="{{ $item['name'] }}"
                            class="w-full h-[520px] object-cover rounded-xl shadow-md cursor-pointer">
                    </div>
                @endforeach
            </div>

            <!-- Arrows -->
            <div class="swiper-button-prev !text-black"></div>
            <div class="swiper-button-next !text-black"></div>
        </div>
    </div>
</section>

@endsection

@push('styles')
    {{-- Swiper CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <style>
        .swiper-button-next, .swiper-button-prev {
            color: #111827; /* abu tua, biar kelihatan di background putih */
        }
    </style>
@endpush

@push('scripts')
    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const swiper = new Swiper('.mySwiper', {
                slidesPerView: 1.1, // mobile: 1 penuh + peek
                spaceBetween: 12,   // jarak antar gambar (atur di sini)
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2.1,
                        spaceBetween: 14,
                    },
                    768: {
                        slidesPerView: 3.2, // desktop: 3 penuh + peek ke-4
                        spaceBetween: 20,
                    }
                }
            });
        });
    </script>
@endpush