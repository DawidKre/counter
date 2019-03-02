<template>
  <v-toolbar dark color="primary">
    <v-toolbar-title>Counters App</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn to="/" flat>Create Counter</v-btn>
      <v-btn to="/counters" flat>Counters List</v-btn>
      <a class="v-btn v-btn--flat theme--dark" href="/logout">Logout</a>
    </v-toolbar-items>
  </v-toolbar>
</template>

<script>
export default {
  name: "NavBar"
};
</script>

<style scoped></style>
