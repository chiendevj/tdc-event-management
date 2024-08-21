<div class="choose_bar flex my-10">
    <style>
        .active-bar {
            color: #003b7a;
        }

        .active-bar a::before {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: #003b7a;
            border-radius: 999px;
        }
    </style>
    <div
        class="{{ Route::is('qr-codes.create') ? 'active-bar' : '' }} w-1/2 pb-3 text-center relative after:content('*') after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:scale-x-0 after:visible after:rounded-full after:bg-[#19a0e4] after:hover:scale-x-100 after:hover:transition duration-250 ease-out hover:text-[#19a0e4]">
        <a href="{{ route('qr-codes.create', ['id' => $id]) }}" class="block font-bold">QR</a>
    </div>
    <div
        class="{{ Route::is('event.create.form') || Route::is('event.statistic.form')  ? 'active-bar' : '' }} w-1/2 pb-3 text-center relative after:content('*') after:absolute after:bottom-0 after:left-0 after:w-full after:h-1 after:scale-x-0 after:visible after:rounded-full after:bg-[#19a0e4] after:hover:scale-x-100 after:hover:transition duration-250 ease-out hover:text-[#19a0e4]">
        <a href="{{ route('event.create.form', ['id' => $id]) }}" class="block font-bold">Câu hỏi</a>
    </div>
</div>
