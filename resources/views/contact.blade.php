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

        <!-- RIGHT: FORM MENGIKUTI TINGGI FOTO -->
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

<!-- GOOGLE MAPS -->
<section class="w-full h-96">
    <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1992.234567!2d101.4468282!3d0.5069245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5afb17dc67f4f%3A0x875d8291f3d68d9c!2sANXIETIVE%20SELF%20PHOTO%20PEKANBARU!5e0!3m2!1sid!2sid!4v169xxx"
        width="100%" height="100%" style="border:0; filter: grayscale(60%) brightness(97%) contrast(92%);"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>

@endsection
