<template>
    <v-autocomplete
      v-model="font"
      :items="fonts"
      :readonly="!isEditing"
      @change="selectionChanged"
      :deletable-chips="true"
      label="Select font"
      item-text="name"
      item-value="font"
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
    name: 'FontSelect',
    data () {
      return {
        isEditing: true,
        fonts: [
          {name: 'Calibri', font: 'calibri'},
          {name: 'DigitalDream', font: 'DIGITALDREAM'},
          {name: 'Carbon', font: 'carbon'},
          {name: 'Good Times', font: 'goodtimes'},
          {name: 'Homoarak', font: 'HOMOARAK'},
        ],
        font: null
      }
    },
    methods: {
      selectionChanged() {
        this.$emit('select-font', this.font)
      },
    },
  }
</script>
