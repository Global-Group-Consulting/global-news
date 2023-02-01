<template>
  <a :href="`newsletters/${row.id}/edit`" class="btn btn-link">
    <i class="fas fa-edit"></i>
  </a>

  <a :href="`newsletters/${row.id}`" class="btn btn-link">
    <i class="fas fa-eye"></i>
  </a>

  <button class="btn btn-link text-danger"
          data-bs-toggle="modal"
          data-bs-target="#deleteModal"
          :data-bs-id="row.id">
    <i class="fas fa-trash"></i>
  </button>

</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'NewsletterTableActions',
  props: {
    row: Object,
    column: Object
  }
})
</script>
