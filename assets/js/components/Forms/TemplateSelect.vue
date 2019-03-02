<template>
    <v-autocomplete
      v-model="template"
      :items="templates"
      :readonly="!isEditing"
      @change="selectionChanged"
      :deletable-chips="true"
      label="Select template"
      item-text="name"
      item-value="image"
      persistent-hint
      :clearable="true"
    >
      <v-slide-x-reverse-transition
        slot="append-outer"
        mode="out-in"
      >
      </v-slide-x-reverse-transition>
    </v-autocomplete>
</template>
<script>
  export default {
    name: 'TemplateSelect',
    data () {
      return {
        isEditing: true,
        templates: [],
        template: null
      }
    },
    mounted() {
      this.getCountriesList()
    },
    methods: {
      selectionChanged() {
        this.$emit('select-template', this.template)
      },
      getCountriesList() {
        this.axios
          .get('/templates')
          .then((response) => {
            this.templates = response.data['hydra:member']
          })
      }
    },
  }
</script>
