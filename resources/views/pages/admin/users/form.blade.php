@extends('layout.form')
@section('title', 'Form Anggota')
@section('content')

    <div class="bg-white rounded-xl shadow-xl shadow-gray-200/50 w-full max-w-3xl border border-gray-100 overflow-hidden">
        
        <div class="px-6 pt-5 border-gray-100 flex justify-between items-center bg-gray-50/50">
            <div class="flex items-center gap-4">
                <div class="bg-blue-600/10 px-4 py-3 rounded-full text-blue-600 flex items-center justify-center">
                    <i class="bi bi-person-plus-fill text-xl"></i>
                </div>
                <div class="flex flex-col">
                    <h2 class="text-lg font-bold text-gray-800">
                        {{ isset($user) ? 'Edit Anggota' : 'Tambah Anggota Baru' }}
                    </h2>
                    <p class="text-sm text-gray-500">
                        {{ isset($user) ? 'Perbarui data anggota perpustakaan' : 'Daftarkan anggota baru untuk akses perpustakaan' }}
                    </p>
                </div>
            </div>
            <a href="{{ route('users') }}" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-2 rounded-lg transition-colors">
                <i class="bi bi-x-lg text-lg"></i>
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('users.save', $user->id ?? null) }}" method="POST" class="space-y-2">
                @csrf
                
                @if(isset($user))
                    <input type="hidden" name="id" value="{{ $user->id }}">
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Anggota</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400 text-lg"></i>
                        </div>
                        <input 
                            type="text" name="full_name" value="{{ old('full_name', $user->full_name ?? '') }}" 
                            placeholder="Masukan nama lengkap anggota"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                            focus:outline-none focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('full_name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                    </div>
                    @error('full_name')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">NISN</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-card-heading text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="text" name="nisn" value="{{ old('nisn', $user->nisn ?? '') }}" 
                                placeholder="Nomor Induk Siswa Nasional"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('nisn') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('nisn')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Kelas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-building text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="text" name="class" value="{{ old('class', $user->class ?? '') }}" 
                                placeholder="Contoh: XII RPL 1"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('class') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('class')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-telephone text-gray-400 text-lg"></i>
                        </div>
                        <input 
                            type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}" 
                            placeholder="Contoh: 081234567890"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                            focus:outline-none focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('phone') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                    </div>
                    @error('phone')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat Lengkap</label>
                    <div class="relative">
                        <div class="absolute top-2 left-0 pl-3 flex items-start pointer-events-none">
                            <i class="bi bi-geo-alt text-gray-400 text-lg"></i>
                        </div>
                        <textarea name="address" rows="2" 
                            placeholder="Masukan alamat lengkap anggota..."
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 resize-none
                            focus:outline-none focus:ring-1 focus:ring-blue-600 
                            transition duration-200 ease-in-out sm:text-sm
                            @error('address') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">{{ old('address', $user->address ?? '') }}</textarea>
                    </div>
                    @error('address')
                        <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2 border-t border-gray-100">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-person-badge text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                type="text" name="username" value="{{ old('username', $user->username ?? '') }}" 
                                placeholder="Username unik"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('username') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400 text-lg"></i>
                            </div>
                            <input 
                                :type="show ? 'text' : 'password'" name="password" 
                                placeholder="{{ isset($user) ? 'Kosongkan jika tidak diubah' : 'Buat password' }}"
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                            
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer focus:outline-none text-gray-400 hover:text-gray-600">
                                <i class="bi text-lg" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1 flex items-center gap-1"><i class="bi bi-exclamation-circle"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-3 items-center justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('users') }}" 
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