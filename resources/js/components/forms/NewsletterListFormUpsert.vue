<template>
  <form :action="action"
        method="POST"
        enctype="multipart/form-data">

    <slot name="csrf"></slot>

    <div class="row">
      <div class="col">
        <FormInput label="Nome"
                   name="name"
                   v-model="formData.name"
                   :errors="errors"
        />
      </div>
    </div>

    <div class="row">
      <div class="col">
        <FormSelect label="Lista Utenti"
                    name="userIds"
                    v-model="formData.userIds"
                    multiple
                    search
        />
      </div>
      <div class="col">
        <FormSelect label="Lista Ruoli"
                    name="userIds"
                    v-model="formData.roles"
                    multiple
        />
      </div>
    </div>


    <div class=" d-flex">
      <a :href="cancelHref"
         class="btn btn-outline-secondary me-3"
         type="reset">{{ cancelText }}</a>
      <button class="btn btn-success"
              type="submit">{{ submitText }}
      </button>
    </div>
  </form>
</template>

<script>

import { defineComponent, ref } from 'vue'

export default defineComponent({
  name: 'NewsletterListFormUpsert',
  props: {
    newsletterList: Object,
    action: String,
    cancelHref: { type: String },
    cancelText: { type: String, default: 'Annulla' },
    submitText: { type: String, default: 'Salva' },
    errors: Array
  },
  setup (props) {
    const formData = ref({
      ...props.newsletterList
    })

    return { formData }
  }
})
</script>

<style scoped>

</style>
