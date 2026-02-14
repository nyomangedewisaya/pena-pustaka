@php
    $listLink = [
        ['title' => 'Dashboard', 'icon' => 'bi-grid', 'link' => 'dashboard'],
        ['title' => 'Kelola Kategori', 'icon' => 'bi-collection', 'link' => 'categories'],
        ['title' => 'Kelola Buku', 'icon' => 'bi-book', 'link' => 'books'],
        ['title' => 'Kelola Anggota', 'icon' => 'bi-person', 'link' => 'users'],
        ['title' => 'Kelola Transaksi', 'icon' => 'bi-arrow-left-right', 'link' => 'transactions'],
    ];
@endphp

<div
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 
           transition-transform duration-300 ease-in-out
           flex flex-col justify-between shadow-xl md:shadow-none
           md:h-screen"> 
    
    <div>
        <div class="flex items-center justify-center px-6 mt-5 border-b pb-3 border-gray-200 md:mt-3">
            <div class="flex items-center gap-2">
                <img src="{{ asset('assets/images/logo.png') }}" class="w-10 md:w-16 md:-ml-5 md:-mr-1" alt="">
                <div class="flex flex-col -space-y-1">
                    <h2 class="text-lg md:text-xl font-semibold text-blue-600">Pena Pustaka</h2>
                    <p class="text-sm md:text-xs text-gray-500">Platform perpus digital</p>
                </div>
            </div>
            
            <button @click="sidebarOpen = false" class="md:hidden text-gray-500 hover:text-red-500">
                <i class="bi bi-x-lg text-xl"></i>
            </button>
        </div>

        <div class="p-5">
            <div class="menu flex flex-col space-y-2">
                @foreach ($listLink as $item)
                    <a href="{{ url($item['link']) }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-2.5 duration-300
                       cursor-pointer active:scale-95
                       {{ request()->routeIs($item['link'] . '*')
                           ? 'text-white bg-linear-to-r from-blue-500 to-blue-600 shadow-md shadow-blue-500/30'
                           : 'text-gray-600 hover:bg-gray-50 hover:text-blue-600' }}">
                        <i class="bi {{ $item['icon'] }}"></i>
                        <p>{{ $item['title'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="pb-5">
        <div class="border-t border-gray-200 mx-5 mb-4"></div>

        <div class="px-5">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full flex items-center gap-3 rounded-xl px-4 py-2.5
                           text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700
                           duration-300 cursor-pointer active:scale-95 font-medium transition-colors">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</div>