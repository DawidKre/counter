<template>
    <v-autocomplete
      v-model="template"
      :items="templates"
      :readonly="!isEditing"
      @change="selectionChanged"
      :deletable-chips="true"
      label="Select template"
      persistent-hint
      :clearable="true"
    >
      <template v-slot:selection="data">
          {{ data.item.name }}
      </template>
      <template v-slot:item="data">
        {{ data.item.name }}
      </template>
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
        template: {}
      }
    },
    mounted() {
      this.getCountriesList()
    },
    methods: {
      selectionChanged(template) {
        this.$emit('select-template', this.template)
      },
      getCountriesList() {
        this.axios.get('api/templates').then((response) => {
            this.templates = response.data['hydra:member']
        })
      }
    },
  }
</script>
