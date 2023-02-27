<template>
  <div class="text-nowrap">
    <a :href="`${resource}/${id}/edit`" class="btn btn-link">
      <i class="fas fa-edit"></i>
    </a>

    <a :href="`${resource}/${id}`" class="btn btn-link">
      <i class="fas fa-eye"></i>
    </a>

    <DeleteButton :resource="resource" :id="id"></DeleteButton>
  </div>
</template>

<script>
import { defineComponent, onBeforeMount, ref } from 'vue'

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
