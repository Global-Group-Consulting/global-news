<template>
  <G-Table :columns="columns" :data="data">
    <template v-slot:cell_list="{data}">
      {{ data.list?.name }}
    </template>

    <template v-slot:pagination>
      <slot name="pagination"></slot>
    </template>
  </G-Table>
</template>

<script>
import { defineComponent, onMounted, ref } from 'vue'

export default defineComponent({
  name: 'NewsletterTable',
  props: {
    newsletters: {
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
        'label': 'Oggetto',
        'name': 'subject'
      },
      {
        'label': 'Stato',
        'name': 'status'
      },
      {
        'label': 'Lista',
        'name': 'list'
      },
      {
        'label': 'Invio programmato',
        'name': 'scheduled_at',
        'type': 'datetime'
      },
      {
        'label': 'Data creazione',
        'name': 'created_at',
        'type': 'datetime'
      },
      {
        'label': '',
        'type': 'component',
        'component': 'crud-actions',
        'componentProps': {
          "resource": "newsletters"
        }
      }
    ]

    onMounted(() => {
      data.value = props.newsletters.data
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
