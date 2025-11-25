@extends('layouts.user')

@section('title', __('messages.pricelist_title') . ' | anxietive')

@section('content')

<!-- HERO FULLSCREEN IMAGE -->
<section class="relative py-10 w-full h-screen flex items-center justify-center bg-white">
    <img src="{{ asset('images/logo/pricelist.png') }}" alt="{{ __('messages.pricelist_title') }}" class="max-h-full max-w-full object-contain">
</section>

<!-- EXTRA CONTENT (CTA) -->
<section class="py-10 bg-gray-50">
    <div class="container mx-auto px-6 text-center">
        <h3 class="text-2xl md:text-3xl font-bold">{{ __('messages.pricelist_cta_title') }}</h3>
        <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
            {{ __('messages.pricelist_cta_text') }}
        </p>
        <div class="mt-6">
            <a href="{{ route('booking') }}"
                class="inline-block px-8 py-3 bg-gray-900 text-white rounded-md text-base font-medium hover:bg-gray-700 transition">
                {{ __('messages.pricelist_cta_button') }}
            </a>
        </div>
    </div>
</section>

<!-- GALLERY: FULL WIDTH SWIPER -->
<section class="pt-10 bg-white">
    <div class="w-full">
        <!-- Swiper container -->
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                @foreach($gallery as $index => $item)
                <div class="swiper-slide gallery-item relative">
                    <!-- Gambar -->
                    <img src="{{ asset('images/pricelist/'.$item['file']) }}" alt="{{ $item['name'] }}"
                        class="w-full h-[520px] object-cover rounded-xl shadow-md cursor-pointer"
                        onclick="openModal('{{ asset('images/pricelist/'.$item['file']) }}', {{ $index }})">

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

<!-- MODAL VIEWER -->
<div id="imageModal"
    class="fixed inset-0 bg-white/95 hidden items-center justify-center z-50 backdrop-blur-sm transition-all duration-300">
    <button onclick="closeModal()"
        class="absolute top-6 right-8 text-gray-700 text-3xl hover:scale-110 hover:text-gray-500 transition z-[60]">✕</button>
    <button onclick="prevImage()"
        class="absolute left-3 md:left-10 text-gray-700 text-4xl hover:scale-125 hover:text-gray-500 select-none transition z-[60]">‹</button>
    <img id="modalImage" src="" alt="Preview"
        class="max-h-[80vh] max-w-[90vw] mx-auto rounded-lg shadow-2xl transition-all duration-300 bg-white p-2 relative z-[50]" />
    <button onclick="nextImage()"
        class="absolute right-3 md:right-10 text-gray-700 text-4xl hover:scale-125 hover:text-gray-500 select-none transition z-[60]">›</button>
</div>

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
        paint-order: stroke fill;
    }

    /* modal image layering fix */
    #imageModal button {
        z-index: 60;
    }

    #imageModal img {
        z-index: 50;
        position: relative;
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
            watchOverflow: true,
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

    // Modal logic
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImage');
    let currentIndex = 0;
    const galleryImages = @json(array_map(fn($item) => asset('images/pricelist/' . $item['file']), $gallery));

    function openModal(src, index) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modalImg.src = src;
        currentIndex = index;
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + galleryImages.length) % galleryImages.length;
        modalImg.src = galleryImages[currentIndex];
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % galleryImages.length;
        modalImg.src = galleryImages[currentIndex];
    }
</script>
@endpush