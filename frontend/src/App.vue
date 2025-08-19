<template>
  <div class="container text-center mt-5">
    <h1 class="mb-3">Welcome to FSSE Leads</h1>
    <p class="mb-4">Subscribe to our newsletter or view existing leads.</p>

    <!-- Buttons -->
    <div class="mb-4">
      <!-- Modal trigger -->
      <button
        type="button"
        class="btn btn-primary me-2"
        data-bs-toggle="modal"
        data-bs-target="#leadModal"
      >
        Subscribe Now
      </button>
    </div>

    <!-- Modal -->
    <div
      class="modal fade"
      id="leadModal"
      tabindex="-1"
      aria-labelledby="leadModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="leadModalLabel">Subscribe</h5>
            <button
              type="button"
              class="btn-close mt-3 btn-dark"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <LeadForm @submitted="closeModal" />
          </div>
        </div>
      </div>
    </div>

    <!-- Router view for Leads List -->
    <router-view></router-view>
    
    <div class="mt-5">All rights reserved. 2025 &copy; Karl Zafiris</div>
  </div>
</template>

<script setup>
import LeadForm from './components/LeadForm.vue'

function closeModal() {
  const modalEl = document.getElementById('leadModal')
  const modal = bootstrap.Modal.getInstance(modalEl)
  if (modal) modal.hide()
}
</script>
