<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Leads</h1>
    <table class="w-100 border">
      <thead>
        <tr>
          <th class="border px-4 py-2">Name</th>
          <th class="border px-4 py-2">Email</th>
          <th class="border px-4 py-2">Consent</th>
          <th class="border px-4 py-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="lead in leads" :key="lead.id">
          <td class="border px-4 py-2">
            <input v-model="lead.name" class=" p-1 w-full" style="border:none;"/>
          </td>
          <td class="border px-4 py-2">
            <input v-model="lead.email" class=" p-1 w-full" style="border:none;" />
          </td>
          <td class="border px-4 py-2 text-center">
             <input type="checkbox" v-model="lead.consent" />
          </td>
          <td class="border px-4 py-2 text-center">
            <button
              class="px-2 py-1 btn btn-success rounded"
              @click="updateLead(lead)"
            >
              Save
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const leads = ref([])

// Fetch leads function
async function fetchLeads() {
  try {
    const res = await axios.get('http://127.0.0.1:8000/api/leads')
    leads.value = res.data
  } catch (err) {
    console.error('Error fetching leads:', err)
  }
}

// Call on mount
onMounted(fetchLeads)

// Update lead
async function updateLead(lead) {
  console.log(lead)
  try {
    await axios.put(`http://127.0.0.1:8000/api/leads/${lead.id}`, {
      name: lead.name,
      email: lead.email,
      consent: lead.consent
    })
    alert('Lead updated successfully!')
    
    // Refresh the list
    await fetchLeads() 

  } catch (err) {
    console.error(err)
    alert('Error updating lead')
  }
}
</script>
