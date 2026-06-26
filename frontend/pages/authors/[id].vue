<template>
  <div class="max-w-2xl mx-auto">
    <div class="mb-8">
      <NuxtLink to="/authors" class="text-sm text-blue-600 hover:text-blue-800 flex items-center mb-4 transition-colors">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Back to Authors
      </NuxtLink>
      <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Author</h1>
      <p class="text-gray-500 mt-1">Update the author's details below.</p>
    </div>

    <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-100">
      <div v-if="pending" class="flex justify-center py-8">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
      </div>
      <div v-else-if="error" class="text-red-500 text-center py-8">
        Failed to load author details.
      </div>
      <AuthorForm v-else-if="author" :initial-data="author" :is-editing="true" />
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
const api = useApi()

const { data: author, pending, error } = await useAsyncData(
  `author-${route.params.id}`,
  () => api(`/authors/${route.params.id}`)
)
</script>
