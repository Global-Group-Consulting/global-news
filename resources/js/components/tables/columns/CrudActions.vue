<template>
  <a :href="`${resource}/${id}/edit`" class="btn btn-link">
    <i class="fas fa-edit"></i>
  </a>

  <a :href="`${resource}/${id}`" class="btn btn-link">
    <i class="fas fa-eye"></i>
  </a>

  <button class="btn btn-link text-danger"
          data-bs-toggle="modal"
          data-bs-target="#deleteModal"
          :data-bs-id="id">
    <i class="fas fa-trash"></i>
  </button>

</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  name: 'CrudActions',
  props: {
    id: [String, Number],
    resource: String
  },
  setup (props) {

    return {}
  }
})
</script>

<style scoped>

</style>
