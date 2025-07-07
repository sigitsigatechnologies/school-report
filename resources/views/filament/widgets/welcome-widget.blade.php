<x-filament::widget>
    <x-filament::card class="w-full bg-gradient-to-r from-yellow-300 via-pink-300 via-purple-300 via-blue-300 to-green-300 shadow-xl rounded-xl p-6 text-gray-800">
        <div class="flex items-center gap-4">
            {{-- Logo --}}
            <img src="{{ asset('images/logo_bopkri.png') }}" alt="Logo" class="h-10 w-10 rounded-full border border-white shadow">

            <div>
                <h2 class="text-xl font-bold text-gray-900 drop-shadow">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h2>
                <p class="text-sm font-semibold">
                    Anda masuk sebagai <span class="underline">{{ auth()->user()->getRoleNames()->first() ?? 'Pengguna' }}</span>
                </p>
                <p class="text-xs mt-1">
                    Sistem Rapor Projek P5 SD BOPKRI Turen - Bantul Yogyakarta
                </p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
