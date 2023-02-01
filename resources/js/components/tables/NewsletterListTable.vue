<template>
  <G-Table :columns="columns" :data="data">
    <template v-slot:pagination>
      <slot name="pagination"></slot>
    </template>
  </G-Table>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue'

export default defineComponent({
  name: 'NewsletterListTable',
  props: {
    newsletterLists: {
      type: Object,
      required: true
    }
  },
  setup (props) {
    const data = ref([])
    const columns = [
      {
        'label': 'ID',
        'name': 'id'
      },
      {
        'label': 'Nome',
        'name': 'name'
      },
      {
        'label': 'Utenti',
        'name': 'user_ids'
      },
      {
        'label': 'Ruoli',
        'name': 'roles'
      },
      {
        'label': '',
        'type': 'component',
        'component': 'crud-actions',
        componentProps: {
          "resource": "newsletter_lists"
        }
      }
    ]

    onMounted(() => {
      data.value = props.newsletterLists.data
    })

    return {
      columns,
      data
    }
  }
})
</script>

<style scoped>

</style>
