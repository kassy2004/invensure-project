<div class="navbar bg-white shadow-sm">
  <div class="flex-1">
    <x-invensure-logo class="ml-10" />
    
    
  </div>
  <div class="flex-none">
    <div class="border border-gray-200 py-2 px-3 rounded-md text-gray-600 flex items-center gap-2 cursor-pointer">
      <x-lucide-log-out class="h-4 w-4 shrink-0" />
      <form method="POST" action="{{ route('logout') }}">
        @csrf
            <button type="submit" class="text-sm">Sign Out</button>
      </form>

    </div>
  </div>
</div>