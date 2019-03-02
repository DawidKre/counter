<template>
  <v-app>
    <v-content>
      <nav-bar></nav-bar>
  <v-container>
    <v-layout wrap>
      <v-flex xs6 mb-5>
        <v-date-picker :landscape="true" :min="min" :max="max" v-model="date" ></v-date-picker>
      </v-flex>
      <v-flex xs6 mb-5>
        <v-time-picker format="24hr" v-model="time" :landscape="true"></v-time-picker>
      </v-flex>
      <v-flex xs6 mb-5>
        <h3 class="mb-3">Text Color</h3>
        <Swatches v-model="textColors"/>
      </v-flex>
      <v-flex xs3 mt-3>
        <v-layout row wrap>
          <v-flex xs12>
            <template-select @select-template="selectTemplate"/>
          </v-flex>
          <v-flex xs12>
            <font-select @select-font="selectFont"/>
          </v-flex>
          <v-flex xs12>
            <v-text-field
              type="number"
              v-model="counterOptions.fontSize"
              label="Font Size"
              required
            />
          </v-flex>
          <v-flex xs12>
            <v-text-field
              type="number"
              v-model="counterOptions.offset"
              label="Offset"
              required
            />
          </v-flex>
        </v-layout>
      </v-flex>

      <h2>{{ iframeSrc() }}</h2>
      <code style="min-height: 100px">{{ counterScript() }}</code>

      <iframe  frameBorder="0" scrolling="no" style="width:100%; height:100%; overflow:hidden;" :src="iframeSrc()"></iframe>
    </v-layout>
  </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import CreateCounters from '../components/CreateCounters'
  import TemplateSelect from '../components/Forms/TemplateSelect'
  import FontSelect from '../components/Forms/FontSelect'
  import NavBar from '../components/NavBar'
  import { Swatches } from 'vue-color'

  export default {
    name: 'Home',
    components: {
      CreateCounters, NavBar, Swatches, TemplateSelect, FontSelect
    },
    data () {
      return {
        min: new Date().toISOString().substr(0, 10),
        max: new Date(new Date().setFullYear(new Date().getFullYear() + 1)).toISOString().substr(0, 10),
        date: new Date(new Date().getTime() + (24 * 60 * 60 * 1000)).toISOString().substr(0, 10),
        time:  new Date().toLocaleTimeString().replace(/:\d+ /, ' '),
        bgColors: {
          hex: '#74baea',
        },
        textColors: {
          hex: '#0b2116',
        },
        countersColors: {
          hex: '#b6000d',
        },
        counterOptions: {
          offset: 10,
          fontSize: 40,
          template: 'countdown.png',
          font: 'DIGITALDREAM',
        }
      }
    },
    methods: {
      selectTemplate(template) {
        this.counterOptions.template = template
      },
      selectFont(font) {
        this.counterOptions.font = font
      },
      iframeSrc() {
        let params =  {
          offset: this.counterOptions.offset ? this.counterOptions.offset : null,
          size: this.counterOptions.fontSize ? this.counterOptions.fontSize : null,
          template: this.counterOptions.template ? this.counterOptions.template : null,
          font: this.counterOptions.font ? this.counterOptions.font : null,
        }

        let str = '';
        for (let key in params) {
          if(params[key]) {
            if (str !== "" ) {
              str += "&";
            }
            str += key + "=" + encodeURIComponent(params[key]);
          }
        }

        return `http://counter.local/counters?time=${this.dateInMilliseconds}&color=${this.textColors.hex.substring(1)}&${str}`
        return `http://counter.local/counters?time=${this.dateInMilliseconds}&color=${this.textColors.hex.substring(1)}&template=${this.template}&font=${this.font}&size=${this.fontSize}&offset=${this.offset}`
      },
      counterScript() {
        return `<img style="-webkit-user-select: none;" src="${this.iframeSrc()}">`
      },
    },

    computed: {
      counterTime() {
        return `${this.date} ${this.time}`
      },
      dateInMilliseconds() {
        return Math.trunc(Date.parse(`${this.date} ${this.time}`) / 1000)
      },
    }
  }
</script>
<style></style>