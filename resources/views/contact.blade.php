@extends('layouts.user')

@section('title', __('messages.contact_title') . ' | anxietive')

@section('content')

<!-- HERO -->
<section class="max-w-3xl mx-auto px-6 py-12 text-center">
    <h1 class="mt-4 text-4xl md:text-6xl font-bold text-gray-900 mb-3">
        {{ __('messages.contact_title') }}
    </h1>
    <p class="text-gray-600 mb-6 text-base md:text-lg">
        {{ __('messages.contact_description') }}
    </p>
</section>

<!-- FOTO + FORM -->
<section class="w-full">
    <div class="grid md:grid-cols-[3fr_2fr] gap-0">

        <!-- LEFT: FOTO FULL -->
        <div class="bg-white">
            <img src="{{ asset('images/contact/contact001.png') }}" alt="Contact Image"
                class="w-full h-full object-cover md:object-contain">
        </div>

        <!-- RIGHT: FORM -->
        <div class="bg-gray-50 flex flex-col justify-center text-gray-700 p-10 h-auto">

            <!-- Contact Info -->
            <div class="pb-4">
                <h3 class="text-xl font-semibold text-gray-900 tracking-wide mb-1">
                    ANXIETIVE SELF PHOTO
                </h3>

                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ __('messages.contact_address') }}
                </p>

                <p class="text-gray-600 text-sm mt-1">
                    {{ __('messages.contact_google') }}
                    <span class="mx-2 text-gray-400">|</span>
                    {{ __('messages.contact_phone') }}
                </p>
            </div>

            <!-- Form -->
            <form action="#" method="POST" class="space-y-4">
                @csrf

                <!-- ROW 1 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            {{ __('messages.contact_first_name') }}
                        </label>
                        <input type="text" name="first_name" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                   focus:border-indigo-500 focus:ring-indigo-200 transition">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            {{ __('messages.contact_last_name') }}
                        </label>
                        <input type="text" name="last_name" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                                   focus:border-indigo-500 focus:ring-indigo-200 transition">
                    </div>
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        {{ __('messages.contact_email') }}
                    </label>
                    <input type="email" name="email" required class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                               focus:border-indigo-500 focus:ring-indigo-200 transition">
                </div>

                <!-- MESSAGE -->
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">
                        {{ __('messages.contact_message') }}
                    </label>
                    <textarea name="message" rows="3" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                               focus:border-indigo-500 focus:ring-indigo-200 transition resize-none"></textarea>
                </div>

                <!-- BUTTON -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium shadow
                               hover:bg-indigo-700 transition">
                        {{ __('messages.contact_send') }}
                    </button>
                </div>

            </form>
        </div>

    </div>
</section>

<!-- OPENING HOURS -->
<section class="bg-gray-200 my-10 py-14">
    <div class="max-w-5xl mx-auto px-6 flex flex-col md:flex-row justify-center items-start md:items-center gap-x-36">
        <h2 class="text-4xl font-bold mb-6 md:mb-0 text-gray-900">
            {{ __('messages.opening_hours') }}
        </h2>

        <div class="space-y-2 text-gray-700 text-lg font-normal">
            <p class="flex items-center gap-6">
                <span class="w-24">{{ __('messages.opening_mon') }}</span>
                <span class="text-red-600">{{ __('messages.opening_close') }}</span>
            </p>
            <p class="flex items-center gap-6">
                <span class="w-24">{{ __('messages.opening_tuesun') }}</span>
                <span>{{ __('messages.opening_time') }}</span>
            </p>
        </div>
    </div>
</section>


<!-- 3 LOKASI -->
<section class="py-12 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold mb-8 text-gray-900 text-center">Pilih Lokasi Studio</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <!-- BASE -->
            <div onclick="setMap('base')" id="card-base"
                class="location-card bg-white p-5 rounded-lg shadow hover:shadow-md transition cursor-pointer border-2 border-transparent">
                <h3 class="text-xl font-semibold mb-2">Anxietive – Base</h3>
                <p class="text-gray-600 text-sm">Cabang utama Pekanbaru.</p>
            </div>

            <!-- DELIMA -->
            <div onclick="setMap('delima')" id="card-delima"
                class="location-card bg-white p-5 rounded-lg shadow hover:shadow-md transition cursor-pointer border-2 border-transparent">
                <h3 class="text-xl font-semibold mb-2">Anxietive – Delima</h3>
                <p class="text-gray-600 text-sm">Cabang Delima Pekanbaru.</p>
            </div>

            <!-- LAMPUNG -->
            <div onclick="setMap('lampung')" id="card-lampung"
                class="location-card bg-white p-5 rounded-lg shadow hover:shadow-md transition cursor-pointer border-2 border-transparent">
                <h3 class="text-xl font-semibold mb-2">Anxietive – Lampung</h3>
                <p class="text-gray-600 text-sm">Cabang Lampung.</p>
            </div>

        </div>
    </div>
</section>

<!-- GOOGLE MAPS (HANYA SATU IFRAME) -->
<section class="w-full h-96 mb-10">
    <iframe id="mainMap"
        src="https://www.google.com/maps?q=0.5071390678140608,101.44939236591618&hl=id&z=17&output=embed"
        width="100%" height="100%"
        style="border:0; filter: grayscale(60%) brightness(97%) contrast(92%); border-radius: 10px;"
        allowfullscreen="" loading="lazy">
    </iframe>
</section>

<!-- SCRIPT -->
<script>
    const maps = {
        base: "https://www.google.com/maps?q=0.5071390678140608,101.44939236591618&hl=id&z=17&output=embed",
        delima: "https://www.google.com/maps?q=0.4676960836740406,101.40430828125844&hl=id&z=17&output=embed",
        lampung: "https://www.google.com/maps?q=-5.420314073050791,105.26432076966127&hl=id&z=17&output=embed"
    };

    function setMap(loc) {
        document.getElementById("mainMap").src = maps[loc];

        document.querySelectorAll('.location-card')
            .forEach(card => card.classList.remove('border-indigo-500', 'bg-indigo-50'));

        document.getElementById(`card-${loc}`).classList.add('border-indigo-500', 'bg-indigo-50');

        document.getElementById(`card-${loc}`).scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    window.onload = () => setMap('base');
</script>
@endsection