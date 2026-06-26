<template>
  <div>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
      <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Authors</h1>
        <p class="text-slate-400 text-sm mt-1">{{ totalAuthors }} total authors</p>
      </div>
      <button @click="openAddModal" class="mt-4 sm:mt-0 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors flex items-center shadow-sm">
        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        Add author
      </button>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
      <!-- Toolbar -->
      <div class="p-4 border-b border-slate-100 bg-white">
        <div class="relative w-full max-w-md">
          <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </div>
          <input type="text" placeholder="Search authors..." class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm transition-colors" />
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-100">
          <thead class="bg-slate-50/50">
            <tr>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 tracking-wider w-5/12">NAME</th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 tracking-wider">EMAIL</th>
              <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 tracking-wider">BORN</th>
              <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-slate-500 tracking-wider">BOOKS</th>
              <th scope="col" class="px-6 py-4 relative">
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-slate-50">
            <tr v-if="pending">
              <td colspan="5" class="px-6 py-8 text-center">
                <div class="flex justify-center">
                  <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div>
                </div>
              </td>
            </tr>
            <tr v-else-if="error">
              <td colspan="5" class="px-6 py-8 text-center text-red-500">Failed to load authors.</td>
            </tr>
            <tr v-else-if="!authors?.data?.length">
              <td colspan="5" class="px-6 py-8 text-center text-slate-500">No authors found.</td>
            </tr>
            <tr v-for="author in authors.data" :key="author.id" class="hover:bg-slate-50/50 transition-colors group">
              <!-- Name Column -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                    <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm border border-indigo-100">
                      {{ getInitials(author.name) }}
                    </div>
                  </div>
                  <div class="ml-4 max-w-xs">
                    <div class="text-sm font-semibold text-slate-800 truncate">{{ author.name }}</div>
                    <div class="text-xs text-slate-400 truncate mt-0.5" :title="author.bio">{{ author.bio || 'No biography' }}</div>
                  </div>
                </div>
              </td>
              <!-- Email Column -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-slate-600">{{ author.email || '-' }}</div>
              </td>
              <!-- Born Column -->
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-slate-600">{{ author.birth_date ? new Date(author.birth_date).getFullYear() : '-' }}</div>
              </td>
              <!-- Books Column -->
              <td class="px-6 py-4 whitespace-nowrap text-center">
                <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-md bg-indigo-50 text-indigo-700">
                  {{ author.books_count || 0 }}
                </span>
              </td>
              <!-- Actions Column -->
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium relative">
                <button @click="toggleDropdown(author.id)" class="text-slate-400 hover:text-indigo-600 p-1 rounded-md hover:bg-indigo-50 transition-colors focus:outline-none">
                  <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                </button>

                <!-- Dropdown Menu -->
                <div v-if="activeDropdown === author.id" v-click-outside="closeDropdown" class="origin-top-right absolute right-8 top-10 mt-2 w-32 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-slate-100 focus:outline-none z-10">
                  <div class="py-1">
                    <button @click="openEditModal(author)" class="group flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-indigo-600 w-full text-left transition-colors">
                      <svg class="mr-3 h-4 w-4 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                      Edit
                    </button>
                    <button @click="deleteAuthor(author.id)" class="group flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left transition-colors">
                      <svg class="mr-3 h-4 w-4 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                      Delete
                    </button>
                  </div>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="authors?.meta" class="px-6 py-4 border-t border-slate-100 bg-white">
        <Pagination :meta="authors.meta" @page-changed="changePage" />
      </div>
    </div>

    <!-- Modals -->
    <AuthorForm 
      v-if="showModal" 
      :initial-data="editingAuthor" 
      :is-editing="!!editingAuthor" 
      @close="closeModal" 
      @saved="refreshAuthors" 
    />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const api = useApi()
const currentPage = ref(1)

const { data: authors, pending, error, refresh } = await useAsyncData(
  () => `authors-${currentPage.value}`,
  () => api(`/authors?page=${currentPage.value}`)
)

const totalAuthors = computed(() => authors.value?.meta?.total || 0)

const changePage = (page) => {
  currentPage.value = page
}

const getInitials = (name) => {
  if (!name) return ''
  const words = name.split(' ')
  if (words.length === 1) return words[0].substring(0, 2).toUpperCase()
  return (words[0][0] + words[words.length - 1][0]).toUpperCase()
}

// Modal State
const showModal = ref(false)
const editingAuthor = ref(null)

const openAddModal = () => {
  editingAuthor.value = null
  showModal.value = true
}

const openEditModal = (author) => {
  editingAuthor.value = { ...author }
  showModal.value = true
  closeDropdown()
}

const closeModal = () => {
  showModal.value = false
  editingAuthor.value = null
}

const refreshAuthors = () => {
  refresh()
}

// Dropdown State
const activeDropdown = ref(null)

const toggleDropdown = (id) => {
  if (activeDropdown.value === id) {
    activeDropdown.value = null
  } else {
    activeDropdown.value = id
  }
}

const closeDropdown = () => {
  activeDropdown.value = null
}

const deleteAuthor = async (id) => {
  if (!confirm('Are you sure you want to delete this author?')) return
  
  try {
    await api(`/authors/${id}`, { method: 'DELETE' })
    refresh()
  } catch (err) {
    alert('Failed to delete author.')
  } finally {
    closeDropdown()
  }
}

// Click outside directive simulation for Vue 3 (simple implementation)
const vClickOutside = {
  mounted(el, binding) {
    el.clickOutsideEvent = function(event) {
      if (!(el === event.target || el.contains(event.target))) {
        binding.value(event);
      }
    };
    // Delay adding the listener to avoid triggering it on the button click that opened it
    setTimeout(() => {
      document.body.addEventListener('click', el.clickOutsideEvent);
    }, 0);
  },
  unmounted(el) {
    document.body.removeEventListener('click', el.clickOutsideEvent);
  }
}
</script>
