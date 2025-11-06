@extends('layouts.user')

@section('title', __('messages.home') . ' | anxietive')

@section('content')
<!-- Gallery -->
<section class="w-full mt-12">
  <div class="grid gap-0" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
    @foreach($images as $index => $img)
    <div class="group relative aspect-square overflow-hidden cursor-pointer">
      <img src="{{ asset('images/home/'.$img) }}"
           alt="{{ pathinfo($img, PATHINFO_FILENAME) }}"
           class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-105"
           onclick="openModal({{ $index }})" />
    </div>
    @endforeach
  </div>
</section>

<!-- Middle description -->
<section class="text-center py-12">
  <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-700 leading-relaxed">
    <span class="font-semibold text-gray-900">Anxietive</span> {{ __('messages.home_description') }}
  </p>
  <div class="mt-6 text-xs md:text-sm text-gray-500 tracking-widest uppercase">
    {{ __('messages.home_keywords') }}
  </div>
</section>

<!-- Modal Viewer -->
<div id="imageModal"
  class="fixed inset-0 bg-white/95 hidden items-center justify-center z-50 backdrop-blur-sm">
  <button onclick="closeModal()"
    class="absolute top-6 right-8 text-gray-700 text-3xl hover:text-gray-500">✕</button>
  <button onclick="prevImage()"
    class="absolute left-4 md:left-10 text-gray-700 text-3xl hover:text-gray-500 select-none">‹</button>
  <img id="modalImage" src="" alt="Preview"
    class="max-h-[80vh] max-w-[90vw] mx-auto rounded-lg shadow-2xl transition-all duration-300 bg-white p-2" />
  <button onclick="nextImage()"
    class="absolute right-4 md:right-10 text-gray-700 text-3xl hover:text-gray-500 select-none">›</button>
</div>
@endsection

@push('scripts')
<script>
  const images = @json(array_map(fn($img) => asset('images/home/'.$img), $images));
  
  let currentIndex = 0;
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage');

  function openModal(index) {
    currentIndex = index;
    modalImg.src = images[currentIndex];
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = 'auto';
  }

  function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    modalImg.src = images[currentIndex];
  }

  function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    modalImg.src = images[currentIndex];
  }

  modal.addEventListener('click', (e) => {
    if (e.target === modal) closeModal();
  });

  document.addEventListener('keydown', (e) => {
    if (modal.classList.contains('hidden')) return;
    if (e.key === 'ArrowRight') nextImage();
    if (e.key === 'ArrowLeft') prevImage();
    if (e.key === 'Escape') closeModal();
  });
</script>
@endpush