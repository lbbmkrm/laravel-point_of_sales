<?php

use Livewire\Volt\Component;

new class extends Component {
    public function isActiveRoute($routeName)
    {
        return request()->routeIs($routeName);
    }
}; ?>

<div>
    <div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-30 bg-black opacity-50"></div>
    <aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20
     transition-transform bg-white border-r border-gray-200" :class="{ 'translate-x-0':
     isSidebarOpen, '-translate-x-full sm:translate-x-0': !isSidebarOpen }" aria-label=
     "Sidebar">
   <div class="h-full px-4 pb-4 overflow-y-auto bg-white">
      <ul class="space-y-2 font-medium">
         <li>
            <a href="{{ route('dashboard') }}" wire:navigate 
               class="flex items-center p-2 rounded-lg group transition-colors duration-200 
                      {{ $this->isActiveRoute('dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-900 hover:bg-gray-100' }}">
               <svg class="w-5 h-5 transition duration-75 
                          {{ $this->isActiveRoute('dashboard') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }}" 
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                  <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                  <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>
         <li>
            <a href="{{ route('cashier') }}" wire:navigate 
               class="flex items-center p-2 rounded-lg group transition-colors duration-200 
                      {{ $this->isActiveRoute('cashier') ? 'bg-blue-50 text-blue-700' : 'text-gray-900 hover:bg-gray-100' }}">
               <svg class="w-5 h-5 transition duration-75 
                          {{ $this->isActiveRoute('cashier') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }}" 
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
               </svg>
               <span class="ms-3">Kasir</span>
            </a>
         </li>
         <li>
            <a href="#" 
               class="flex items-center p-2 rounded-lg group transition-colors duration-200 text-gray-900 hover:bg-gray-100">
               <svg class="w-5 h-5 transition duration-75 text-gray-500 group-hover:text-gray-900" 
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
               </svg>
               <span class="ms-3">Laporan</span>
            </a>
         </li>
         <li>
            <a href="{{ route('products') }}" wire:navigate 
               class="flex items-center p-2 rounded-lg group transition-colors duration-200 
                      {{ $this->isActiveRoute('products') ? 'bg-blue-50 text-blue-700' : 'text-gray-900 hover:bg-gray-100' }}">
               <svg class="w-5 h-5 transition duration-75 
                          {{ $this->isActiveRoute('products') ? 'text-blue-600' : 'text-gray-500 group-hover:text-gray-900' }}" 
                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 20">
                  <path d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"/>
               </svg>
               <span class="ms-3">Produk</span>
            </a>
         </li>
      </ul>
   </div>
</aside>
</div>