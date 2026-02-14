@extends('layout.form')
@section('title', 'Login Pena Pustaka')

@section('content')

        <div class="absolute top-0 left-0 w-full h-[38%] bg-blue-700 z-0"></div>

        <div class="relative z-10 sm:mx-auto sm:w-full sm:max-w-lg px-4">
            
            
            <div class="bg-white py-8 px-6 shadow-lg rounded-xl border border-gray-100">
                <div class="mb-6 text-center">
                    <h1 class="text-2xl font-bold text-gray-700">Silakan Login</h1>
                    <p class="mt-1 text-gray-500 text-sm">Masuk untuk mengakses Pena Pustaka</p>
                </div>
                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-person text-gray-400 text-lg"></i>
                            </div>
                            
                            <input
                                type="text" name="username" value="{{ old('username') }}" 
                                placeholder="Masukan Username Anda"
                                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-500 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('username') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                        </div>
                        @error('username')
                            <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="bi bi-lock text-gray-400 text-lg"></i>
                            </div>

                            <input
                                :type="show ? 'text' : 'password'" name="password" 
                                placeholder="Masukan Password Anda"
                                class="block w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg text-gray-700 bg-white placeholder-gray-400 
                                focus:outline-none focus:ring-1 focus:ring-blue-500 
                                transition duration-200 ease-in-out sm:text-sm
                                @error('password') border-rose-500 focus:ring-rose-500 focus:border-rose-500 @enderror">
                            
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 cursor-pointer focus:outline-none">
                                <i class="bi" :class="show ? 'bi-eye-slash' : 'bi-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1"><i class="bi bi-exclamation-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 active:scale-95 transition-all duration-300">
                            Login
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:text-blue-500 hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
@endsection