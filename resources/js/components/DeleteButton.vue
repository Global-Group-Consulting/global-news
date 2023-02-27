<template>
  <button class="btn btn-link text-danger" @click="openModal" v-bind="$attrs">
    <i class="fas fa-trash" :class="{'me-1': hasLabel}"></i>
    <template v-if="hasLabel">
      {{ typeof label === 'string' && label ? label : 'Elimina' }}
    </template>
  </button>

  <div class="modal fade" tabindex="-1" ref="deleteModal">
    <div class="modal-dialog">
      <form class="modal-content" :action="`${resource}/${id}`" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" :value="csrfToken">

        <div class="modal-header">
          <h5 class="modal-title">Cancellare l'elemento selezionato?</h5>
        </div>

        <div class="modal-body">
          <p>Sei sicuro di voler cancellare questo elemento? L'operazione sarà <strong>irreversibile</strong>!</p>
        </div>

        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
          <button type="submit" class="btn btn-danger">
            Si, cancella
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Modal from 'bootstrap/js/dist/modal'

import { computed, defineComponent, onBeforeMount, ref } from 'vue'

export default defineComponent({
  name: 'DeleteButton',
  props: {
    id: [String, Number],
    resource: String,
    label: String
  },
  setup (props) {
    const deleteModal = ref()
    let csrfToken = ref()

    const hasLabel = computed(() => typeof props.label !== 'undefined')

    function openModal () {
      const myModal = new Modal(deleteModal.value, {})

      myModal.show()
    }

    onBeforeMount(() => {
      csrfToken.value = document.querySelector('meta[name="_token"]').getAttribute('content')
    })

    return {
      deleteModal,
      csrfToken,
      openModal,
      hasLabel
    }
  }
})
</script>

<style scoped>

</style>
