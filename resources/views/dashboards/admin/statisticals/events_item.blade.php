<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3 text-sm">Tên sự kiện</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Số lượng sinh viên tham gia</th>
                <th scope="col" class="px-6 py-3 text-center text-sm">Chi tiết</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words whitespace-normal">
                    {{ $event->name }}
                </th>
                <td class="px-6 py-4 text-center">{{ $event->students_count }}</td>
                <td class="px-6 py-4 text-center">
                    <button class="text-blue-600 hover:underline" onclick="showEventDetails('{{ $event->id }}')">Chi tiết</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $events->links('pagination::tailwind') }}
    </div>
</div>
