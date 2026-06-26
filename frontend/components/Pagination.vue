<template>
  <div class="flex items-center justify-between border-t border-gray-100 bg-white px-4 py-4 sm:px-6 mt-4 rounded-b-2xl">
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <p class="text-sm text-gray-500">
          Showing <span class="font-medium text-gray-900">{{ meta.from || 0 }}</span> to <span class="font-medium text-gray-900">{{ meta.to || 0 }}</span> of <span class="font-medium text-gray-900">{{ meta.total }}</span> results
        </p>
      </div>
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-lg shadow-sm" aria-label="Pagination">
          <button @click="$emit('page-change', meta.current_page - 1)" :disabled="meta.current_page === 1" class="relative inline-flex items-center rounded-l-lg px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-200 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 transition-colors">
            <span class="sr-only">Previous</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" /></svg>
          </button>
          
          <button v-for="page in pages" :key="page" @click="$emit('page-change', page)" :class="[page === meta.current_page ? 'relative z-10 inline-flex items-center bg-blue-600 px-4 py-2 text-sm font-semibold text-white focus:z-20 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600' : 'relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 ring-1 ring-inset ring-gray-200 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 transition-colors']">
            {{ page }}
          </button>

          <button @click="$emit('page-change', meta.current_page + 1)" :disabled="meta.current_page === meta.last_page" class="relative inline-flex items-center rounded-r-lg px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-200 hover:bg-gray-50 focus:z-20 focus:outline-offset-0 disabled:opacity-50 transition-colors">
            <span class="sr-only">Next</span>
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" /></svg>
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  meta: {
    type: Object,
    required: true
  }
})

const pages = computed(() => {
  const range = []
  if (!props.meta.last_page) return range;
  for (let i = 1; i <= props.meta.last_page; i++) {
    range.push(i)
  }
  return range
})
</script>
