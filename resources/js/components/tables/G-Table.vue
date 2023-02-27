<template>
  <table class="table table-striped">
    <thead>
    <tr>
      <th scope="col" v-for="column in tableColumns">{{ column['label'] }}</th>
    </tr>
    </thead>
    <tbody>

    <tr v-for="row in data">
      <td v-for="column in tableColumns">

        <slot :name="`cell_${column.name}`" :data="row">
          <template v-if="column['type'] !== 'component'">
            {{ getColumnValue(column, row) }}
          </template>
        </slot>

        <component v-else :is="column['component']"
                   :row="row" :column="column"
                   :id="row.id"
                   v-bind="column.componentProps || {}"></component>
      </td>
    </tr>
    </tbody>
  </table>

  <!--  Pagination-->
  <div class=" d-flex justify-content-center">
    <slot name="pagination"></slot>
  </div>

</template>

<script>

import { computed, defineComponent } from 'vue'
import { DateTime } from 'luxon'

export default defineComponent({
  name: 'G-Table',
  props: {
    data: Array,
    columns: Array
  },
  setup (props) {
    const tableColumns = computed(() => props.columns.map(col => ({
      ...col,
      'type': col['type'] ?? 'text'
    })))

    function getColumnValue (column, row) {
      let toReturn = column['name'] ? row[column['name']] : null

      if (column['type'] === 'date') {
        toReturn = toReturn ? DateTime.fromISO(toReturn).toLocaleString() : ''
      } else if (column['type'] === 'datetime') {
        toReturn = toReturn ? DateTime.fromISO(toReturn).toLocaleString(DateTime.DATETIME_SHORT) : ''
      } else if (column['type'] === 'boolean') {
        toReturn = toReturn ? 'Si' : 'No'
      } else if (column['type'] === 'array') {
        toReturn = toReturn.join(', ')
      }

      return toReturn
    }

    return {
      tableColumns,
      getColumnValue
    }
  }
})
</script>

<style scoped>

</style>
