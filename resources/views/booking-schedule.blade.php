@extends('layouts.app')

@section('title', 'Booking Schedule | anxietive')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-6">
    <!-- Back Button -->
    <a href="{{ route('booking') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
        &larr; Back
    </a>

    <h1 class="text-3xl md:text-4xl font-bold text-center mt-6">Schedule your service</h1>
    <p class="text-center text-gray-500 mt-2">
        Check our availability and book the date and time that works for you
    </p>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-10">
        <!-- Kalender -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-800 mb-4">Select a Date</h3>
                <div class="flex items-center justify-between mb-2 text-gray-600">
                    <button id="prevMonth" class="p-2">&larr;</button>
                    <div id="monthLabel" class="text-sm font-medium"></div>
                    <button id="nextMonth" class="p-2">&rarr;</button>
                </div>

                <div class="grid grid-cols-7 text-center text-xs text-gray-500 mb-2">
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                </div>

                <div id="calendar" class="grid grid-cols-7 gap-2 text-center text-sm"></div>
            </div>
        </div>

        <!-- Waktu -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-800 mb-4">Availability</h3>
                <p id="selectedDateText" class="text-sm text-gray-600 mb-4">
                    Select a date to view times
                </p>

                <div id="timesGrid" class="grid grid-cols-2 gap-3"></div>
            </div>
        </div>

        <!-- Detail Service -->
        <div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="font-semibold text-gray-800 mb-3">Service Details</h3>
                <p class="text-gray-800 font-medium">{{ $selected['location'] }}</p>
                <p class="text-sm text-gray-500 mt-2">{{ $selected['address'] }}</p>
                <p class="text-sm text-gray-500 mt-2">Duration: {{ $selected['duration'] }}</p>
                @if(!empty($selected['detail_duration']))
                <ul class="list-disc ml-5 mt-3 text-sm text-gray-600 space-y-1">
                    @foreach($selected['detail_duration'] as $item)
                    <li>{{ $item }}</li>
                    @endforeach
                </ul>
                @endif
                <p class="text-lg font-semibold mt-2">Rp {{ number_format($selected['price'],0,',','.') }}</p>

                <p id="summaryDateTime" class="text-sm text-gray-500 mt-2">
                    No date/time selected
                </p>

                <button id="toForm"
                    class="w-full mt-6 inline-block px-8 py-3 bg-gray-800 text-white rounded-md text-base font-medium transition disabled:opacity-50"
                    disabled>
                    Next
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const selectedStudio = @json($selected['id']);
        const config = @json($config);

        const calendarEl = document.getElementById('calendar');
        const monthLabel = document.getElementById('monthLabel');
        const prevMonth = document.getElementById('prevMonth');
        const nextMonth = document.getElementById('nextMonth');
        const selectedDateText = document.getElementById('selectedDateText');
        const timesGrid = document.getElementById('timesGrid');
        const toFormBtn = document.getElementById('toForm');
        const summaryDateTime = document.getElementById('summaryDateTime');

        let current = new Date();
        let selectedDate = null;
        let selectedTime = null;

        function pad(n) {
            return n.toString().padStart(2, '0');
        }

        function timeToMinutes(t) {
            const [hh, mm] = t.split(':').map(Number);
            return hh * 60 + mm;
        }

        function minutesToTime(m) {
            const hh = Math.floor(m / 60);
            const mm = m % 60;
            return pad(hh) + ':' + pad(mm);
        }

        function generateTimeSlotsForDay() {
            timesGrid.innerHTML = '';
            if (!selectedDate) return;

            const dayOfWeek = selectedDate.getDay();
            if (config.closed_days.includes(dayOfWeek)) {
                selectedDateText.textContent = selectedDate.toLocaleDateString(undefined, {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) + ' — Closed';
                const el = document.createElement('div');
                el.className = 'text-sm text-red-500';
                el.textContent = 'Closed on this day';
                timesGrid.appendChild(el);
                checkToForm();
                return;
            }

            const openMin = timeToMinutes(config.open);
            const closeMin = timeToMinutes(config.close);
            const slot = parseInt(config.slot_minutes);
            const lastStart = closeMin - slot;

            // Cek apakah tanggal yang dipilih = hari ini
            const now = new Date();
            const isToday = selectedDate.toDateString() === now.toDateString();
            const nowMin = now.getHours() * 60 + now.getMinutes();

            for (let t = openMin; t <= lastStart; t += slot) {
                // Skip slot yang sudah lewat kalau hari ini
                if (isToday && t <= nowMin) continue;

                const ts = minutesToTime(t);
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'py-2 border rounded-md text-sm hover:bg-gray-100';
                btn.textContent = ts;
                btn.dataset.time = ts;

                btn.addEventListener('click', function () {
                    Array.from(timesGrid.querySelectorAll('button')).forEach(b => b.classList.remove(
                        'bg-green-500', 'text-white'));
                    this.classList.add('bg-green-500', 'text-white');
                    selectedTime = this.dataset.time;
                    summaryDateTime.textContent = selectedDate.toLocaleDateString(undefined, {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    }) + ' at ' + selectedTime;
                    checkToForm();
                });

                timesGrid.appendChild(btn);
            }

            if (timesGrid.innerHTML === '') {
                const el = document.createElement('div');
                el.className = 'text-sm text-red-500';
                el.textContent = 'No available slots for today';
                timesGrid.appendChild(el);
            }
        }

        function checkToForm() {
            toFormBtn.disabled = !(selectedDate && selectedTime);
            if (toFormBtn.disabled) {
                toFormBtn.classList.add('opacity-50');
            } else {
                toFormBtn.classList.remove('opacity-50');
            }
        }

        function renderCalendar(date) {
            calendarEl.innerHTML = '';
            const year = date.getFullYear(),
                month = date.getMonth();
            monthLabel.textContent = date.toLocaleString(undefined, {
                month: 'long',
                year: 'numeric'
            });
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startDay = firstDay.getDay(),
                daysInMonth = lastDay.getDate();

            for (let i = 0; i < startDay; i++) {
                calendarEl.appendChild(document.createElement('div'));
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = d;
                btn.className = 'py-2 rounded-md';
                const thisDate = new Date(year, month, d);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (thisDate < today) {
                    btn.classList.add('text-gray-300');
                    btn.disabled = true;
                } else {
                    btn.classList.add('hover:bg-green-100', 'cursor-pointer');
                    btn.addEventListener('click', function () {
                        selectedDate = thisDate;
                        selectedTime = null;
                        Array.from(calendarEl.querySelectorAll('button')).forEach(b => b.classList.remove(
                            'bg-green-500', 'text-white', 'px-3', 'rounded-full'));
                        this.classList.add('bg-green-500', 'text-white', 'px-3', 'rounded-full');
                        selectedDateText.textContent = thisDate.toLocaleDateString(undefined, {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        });
                        generateTimeSlotsForDay();
                    });
                }
                calendarEl.appendChild(btn);
            }
        }

        prevMonth.addEventListener('click', () => {
            current.setMonth(current.getMonth() - 1);
            renderCalendar(current);
        });
        nextMonth.addEventListener('click', () => {
            current.setMonth(current.getMonth() + 1);
            renderCalendar(current);
        });

        toFormBtn.addEventListener('click', function () {
            if (!selectedDate || !selectedTime) return;
            const dateParam = selectedDate.toISOString().slice(0, 10);
            const url = new URL("{{ route('booking.form', [], false) }}", window.location.origin);
            url.searchParams.set('studio', selectedStudio);
            url.searchParams.set('date', dateParam);
            url.searchParams.set('time', selectedTime);
            window.location.href = url.toString();
        });

        renderCalendar(current);
        checkToForm();
    })();

</script>
@endsection
