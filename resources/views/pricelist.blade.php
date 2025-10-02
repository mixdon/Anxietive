@extends('layouts.app')

@section('title', 'Pricelist | anxietive')

@section('content')

<!-- HERO FULLSCREEN IMAGE -->
<section class="relative py-10 w-full h-screen flex items-center justify-center bg-white">
    <img src="{{ asset('images/logo/pricelist.png') }}" alt="Pricelist" class="max-h-full max-w-full object-contain">
</section>

<!-- EXTRA CONTENT (CTA) -->
<section class="py-10 bg-gray-50">
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
                <div class="swiper-slide gallery-item relative">
                    <!-- Gambar -->
                    <img src="{{ asset('images/pricelist/'.$item['file']) }}" alt="{{ $item['name'] }}"
                        class="w-full h-[520px] object-cover rounded-xl shadow-md cursor-pointer">

                    <!-- Overlay text -->
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <span class="text-white text-4xl md:text-5xl font-light tracking-wide">
                            {{ $item['name'] }}
                        </span>
                    </div>

                    <!-- Gradient overlay -->
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent rounded-xl pointer-events-none">
                    </div>
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
    .swiper-button-next,
    .swiper-button-prev {
        color: #111827;
    }

    .swiper-button-disabled {
        opacity: 0 !important;
        pointer-events: none !important;
    }

    /* teks overlay biar selalu terlihat jelas */
    .gallery-item span {
        text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
        -webkit-text-stroke: 0.5px black;
        /* border tipis */
        paint-order: stroke fill;
    }

</style>
@endpush

@push('scripts')
{{-- Swiper JS --}}
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.mySwiper', {
            slidesPerView: 1.1,
            spaceBetween: 12,
            loop: false,
            watchOverflow: true, // sembunyikan arrow kalau slide < jumlah view
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
                    slidesPerView: 3.2,
                    spaceBetween: 20,
                }
            }
        });
    });

</script>
@endpush
