<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Subscribe</h2>
    <form @submit.prevent="submitForm">
      <input
        v-model="form.name"
        type="text"
        placeholder="Full Name"
        class="border p-2 w-full mb-2 form-control"
        required
      />
      <input
        v-model="form.email"
        type="email"
        placeholder="Email"
        class="border p-2 w-full mb-2 form-control"
        required
      />

      <label class="flex items-center mb-4">
        <input type="checkbox" v-model="form.consent" class="mr-2" />
        I consent to receive marketing emails
      </label>
      <br>
      <button
        type="submit"
        class="px-4 py-2 btn btn-dark"
      >
        Submit
      </button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

// define the event to emit
const emit = defineEmits(['submitted'])

const form = ref({ name: '', email: '', consent: false })

async function submitForm() {
  try {
    await axios.post('http://localhost:8000/api/leads', form.value)
    alert('Lead captured successfully!')
    form.value = { name: '', email: '', consent: false }
    emit('submitted') // close the modal
    window.location.reload();
  } catch (e) {
    console.error(e)
    alert('Error saving lead')
  }
}
</script>
