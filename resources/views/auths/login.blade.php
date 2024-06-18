@extends('layouts.login')

{{-- Body --}}
@section('content')
    <div class="w-full h-[100vh] flex flex-col gap-3 items-center justify-center bg-gray-300">
        {{-- Error notify --}}
        @if ($errors->any())
            <div class="mb-2 form_error_notify bg-white rounded-lg overflow-hidden">
                <span class="block w-full p-4 bg-red-500 text-white">Error</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500 p-2">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Success notify --}}
        @if (session('success'))
            <div class="form_success_notify">
                <div class="mb-2 form_error_notify bg-white rounded-lg overflow-hidden">
                    <span class="block w-full p-4 bg-green-500 text-white">Success</span>
                    <ul>
                        <li class="text-green-500 p-4">{{ session('success') }}</li>
                    </ul>
                </div>
            </div>
        @endif
        <form method="POST" action="{{ route('handle_login') }}"
            class="min-w-[400px] shadow-lg overflow-hidden h-auto flex rounded-lg bg-gray-200 text-[var(--text)]  px-8 py-6 flex-col gap-4">
            @csrf
            <h3 class="text-lg font-semibold">Log in</h3>

            <label for="email" class="flex flex-col gap-[8px]">
                <span class="text-sm text-gray-500">Email</span>
                <input type="email" placeholder="" name="email" id="email"
                    class="rounded-lg border bg-transparent border-gray-500 p-2 outline-none w-full text-sm focus:border-blue-500 focus:border-2">
            </label>

            <label for="password" class="flex flex-col gap-[8px]">
                <span class="text-sm text-gray-500">Password</span>
                <input type="password" placeholder="" name="password" id="password"
                    class="rounded-lg border bg-transparent border-gray-500 p-2 outline-none w-full text-sm focus:border-blue-500 focus:border-2">
            </label>

            <label for="remember" class="flex items-center justify-start gap-1">
                <input type="checkbox" name="remember" id="remember" class="bg-[var(--background)]">
                <span class="text-sm text-gray-500">Remember me</span>
            </label>

            <button
                class="rounded-lg border text-sm  border-[var(--background)] bg-[var(--background)] hover:bg-[var(--primary)] transition-colors duration-300 ease-in p-2 outline-none w-full">
                Log in
            </button>
        </form>

        <div class="">
            <p class="text-sm">Don't have account ? <a href="/auth/register"
                    class="text-[var(--background)] underline">Create
                    here</a></p>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // Your custom JavaScript here
        console.log('Page loaded');
    </script>
@endsection
