<template>
  <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="$emit('close')"></div>
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6 md:p-8">
        
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
            {{ isEditing ? 'Edit book' : 'Add book' }}
          </h3>
          <button @click="$emit('close')" type="button" class="text-gray-400 hover:text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>

        <div v-if="authorsPending" class="flex justify-center mb-4">
          <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-indigo-600"></div>
        </div>

        <form v-else @submit.prevent="submitForm">
          <!-- Title -->
          <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
            <input type="text" id="title" v-model="form.title" required
              class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="e.g. Bumi Manusia" />
            <p v-if="validationErrors.title" class="mt-1 text-sm text-red-600">{{ validationErrors.title[0] }}</p>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- Author -->
            <div>
              <label for="author_id" class="block text-sm font-medium text-gray-700 mb-1">Author *</label>
              <select id="author_id" v-model="form.author_id" required
                class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" disabled>Select author</option>
                <option v-for="author in authorsList" :key="author.id" :value="author.id">
                  {{ author.name }}
                </option>
              </select>
              <p v-if="validationErrors.author_id" class="mt-1 text-sm text-red-600">{{ validationErrors.author_id[0] }}</p>
            </div>

            <!-- Genre -->
            <div>
              <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
              <select id="genre" v-model="form.genre"
                class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" disabled>Select genre</option>
                <option value="Literary Fiction">Literary Fiction</option>
                <option value="Historical Fiction">Historical Fiction</option>
                <option value="Science Fiction">Science Fiction</option>
                <option value="Magical Realism">Magical Realism</option>
                <option value="Romance">Romance</option>
                <option value="Mystery">Mystery</option>
                <option value="Non-fiction">Non-fiction</option>
              </select>
              <p v-if="validationErrors.genre" class="mt-1 text-sm text-red-600">{{ validationErrors.genre[0] }}</p>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- Publish Date -->
            <div>
              <label for="publish_date" class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
              <input type="date" id="publish_date" v-model="form.publish_date"
                class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              <p v-if="validationErrors.publish_date" class="mt-1 text-sm text-red-600">{{ validationErrors.publish_date[0] }}</p>
            </div>

            <!-- Pages -->
            <div>
              <label for="pages" class="block text-sm font-medium text-gray-700 mb-1">Pages</label>
              <input type="number" id="pages" v-model="form.pages" min="1"
                class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="e.g. 352" />
              <p v-if="validationErrors.pages" class="mt-1 text-sm text-red-600">{{ validationErrors.pages[0] }}</p>
            </div>
          </div>

          <!-- Description -->
          <div class="mb-6">
            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Synopsis/Description</label>
            <textarea id="description" v-model="form.description" rows="2"
              class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="Short description..."></textarea>
            <p v-if="validationErrors.description" class="mt-1 text-sm text-red-600">{{ validationErrors.description[0] }}</p>
          </div>

          <!-- Actions -->
          <div class="flex justify-end space-x-3">
            <button type="button" @click="$emit('close')"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Cancel
            </button>
            <button type="submit" :disabled="isSubmitting"
              class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
              {{ isSubmitting ? 'Saving...' : 'Save book' }}
            </button>
          </div>

          <!-- Global Error -->
          <div v-if="submitError && !Object.keys(validationErrors).length" class="mt-4 text-sm text-red-600">
            {{ submitError }}
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'

const props = defineProps({
  initialData: {
    type: Object,
    default: () => null
  },
  isEditing: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close', 'saved'])
const api = useApi()

const authorsList = ref([])
const authorsPending = ref(true)

onMounted(async () => {
  try {
    const res = await api('/authors?page=1')
    authorsList.value = res.data || []
  } catch (err) {
    console.error('Failed to load authors:', err)
  } finally {
    authorsPending.value = false
  }
})

const form = reactive({
  title: props.initialData?.title || '',
  author_id: props.initialData?.author_id || '',
  genre: props.initialData?.genre || '',
  pages: props.initialData?.pages || '',
  publish_date: props.initialData?.publish_date || '',
  description: props.initialData?.description || ''
})

const isSubmitting = ref(false)
const submitError = ref('')
const validationErrors = ref({})

const submitForm = async () => {
  isSubmitting.value = true
  submitError.value = ''
  validationErrors.value = {}

  try {
    const endpoint = props.isEditing ? `/books/${props.initialData.id}` : '/books'
    const method = props.isEditing ? 'PUT' : 'POST'
    
    await api(endpoint, {
      method,
      body: form
    })
    
    emit('saved')
    emit('close')
  } catch (error) {
    if (error.response?.status === 422) {
      validationErrors.value = error.response._data.errors || {}
    } else {
      submitError.value = error.message || 'An error occurred while saving.'
    }
  } finally {
    isSubmitting.value = false
  }
}
</script>
