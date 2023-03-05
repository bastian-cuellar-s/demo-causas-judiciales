<template>
  <div>
    <a
      class="btn btn-success"
      :href="href"
      :download="download"
      
    >
      <i class="fas fa-download"> {{ text }}</i>
    </a>
  </div>
</template>

<script>
export default {
  name: 'AppAnchor',
  props: {
    text: String,
    href: String,
    download: String
  }
}
</script>

<style scoped>
a.button {
  appearance: button;
  text-decoration: none;
  font-family: monospace;
}
</style>
