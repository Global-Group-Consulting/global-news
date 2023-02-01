<template>
  <div class="mb-3">
    <label :for="name + 'Input'" class="form-label">
      {{ label }}
    </label>

    <textarea type="text"
              class="form-control tinymce" :class="{'is-invalid': error}"
              :id="name + 'Input'"
              :name="name"
              v-html="modelValue"
              @input="$emit('update:modelValue', $event.target.value)"/>

    <span class="invalid-feedback" role="alert" v-if="error">
        <strong>{{ error.message }}</strong>
    </span>
  </div>

</template>

<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
  name: 'FormTextEditor',
  props: {
    label: String,
    name: String,
    modelValue: String,
    disabled: Boolean,
    errors: Array
  },
  setup (props) {
    const error = computed(() => {
      return props.errors && props.errors.find(er => er.key === props.name)
    })

    return {
      error
    }
  }
})
</script>

<style scoped>

</style>
