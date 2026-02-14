@extends('layout.form')
@section('title', 'Form Buku')
@section('content')

    <div class="bg-white rounded-xl shadow-xl shadow-gray-200/50 w-full max-w-3xl border border-gray-100 overflow-hidden">
        
        <div class="px-6 pt-5 border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="bg-blue-600/10 px-4 py-3 rounded-full text-blue-600 flex items-center justify-center">
                    <i class="bi bi-journal-bookmark-fill text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ isset($book) ? 'Edit Buku' : 'Tambah Buku Baru' }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ isset($book) ? 'Perbarui informasi detail buku' : 'Lengkapi formulir untuk menambah koleksi' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('books') }}" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('books.save', $book->id ?? null) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf

                @if (isset($book))
                    <input type="hidden" name="id" value="{{ $book->id }}">
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Judul Buku</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-book text-gray-400 text-lg"></i>
                        </div>
                        <input 
                            type="text" name="title" value="{{ old('title', $book->title ?? '') }}" 
                            placeholder="Contoh: Laskar Pelangi"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                            focus:outline-none focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('title') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                    </div>
                    @error('title')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-collection text-gray-400 text-lg"></i>
                            </div>
                            <select name="category_id" 
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white appearance-none
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm cursor-pointer
                                @error('category_id') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $item)
                                    <option value="{{ $item->id }}" {{ old('category_id', $book->category_id ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <i class="bi bi-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                        @error('category_id')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ isset($book) ? 'Ganti Cover' : 'Upload Cover' }}</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-image text-gray-400 text-lg"></i>
                            </div>
                            <input type="file" name="cover" accept="image/*"
                                class="block w-full pl-10 text-sm text-gray-500 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none focus:ring-1 focus:ring-blue-600
                                file:mr-4 file:py-2.5 file:px-4 file:rounded-l-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition duration-200
                                @error('cover') border-rose-500 text-rose-500 file:bg-rose-50 file:text-rose-700 @enderror">
                        </div>
                        @error('cover')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Pengarang</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-person text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="text" name="author" value="{{ old('author', $book->author ?? '') }}" 
                                placeholder="Nama Pengarang"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('author') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('author')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Penerbit</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-building text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="text" name="publisher" value="{{ old('publisher', $book->publisher ?? '') }}" 
                                placeholder="Nama Penerbit"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('publisher') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('publisher')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Tahun Terbit</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-calendar-event text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="number" name="publication_year" value="{{ old('publication_year', $book->publication_year ?? '') }}" 
                                placeholder="Contoh: 2023"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('publication_year') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('publication_year')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Stok Buku</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-box-seam text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="number" name="stock" value="{{ old('stock', $book->stock ?? '') }}" 
                                placeholder="Jumlah Stok"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('stock') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('stock')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Sinopsis Singkat</label>
                    <div class="relative">
                        <div class="absolute top-2 left-0 pl-3 flex items-start pointer-events-none">
                            <i class="bi bi-file-text text-gray-400 text-lg"></i>
                        </div>
                        <textarea name="synopsis" rows="4" 
                            placeholder="Tuliskan sinopsis singkat mengenai buku ini..."
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 resize-none
                            focus:outline-none focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('synopsis') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">{{ old('synopsis', $book->synopsis ?? '') }}</textarea>
                    </div>
                    @error('synopsis')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 items-center justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('books') }}" 
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