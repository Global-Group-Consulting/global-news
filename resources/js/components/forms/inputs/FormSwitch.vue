<template>
  <div class="mb-3 form-check form-switch">
    <div class="form-label">&nbsp;</div>

    <input class="form-check-input" :class="{'is-invalid': error}"
           type="checkbox" role="switch"
           :id="name + 'Input'"
           :name="name"
           value="1"
           :disabled="disabled"
           v-bind="$attrs"
           :checked="modelValue"
           @input="$emit('update:modelValue', $event.target.checked)"
    >
    <label :for="name + 'Input'" class="form-check-label">
      {{ label }}
    </label>

    <span class="invalid-feedback" role="alert" v-if="error">
        <strong>{{ error.message }}</strong>
    </span>
  </div>

</template>

<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
  name: 'FormSwitch',
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

    return {error}
  }
})
</script>

<style scoped>

</style>
