<template>
  <div class="flex h-screen bg-[#f8f9fa] font-sans">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-100 flex flex-col justify-between">
      <div>
        <!-- Logo -->
        <div class="p-6 flex items-center space-x-3">
          <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <div>
            <h1 class="text-gray-900 font-bold text-lg leading-tight tracking-tight">BookShelf</h1>
            <p class="text-gray-400 text-xs">Author Manager</p>
          </div>
        </div>

        <!-- Navigation -->
        <nav class="px-4 mt-2 space-y-1">
          <NuxtLink to="/" class="flex items-center px-3 py-2.5 rounded-xl transition-colors duration-200" active-class="bg-indigo-50 text-indigo-700 font-medium" inactive-class="text-gray-500 hover:bg-gray-50 hover:text-gray-900">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Overview
          </NuxtLink>
          <NuxtLink to="/authors" class="flex items-center px-3 py-2.5 rounded-xl transition-colors duration-200" active-class="bg-indigo-50 text-indigo-700 font-medium" inactive-class="text-gray-500 hover:bg-gray-50 hover:text-gray-900">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            Authors
          </NuxtLink>
          <NuxtLink to="/books" class="flex items-center px-3 py-2.5 rounded-xl transition-colors duration-200" active-class="bg-indigo-50 text-indigo-700 font-medium" inactive-class="text-gray-500 hover:bg-gray-50 hover:text-gray-900">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            Books
          </NuxtLink>
        </nav>
      </div>

      <!-- Admin Profile -->
      <div class="p-4 border-t border-gray-100 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-sm">
            A
          </div>
          <div class="overflow-hidden">
            <p class="text-sm font-semibold text-gray-900 truncate">Admin</p>
            <p class="text-xs text-gray-400 truncate">admin@bookshelf.dev</p>
          </div>
        </div>
        <button class="text-gray-400 hover:text-gray-600">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto">
      <div class="p-8 md:p-10">
        <slot />
      </div>
    </main>
  </div>
</template>
