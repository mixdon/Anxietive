@extends('layouts.app')

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
<section class="text-center py-12 text-gray-600">
    <p class="max-w-xl mx-auto">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
    </p>
    <div class="mt-4 text-sm text-gray-500">
        Lorem ipsum | Lorem ipsum | Lorem ipsum
    </div>
</section>
@endsection
