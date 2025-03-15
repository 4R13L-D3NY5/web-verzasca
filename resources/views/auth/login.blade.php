@extends('layouts.guest')

@section('content')
    <div class="max-w-md w-full mx-auto bg-white p-8 rounded-lg shadow-md">
        <p class="text-center text-2xl font-semibold mb-4">{{ __('Login') }}</p>

        <form action="{{ route('login') }}" method="post">
            @csrf

            <div class="mb-4">
                <input type="email" name="email" class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror" placeholder="{{ __('Email') }}" required autofocus>
                @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-4">
                <input type="password" name="password" class="form-input w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror" placeholder="{{ __('Password') }}" required>
                @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="form-checkbox text-blue-600 h-4 w-4 mr-2">
                    <label for="remember" class="text-sm">{{ __('Remember Me') }}</label>
                </div>
                <div>
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ __('Login') }}</button>
                </div>
            </div>
        </form>

        @if (Route::has('password.request'))
            <p class="text-center mt-4">
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">{{ __('Forgot Your Password?') }}</a>
            </p>
        @endif
    </div>
@endsection
