<template>
  <div>
    <select class="form-control" @change="$emit('select', $event.target.value)">
      <option selected>-</option>
      <option
        v-for="optionItem in optionList"
        :key="optionItem.id"
        :value="optionItem.id"
      >{{ optionItem.name }}</option>
    </select>
  </div>
</template>

<script>
export default {
  name: 'AppSelect',
  props: {
    optionList: Array
  }
}
</script>

<style scoped>
</style>
