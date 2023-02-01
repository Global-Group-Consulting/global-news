<template>
  <div class="mb-3">
    <label :for="name + 'Select'" class="form-label">
      {{ label }}
    </label>

    <template v-if="!multiple">
      <select class="form-select" :class="{'is-invalid': error}"
              :id="name + 'Select'"
              :name="name"
              :value="modelValue"
              :disabled="disabled"
              @input="$emit('update:modelValue', $event.target.value)"
              v-bind="$attrs"
      >
        <option value=""></option>
        <option :value="option[optionValue]" v-for="option in options" :key="'opt_' + option[optionValue]">
          {{ option[optionLabel] }}
        </option>
      </select>
    </template>
    <!-- DROPDOWN -->
    <template v-else>
      <div class="dropdown">
        <button class="form-select text-start text-truncate" :class="{'is-invalid': error}"
                type="button"
                :id="name + 'Select'"
                data-bs-toggle="dropdown"
                data-bs-auto-close="outside"
                aria-expanded="false">
          Dropdown
        </button>

        <ul class="dropdown-menu" :aria-labelledby="name + 'Select'">
          <div v-if="search" class="mb-3 search-input">
            <input type="text" class="form-control border-start-0 border-end-0 rounded-0 clearable"
                   placeholder="Cerca...">
            <button class="clear-btn" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width="14px" height="14px">
                <path fill="currentColor"
                      d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/>
              </svg>

            </button>
          </div>

          <li>
            <button class="dropdown-item" type="button" data-dd-action="none">Nessuna</button>
          </li>
          <li>
            <button class="dropdown-item" type="button" data-dd-action="all">Tutte</button>
          </li>

          <li>
            <hr class="dropdown-divider">
          </li>

          <li class="dropdown-item"
              v-for="option in options" :key="'opt_' + option[optionValue]">
            <div class="form-check">
              <input class="form-check-input"
                     type="checkbox"
                     :id="`${name}_${option[optionValue]}_option`"
                     :name="name"
                     :value="option[optionValue]"
                     :checked="option[optionValue] === modelValue">
              <label class="form-check-label" :for="`${name}_${option[optionValue]}_option`">
                {{ option[optionLabel] }}
              </label>
            </div>
          </li>
        </ul>
      </div>
    </template>

    <span class="invalid-feedback" role="alert" v-if="error">
        <strong>{{ error.message }}</strong>
    </span>
  </div>

</template>

<script>
import { computed, defineComponent } from 'vue'

export default defineComponent({
  name: 'FormSelect',
  props: {
    label: String,
    name: String,
    modelValue: String,
    type: String,
    accept: String,
    disabled: Boolean,
    errors: Array,
    multiple: Boolean,
    search: Boolean,
    options: Array,
    optionValue: { type: String, default: 'value' },
    optionLabel: { type: String, default: 'text' }
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

<style scoped lang="scss">
.search-input {
  position: relative;

  .form-control.clearable {
    padding-right: calc(1.5em + 0.75rem);
    //background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 320 512'%3E%3Cpath d='M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z'/%3E%3C/svg%3E");
    //background-repeat: no-repeat;
    //background-position: right calc(0.375em + 0.1875rem) center;
    //background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
  }

  .clear-btn {
    position: absolute;
    right: 0;
    top: 0;
    bottom: 0;
    padding: 0.375rem 0.75rem;
    background: transparent;
    border: 0;
    border-radius: 0;
    cursor: pointer;
  }
}
</style>
