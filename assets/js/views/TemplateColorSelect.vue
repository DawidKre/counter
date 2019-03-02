<template>
  <v-flex xs4 mb-3>
    <v-layout row wrap>
      <v-flex xs6 mb-2>
        <h3 class="mb-3">{{ label }} Color</h3>
        <Swatches v-model="element.color"/>
      </v-flex>
      <v-layout row wrap>
        <v-flex xs5 mt-5>
          <v-text-field
            type="number"
            v-model="element.height"
            :label="label+' height in pixels'"
            required
          />
        </v-flex>
        <v-flex xs5 mt-5 pl2 v-if="withActive">
          <v-checkbox v-model="element.active" label="Active"></v-checkbox>
        </v-flex>
      </v-layout>
    </v-layout>
    <v-divider mt-3/>
  </v-flex>
</template>
<script>
  import {Swatches} from 'vue-color'

  export default {
    name: 'TemplateColorSelect',
    components: {
      Swatches
    },
    props: {
      withActive: {
        type: Boolean,
        default: false
      },
      label: {
        type: String,
        default: ''
      },
      element: {
        height: {
          type: Number,
          default: 100
        },
        active: {
          type: Boolean,
          default: true
        },
        color: {
          type: Object,
          default: {
            hex: {
              type: String,
              default: '#000000'
            }
          }
        }
      }
    }
  }
</script>
