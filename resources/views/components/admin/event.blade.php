<div class="event_item border rounded-sm overflow-hidden">
  <a href="{{ route('events.show', $event->id) }}">
      <div class="overflow-hidden">
          <img src="{{ $event->event_photo }}" alt="" class="w-full overflow-hidden hover:scale-105 transition-all duration-100 ease-in">
      </div>
      <div class="p-2">
          <h3 class="text-lg font-semibold uppercase">{{ $event->name }}</h3>
          <p class="text-gray-400">{{ $event->location }}</p>
      </div>
  </a>
</div>