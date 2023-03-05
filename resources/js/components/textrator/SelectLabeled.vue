<template>
  <div>
    <label
      
      :for="selectId"
    >
      {{ labelName }}
    </label>
    <div>
      <AppSelect
        :id="selectId"
        :optionList = "optionList"
        @select="$emit('select', $event)"
      />
    </div>
  </div>
</template>

<script>
import AppSelect from './AppSelect'

export default {
  name: 'SelectLabeled',
  components: {
    AppSelect
  },
  props: {
    selectId: {
      type: String,
      required: true
    },
    labelName: {
      type: String
    },
    value: [String, Number, Boolean],
    optionList: {
      type: Array
    }
  }
}
</script>

<style scoped>
.select-labeled {
  display: flex;
}
.cell {
  flex: 1;
}
.left {
  text-align: right;
}
.right {
  text-align: left;
}
</style>
