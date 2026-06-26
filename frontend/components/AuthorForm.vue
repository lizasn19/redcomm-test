<template>
  <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
      <!-- Background overlay -->
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="$emit('close')"></div>

      <!-- Modal panel -->
      <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
      <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full p-6 md:p-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
          <h3 class="text-xl leading-6 font-bold text-gray-900" id="modal-title">
            {{ isEditing ? 'Edit author' : 'Add author' }}
          </h3>
          <button @click="$emit('close')" type="button" class="text-gray-400 hover:text-gray-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
          </button>
        </div>

        <!-- Form -->
        <form @submit.prevent="submitForm">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <!-- Name -->
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full name *</label>
              <input type="text" id="name" v-model="form.name" required
                class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                placeholder="e.g. Pramoedya Ananta Toer" />
              <p v-if="validationErrors.name" class="mt-1 text-sm text-red-600">{{ validationErrors.name[0] }}</p>
            </div>

            <!-- Date of Birth -->
            <div>
              <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-1">Date of birth</label>
              <input type="date" id="birth_date" v-model="form.birth_date"
                class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" />
              <p v-if="validationErrors.birth_date" class="mt-1 text-sm text-red-600">{{ validationErrors.birth_date[0] }}</p>
            </div>
          </div>

          <!-- Email -->
          <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
            <input type="email" id="email" v-model="form.email" required
              class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="author@example.com" />
            <p v-if="validationErrors.email" class="mt-1 text-sm text-red-600">{{ validationErrors.email[0] }}</p>
          </div>

          <!-- Bio -->
          <div class="mb-6">
            <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
            <textarea id="bio" v-model="form.bio" rows="3"
              class="w-full rounded-lg border-gray-300 border px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="A short bio about the author..."></textarea>
            <p v-if="validationErrors.bio" class="mt-1 text-sm text-red-600">{{ validationErrors.bio[0] }}</p>
          </div>

          <!-- Actions -->
          <div class="flex justify-end space-x-3">
            <button type="button" @click="$emit('close')"
              class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Cancel
            </button>
            <button type="submit" :disabled="isSubmitting"
              class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
              {{ isSubmitting ? 'Saving...' : 'Save author' }}
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
import { ref, reactive } from 'vue'

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

const form = reactive({
  name: props.initialData?.name || '',
  email: props.initialData?.email || '',
  birth_date: props.initialData?.birth_date || '',
  bio: props.initialData?.bio || ''
})

const isSubmitting = ref(false)
const submitError = ref('')
const validationErrors = ref({})

const submitForm = async () => {
  isSubmitting.value = true
  submitError.value = ''
  validationErrors.value = {}

  try {
    const endpoint = props.isEditing ? `/authors/${props.initialData.id}` : '/authors'
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
