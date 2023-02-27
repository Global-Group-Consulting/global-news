<template>
  <form :action="action"
        method="POST"
        enctype="multipart/form-data">

    <slot name="csrf"></slot>

    <div class="row">
      <div class="col">
        <FormInput label="Oggetto"
                   name="subject"
                   v-model="formData.subject"
                   :errors="errors"
        />
      </div>
    </div>

    <div class="row">
      <div class="col">
        <FormSelect label="Lista destinatari"
                    name="list_id"
                    v-model="formData.list_id"
                    :options="lists"
                    option-label="name"
                    option-value="id"
                    :errors="errors"
        />
      </div>
    </div>

    <div class="row">
      <div class="col">
        <FormInput label="Data invio" type="datetime-local"
                   name="scheduled_at"
                   v-model="formData.scheduled_at"
                   :disabled="formData.send_asap"
                   :errors="errors"/>
      </div>
      <div class="col d-flex align-items-center">
        <FormSwitch label="Invio immediato"
                    name="send_asap"
                    v-model="formData.send_asap"
                    :errors="errors"/>
      </div>
    </div>

    <div class="row">
      <div class="col">
        <FormTextEditor label="Contenuto"
                        name="content"
                        v-model="formData.content"
                        :errors="errors"/>
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
  name: 'NewsletterFormUpsert',
  props: {
    newsletter: Object,
    lists: Array,
    action: String,
    cancelHref: { type: String },
    cancelText: { type: String, default: 'Annulla' },
    submitText: { type: String, default: 'Salva' },
    errors: Array
  },
  setup (props) {
    const formData = ref({
      ...props.newsletter
    })

    return { formData }
  }
})
</script>

<style scoped>

</style>
