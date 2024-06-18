@extends('layouts.link_script')

{{-- Body --}}
@section('content')
    <div class="w-full h-[100vh] flex flex-col gap-3 items-center justify-center auth-bg">
        {{-- Error notify --}}
        @if ($errors->any())
            <div class="mb-2 form_error_notify bg-white rounded-lg overflow-hidden">
                <span class="block w-full p-4 bg-red-500 text-white">Error</span>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-500 p-4">{{ $error }}</li>
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
        <form method="POST" action="{{ route('handle_register') }}"
            class="min-w-[400px] shadow-lg overflow-hidden h-auto flex rounded-lg bg-[var(--form-bg)] text-[var(--text)] px-8 py-6 flex-col gap-4">
            @csrf
            <h3 class="text-lg font-semibold">Create a free account</h3>

            <label for="name" class="flex flex-col gap-[8px]">
                <span class="text-sm text-gray-300">Your name</span>
                <input type="name" placeholder="" name="name" id="name"
                    class="rounded-lg border bg-[var(--input-form-bg)] focus:border-[var(--primary)] transition-colors duration-300 ease-in border-gray-500 p-2 outline-none w-full text-sm ">
            </label>

            <label for="email" class="flex flex-col gap-[8px]">
                <span class="text-sm text-gray-300">Email</span>
                <input type="email" placeholder="" name="email" id="email"
                    class="rounded-lg border bg-[var(--input-form-bg)] focus:border-[var(--primary)] transition-colors duration-300 ease-in border-gray-500 p-2 outline-none w-full text-sm">
            </label>

            <label for="password" class="flex flex-col gap-[8px]">
                <span class="text-sm text-gray-300">Password</span>
                <input type="password" placeholder="" name="password" id="password"
                    class="rounded-lg border bg-[var(--input-form-bg)] focus:border-[var(--primary)] transition-colors duration-300 ease-in border-gray-500 p-2 outline-none w-full text-sm">
            </label>

            <label for="confirm_password" class="flex flex-col gap-[8px]">
                <span class="text-sm text-gray-300">Confirm Password</span>
                <input type="password" placeholder="" name="password_confirmation" id="confirm_password"
                    class="rounded-lg border bg-[var(--input-form-bg)] focus:border-[var(--primary)] transition-colors duration-300 ease-in border-gray-500 p-2 outline-none w-full text-sm">
            </label>

            <p class="text-[12px] text-gray-500">
                By signing up you agree to Quizgecko's Terms of Service and Privacy Policy.
            </p>

            <button
                class="rounded-lg border text-sm  border-[var(--background)] bg-[var(--background)] hover:bg-[var(--primary)] transition-colors duration-300 ease-in p-2 outline-none w-full">
                Verify Email
            </button>
        </form>
        <div class="">
            <p class="text-sm">Already registered ?<a href="/auth/login" class="text-[var(--background)] underline"> Log in
                    now</a></p>
        </div>
    </div>

@endsection
@section('script')
    <script>
        // Your custom JavaScript here
        console.log('Page loaded');
    </script>
@endsection
