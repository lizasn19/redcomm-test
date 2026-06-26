<template>
  <div class="max-w-2xl mx-auto">
    <div class="mb-8">
      <NuxtLink to="/books" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center mb-4 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Books
      </NuxtLink>
      <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Book</h1>
      <p class="text-gray-500 mt-1">Update the book's details below.</p>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
      <div v-if="pending" class="flex justify-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
      </div>
      <div v-else-if="error" class="text-red-500 text-center py-8">
        Failed to load book details.
      </div>
      <BookForm v-else-if="book" :initial-data="book" :is-editing="true" />
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
const api = useApi()

const { data: book, pending, error } = await useAsyncData(
  `book-${route.params.id}`,
  () => api(`/books/${route.params.id}`)
)
</script>
