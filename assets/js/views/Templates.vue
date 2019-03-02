<template>
  <v-app>
    <v-content>
      <nav-bar></nav-bar>
      <v-form>
        <v-container>
          <v-layout row wrap>
            <template-color-select :element="header" :label="'Header'" :withActive="true"/>
            <template-color-select :element="body" :label="'Body'"/>
            <template-color-select :element="footer" :label="'Footer'"/>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs5 mt-2>
              <v-text-field
                type="number"
                v-model="width"
                label="Counter width in pixels"
              />
            </v-flex>
          </v-layout>
          <v-layout row wrap>
            <v-flex xs10 mt-5>
              <div v-if="header.active" :style="{ backgroundColor: header.color.hex, height: getPixelsString(header.height), width: getPixelsString(width)}"></div>
              <div :style="{ backgroundColor: body.color.hex, height: getPixelsString(body.height), width: getPixelsString(width)}"></div>
              <div :style="{ backgroundColor: footer.color.hex, height: getPixelsString(footer.height), width: getPixelsString(width)}"></div>
            </v-flex>
            <v-flex xs2 mt-5>

            </v-flex>
          </v-layout>
        </v-container>
      </v-form>
    </v-content>
  </v-app>
</template>

<script>
  import NavBar from '../components/NavBar'
  import {Swatches} from 'vue-color'
  import TemplateColorSelect from "./TemplateColorSelect";

  export default {
    name: 'Templates',
    components: {
      TemplateColorSelect,
      NavBar, Swatches
    },
    data () {
      return {
        width: 600,
        header: {
          height: 50,
          color: {
            hex: '#74baea',
          },
          active: true
        },
        body: {
          height: 100,
          color: {
            hex: '#0b2116',
          },
        },
        footer: {
          height: 50,
          color: {
            hex: '#b6000d',
          }
        },
      }
    },
    methods: {
      getPixelsString(value){
        return `${value}px`
      }
    },
    computed: {

    }
  }
</script>
<style>
  .vc-chrome-toggle-btn {
    display: none;
  }
</style>