<template>
  <div>
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Overview</h1>
      <p class="text-slate-400 text-sm mt-1">Book Author Management System</p>
    </div>

    <div v-if="pending" class="flex justify-center py-12">
      <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
    </div>

    <div v-else-if="error" class="text-red-500 bg-red-50 p-4 rounded-xl border border-red-100">
      Failed to load dashboard statistics.
    </div>

    <template v-else-if="stats">
      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Authors -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
          <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
          </div>
          <div class="text-3xl font-bold text-slate-800">{{ stats.total_authors }}</div>
          <div class="text-sm text-slate-400 mt-1">Total Authors</div>
        </div>
        
        <!-- Total Books -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
          <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
          </div>
          <div class="text-3xl font-bold text-slate-800">{{ stats.total_books }}</div>
          <div class="text-sm text-slate-400 mt-1">Total Books</div>
        </div>
        
        <!-- Genres -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
          <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center text-purple-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
          </div>
          <div class="text-3xl font-bold text-slate-800">{{ stats.genres_count }}</div>
          <div class="text-sm text-slate-400 mt-1">Genres</div>
        </div>

        <!-- Avg per Author -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
          <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
          </div>
          <div class="text-3xl font-bold text-slate-800">{{ stats.avg_per_author }}</div>
          <div class="text-sm text-slate-400 mt-1">Avg. per Author</div>
        </div>
      </div>

      <!-- Main Panels -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Books by Genre -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
          <h2 class="text-lg font-bold text-slate-800 mb-6">Books by genre</h2>
          <div class="space-y-4">
            <div v-for="item in stats.books_by_genre" :key="item.genre" class="relative pt-1">
              <div class="flex mb-2 items-center justify-between">
                <span class="text-sm font-medium text-slate-600">{{ item.genre }}</span>
                <span class="text-sm font-bold text-slate-800">{{ item.total }}</span>
              </div>
              <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-slate-100">
                <div :style="`width: ${(item.total / maxGenreCount) * 100}%`" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-indigo-500 rounded-full"></div>
              </div>
            </div>
            <div v-if="stats.books_by_genre.length === 0" class="text-sm text-slate-400 text-center py-4">No genres available</div>
          </div>
        </div>

        <!-- Most prolific authors -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
          <h2 class="text-lg font-bold text-slate-800 mb-6">Most prolific authors</h2>
          <div class="space-y-4">
            <div v-for="(author, index) in stats.most_prolific_authors" :key="author.id" class="flex items-center justify-between group">
              <div class="flex items-center space-x-4">
                <span class="text-slate-300 font-medium w-4">{{ index + 1 }}</span>
                <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold">
                  {{ getInitials(author.name) }}
                </div>
                <span class="text-slate-700 font-medium">{{ author.name }}</span>
              </div>
              <span class="text-xs font-medium bg-indigo-50 text-indigo-600 px-2 py-1 rounded-md">{{ author.books_count }} books</span>
            </div>
            <div v-if="stats.most_prolific_authors.length === 0" class="text-sm text-slate-400 text-center py-4">No authors available</div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const api = useApi()

const { data: stats, pending, error } = await useAsyncData('dashboard-stats', () => api('/dashboard/stats'))

const maxGenreCount = computed(() => {
  if (!stats.value || !stats.value.books_by_genre.length) return 1
  return Math.max(...stats.value.books_by_genre.map(g => g.total))
})

const getInitials = (name) => {
  if (!name) return ''
  const words = name.split(' ')
  if (words.length === 1) return words[0].substring(0, 2).toUpperCase()
  return (words[0][0] + words[words.length - 1][0]).toUpperCase()
}
</script>
