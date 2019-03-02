<template>
  <v-alert
    :value="true"
    type="error"
  >
    {{ message }}
  </v-alert>
</template>
<script>
  export default {
    name: 'alert-error',
    props: {
      message: {}
    }
  }
</script>