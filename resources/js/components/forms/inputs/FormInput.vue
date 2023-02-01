<template>
  <div class="mb-3">
    <label :for="name + 'Input'" class="form-label">
      {{ label }}
    </label>
    <input :type=" type ?? 'text'"
           class="form-control" :class="{'is-invalid': error}"
           :accept="accept"
           :id="name + 'Input'"
           :name="name"
           :value="modelValue"
           :disabled="disabled"
           @input="$emit('update:modelValue', $event.target.value)"
           v-bind="$attrs"
    >

    <span class="invalid-feedback" role="alert" v-if="error">
        <strong>{{ error.message }}</strong>
    </span>
  </div>

</template>

<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
  name: 'FormInput',
  props: {
    label: String,
    name: String,
    modelValue: String,
    type: String,
    accept: String,
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
