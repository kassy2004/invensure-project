<div class="flex w-full min-h-screen">
  <!-- Sidebar toggle -->
  <input id="sidebar-toggle" type="checkbox" class="hidden" />

  <!-- Sidebar -->
  <div id="sidebar" class="bg-base-100 text-grey min-h-screen transition-all duration-300
              w-16 overflow-hidden group" :class="{ 'w-64': document.getElementById('sidebar-toggle').checked }">
    <div class="flex items-center justify-between px-5 py-4">
      <span class="text-lg font-bold hidden group-[.w-64]:inline text-gray-300 ">Admin</span>
      <label for="sidebar-toggle" class="cursor-pointer text-grey">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-400" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </label>
    </div>
    <hr class="border-gray-700">
    <ul class="space-y-2 py-2">
      <li 
       class="flex items-center px-5 py-3 hover:bg-gray-200 cursor-pointer
       ">
        <x-lucide-home  class="h-5 w-5 shrink-0 text-indigo-400" />
        
        <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-300">Dashboard</a>
      </li>


      

      <li 
       class="flex items-center  px-5 py-3 hover:bg-gray-900 cursor-pointer
       ">
       
        <x-lucide-computer class="h-5 w-5 shrink-0 text-indigo-400" />
        <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-300">Sales Forecasting</a>
      </li>
      
      <li 
       class="flex items-center  px-5 py-3 hover:bg-gray-900 cursor-pointer
       ">
        <x-lucide-building-2 class="h-5 w-5 shrink-0 text-indigo-400" />
        <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-300">Inventory</a>
      </li>

     
      
      <li 
       class="flex items-center  px-5 py-3 hover:bg-gray-900 cursor-pointer
       ">
       
        <x-lucide-clipboard-list class="h-5 w-5 shrink-0 text-indigo-400" /> {{-- icon --}}{{-- bladeicon --}}
        <span class="ml-3 hidden group-[.w-64]:inline text-gray-300">Delivery and Logistics</span>
      </li>
 
      
       <li 
        class="flex items-center  px-5 py-3 hover:bg-gray-900 cursor-pointer
       ">
       
        <x-lucide-users class="h-5 w-5 shrink-0 text-indigo-400" />
        <a href="" class="ml-3 hidden group-[.w-64]:inline text-gray-300">User Management</a>
      </li>


   
    </ul>
  </div>



<script>
document.addEventListener('DOMContentLoaded', function() {
  const sidebarToggle = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('sidebar');
  
  sidebarToggle.addEventListener('change', function() {
    if (this.checked) {
      sidebar.classList.add('w-64');
      sidebar.classList.remove('w-16');
      sidebar.classList.remove('justify-center');

    } else {
      sidebar.classList.remove('w-64');
      sidebar.classList.add('w-16');
    }
  });
});
</script>