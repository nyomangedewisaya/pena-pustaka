@if (session('success') || session('error'))
    <div x-data="{ show: true }" 
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-x-10"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-10"
         class="fixed top-5 right-5 z-50 max-w-sm w-full bg-white/90 backdrop-blur-sm border-l-4 rounded-lg shadow-xl overflow-hidden {{ session('success') ? 'border-emerald-500' : 'border-rose-500' }}">
        
        <div class="p-4 flex items-start gap-4">
            <div class="shrink-0">
                @if(session('success'))
                    <div class="w-8 h-8 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center">
                        <i class="bi bi-check-lg text-lg"></i>
                    </div>
                @else
                    <div class="w-8 h-8 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center">
                        <i class="bi bi-exclamation-lg text-lg"></i>
                    </div>
                @endif
            </div>

            <div class="flex-1 pt-0.5">
                <h3 class="font-bold text-sm text-gray-900">
                    {{ session('success') ? 'Berhasil!' : 'Terjadi Kesalahan' }}
                </h3>
                <p class="mt-1 text-sm text-gray-600 leading-snug">
                    {{ session('success') ?? session('error') }}
                </p>
            </div>

            <button @click="show = false" class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <div class="h-1 w-full bg-gray-100">
            <div class="h-full {{ session('success') ? 'bg-emerald-500' : 'bg-rose-500' }}"
                 style="animation: progress 4s linear forwards;">
            </div>
        </div>
    </div>

    <style>
        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
    </style>
@endif