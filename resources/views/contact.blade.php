@extends('layouts.app')

@section('title', 'Contact | anxietive')

@section('content')
<!--  HERO / INTRO  -->
<section class="max-w-3xl mx-auto px-6 py-12 text-center">
    <h1 class="mt-4 text-4xl md:text-6xl font-bold text-gray-900 mb-3">
        Contact Us
    </h1>
    <p class="text-gray-600 mb-6">
        Have questions, need assistance, or want to book your self photo session?  
        We’d love to hear from you! Reach out to us anytime and our team will be happy to help.  
    </p>
</section>

<!--  CONTACT INFO + FORM  -->
<section class="w-full">
    <div class="grid md:grid-cols-2 gap-0">
        <div>
            <img src="{{ asset('images/contact/contact001.jpg') }}" alt="Contact Image"
                class="w-full h-full object-cover">
        </div>

        <!-- Right: Info + Form -->
        <div class="bg-gray-100 p-10 flex flex-col justify-center">
            <!-- Contact Info -->
            <div class="mb-8 text-gray-700 text-sm md:text-base">
                <p class="mb-2">Jl. Cempedak I No.3, Pekanbaru, Riau.</p>
                <p>google.com <span class="mx-2 text-gray-400">|</span> 081364007605</p>
            </div>

            <!-- Contact Form -->
            <form action="#" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                        <input type="text" name="first_name" id="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                     focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                     focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                   focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                    <textarea name="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm 
                   focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                </div>

                <div class="text-right">
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow 
                   hover:bg-indigo-700">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!--  OPENING HOURS  -->
<section class="bg-gray-200 my-10 py-14">
    <div class="max-w-5xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-center items-start md:items-center gap-x-36">
            <!-- Left: Title -->
            <h2 class="text-4xl font-bold mb-6 md:mb-0 text-gray-900">Opening Hours</h2>

            <!-- Right: Hours -->
            <div class="space-y-2 text-gray-700 text-lg font-normal">
                <p class="flex items-center gap-6">
                    <span class="w-24">Mon</span>
                    <span class="text-red-600">Close</span>
                </p>
                <p class="flex items-center gap-6">
                    <span class="w-24">Tue - Sun</span>
                    <span>10.00 – 21.30</span>
                </p>
            </div>
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
