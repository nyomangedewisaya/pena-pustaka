@extends('layout.form')
@section('title', 'Daftar Pena Pustaka')

@section('content')

    <div class="absolute top-0 left-0 w-full h-[38%] bg-blue-700 z-0"></div>

    <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-lg px-4">

        
        <div class="bg-white py-8 px-6 shadow-lg rounded-xl border border-gray-100">
            <div class="mb-6 text-center">
                <h1 class="text-2xl font-bold text-gray-700">Daftarkan Dirimu</h1>
                <p class="mt-1 text-gray-500 text-sm">Isi data diri Anda untuk menjadi anggota Pena Pustaka</p>
            </div>
            <form action="{{ route('register.post') }}" method="POST" class="space-y-2">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-person text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                            placeholder="Masukan Nama Lengkap Anda"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('full_name') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                    </div>
                    @error('full_name')
                        <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-card-heading text-gray-400 text-lg"></i>
                            </div>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="NISN Anda"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                    focus:outline-none focus:ring-1 focus:ring-blue-600 
                                    transition duration-200 ease-in-out sm:text-sm
                                    @error('nisn') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('nisn')
                            <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-building text-gray-400 text-lg"></i>
                            </div>
                            <input type="text" name="class" value="{{ old('class') }}" placeholder="Kelas Anda"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                    focus:outline-none focus:ring-1 focus:ring-blue-600 
                                    transition duration-200 ease-in-out sm:text-sm
                                    @error('class') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('class')
                            <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="bi bi-telephone text-gray-400 text-lg"></i>
                        </div>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                            placeholder="08xxxx"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('phone') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                    </div>
                    @error('phone')
                        <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <div class="relative">
                        <div class="absolute top-2 left-0 pl-3 flex items-start pointer-events-none">
                            <i class="bi bi-geo-alt text-gray-400 text-lg"></i>
                        </div>
                        <textarea name="address" rows="2" placeholder="Masukkan alamat lengkap anda"
                            class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 resize-none
                                focus:outline-none focus:ring-1 focus:ring-blue-600 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('address') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">{{ old('address') }}</textarea>
                    </div>
                    @error('address')
                        <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-person-badge text-gray-400 text-lg"></i>
                            </div>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="Username"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                    focus:outline-none focus:ring-1 focus:ring-blue-600 
                                    transition duration-200 ease-in-out sm:text-sm
                                    @error('username') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400 text-lg"></i>
                            </div>
                            <input :type="show ? 'text' : 'password'" name="password" placeholder="Password"
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                    focus:outline-none focus:ring-1 focus:ring-blue-600 
                                    transition duration-200 ease-in-out sm:text-sm
                                    @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">

                            <button type="button" @click="show = !show"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer focus:outline-none text-gray-400 hover:text-gray-600">
                                <i class="bi text-lg" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i>
                                {{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-700 hover:bg-blue-700 focus:outline-none focus:ring-2 active:scale-95 transition-all duration-300">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500 hover:underline">
                        Login
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
