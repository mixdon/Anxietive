@extends('layouts.user')

@section('title', 'Home | anxietive')

@section('content')
<!-- Gallery full width -->
<section class="w-full mt-12">
    <div class="grid gap-0" style="grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
        @foreach($images as $img)
        <div class="gallery-item aspect-square overflow-hidden cursor-pointer">
            <img src="{{ asset('images/home/'.$img) }}" alt="{{ pathinfo($img, PATHINFO_FILENAME) }}"
                class="w-full h-full object-cover" loading="lazy" />
        </div>
        @endforeach
    </div>
</section>

<!-- Middle description -->
<section class="text-center py-12">
  <p class="max-w-2xl mx-auto text-lg md:text-xl text-gray-700 leading-relaxed">
    <span class="font-semibold text-gray-900">
      Anxietive
    </span> is a self photo studio where every smile, pose, 
    and moment becomes a story worth keeping.
  </p>
  <div class="mt-6 text-xs md:text-sm text-gray-500 tracking-widest uppercase">
    Self Photo &nbsp;|&nbsp; Authentic Moments &nbsp;|&nbsp; Anxietive Studio
  </div>
</section>
@endsection
