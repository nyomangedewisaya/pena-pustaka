@extends('layout.form')
@section('title', 'Form Kategori')
@section('content')

    <div class="bg-white rounded-xl shadow-xl shadow-gray-200/50 w-full max-w-lg border border-gray-100 overflow-hidden">
        
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="bg-blue-600/10 px-4 py-3 rounded-full text-blue-600 flex items-center justify-center">
                    <i class="bi bi-tags-fill text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ isset($category) ? 'Edit Kategori' : 'Tambah Kategori Baru' }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ isset($category) ? 'Perbarui data kategori terpilih' : 'Silakan isi nama kategori baru' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('categories') }}" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('categories.save', $category->id ?? null) }}" method="POST" class="space-y-6">
                @csrf

                @if (isset($category))
                    <input type="hidden" name="id" value="{{ $category->id }}">
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Kategori</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-collection text-gray-400 text-lg"></i>
                        </div>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $category->name ?? '') }}" 
                            placeholder="Contoh: Novel, Sains, Sejarah..."
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                            focus:outline-none focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                    </div>
                    @error('name')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex gap-3 items-center justify-end pt-2">
                    <a href="{{ route('categories') }}" 
                       class="px-5 py-2.5 rounded-xl text-sm font-medium text-gray-600 bg-white border border-gray-300 hover:bg-gray-50 hover:text-gray-800 transition-colors">
                        Batal
                    </a>
                    
                    <button type="submit" 
                            class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 shadow-sm shadow-blue-500/30 transition-all active:scale-95 flex items-center gap-2">
                        <i class="bi bi-check-lg"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection