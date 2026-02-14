<div class="flex flex-col md:flex-row md:items-center justify-between w-full mb-5 pb-5 border-b border-gray-200 gap-4">
    <div class="flex items-center gap-4">
        <div
            class="flex items-center justify-center w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl border border-blue-100 shrink-0">
            <i class="bi {{ $icon }} text-xl"></i>
        </div>
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-xl font-bold text-gray-900 leading-none">{{ $title }}</h2>
                <span
                    class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-xs font-bold border border-blue-100">
                    {{ $countData }}
                </span>
            </div>
            <p class="text-xs font-medium text-gray-500 mt-1">
                {{ $caption }}
            </p>
        </div>
    </div>
    <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
        <a href="{{ $link }}"
            class="font-medium text-base text-white bg-linear-to-r from-blue-700 border border-blue-700 to-blue-600 rounded-lg shadow-lg shadow-blue-500/30 w-full px-4 py-2 hover:scale-[1.01] active:scale-95 duration-300 flex items-center gap-2">
            <i class="bi bi-plus text-2xl -mb-1"></i>
            {{ $createLink }}
        </a>
    </div>
</div>
