<template>
  <v-app>
    <v-content>
      <nav-bar></nav-bar>
  <v-container>
    <v-layout wrap>
      <v-flex xs12  lg6 mb-5>
        <v-date-picker :min="min" :max="max" v-model="date" :first-day-of-week="1" ></v-date-picker>
      </v-flex>
      <v-flex xs12 lg6 mb-5>
        <v-time-picker format="24hr" v-model="time"></v-time-picker>
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
              v-model="fontSize"
              label="Font Size"
              required
            />
          </v-flex>
          <v-flex xs12>
            <v-text-field
              type="number"
              v-model="xOffset"
              label="X Offset"
              required
            />
          </v-flex>
          <v-flex xs12>
            <v-text-field
              type="number"
              v-model="yOffset"
              label="Y Offset"
              required
            />
          </v-flex>
          <v-divider></v-divider>
        </v-layout>
      </v-flex>
      <v-layout row class="mt-4">
        <v-flex xs12 md6>
          <iframe  frameBorder="0" scrolling="no" style="width:100%; height:100%; overflow:hidden; margin: 0 auto" :src="iframeSrc()"></iframe>
        </v-flex>
        <v-flex xs6>
          <v-layout row>
            <v-text-field
              v-model="name"
              label="Counter name *"
              required
            />
          </v-layout>
          <v-layout row class="mt-2">
            <v-btn :disabled="!name" color="success" @click="saveCounter">Save Counter</v-btn>
          </v-layout>
        </v-flex>
      </v-layout>
      </v-layout>
  </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import TemplateSelect from '../components/Forms/TemplateSelect'
  import FontSelect from '../components/Forms/FontSelect'
  import NavBar from '../components/NavBar'
  import { Swatches } from 'vue-color'

  export default {
    name: 'CreateCounter',
    components: {
      NavBar, Swatches, TemplateSelect, FontSelect
    },
    data () {
      return {
        min: new Date().toISOString().substr(0, 10),
        max: new Date(new Date().setFullYear(new Date().getFullYear() + 2)).toISOString().substr(0, 10),
        date: new Date(new Date().getTime() + (24 * 60 * 60 * 1000)).toISOString().substr(0, 10),
        time:  new Date().toLocaleTimeString().replace(/:\d+ /, ' '),
        textColors: {
          hex: '#ebebeb',
        },
        name: '',
        xOffset: 10,
        yOffset: 70,
        fontSize: 40,
        template: {
          name: 'Black',
          image: 'countdown.png'
        },
        font: 'DIGITALDREAM',
      }
    },
    methods: {
      selectTemplate(template) {
        this.template = template
      },
      selectFont(font) {
        this.font = font
      },
      iframeSrc() {
        let params = this.getCounterParams();

        let str = ''
        for (let key in params) {
          if(params[key]) {
            if (str !== "" ) {
              str += "&";
            }
            str += key + "=" + encodeURIComponent(params[key])
          }
        }

        return `http://counter.local/script/show?${str}`
      },
      counterScript() {
        return `<img style="-webkit-user-select: none;" src="${this.iframeSrc()}">`
      },
      saveCounter() {
        this.axios.post('/counters',this.getCounterParams()).then((response) => {
          this.$router.push('Counters')
        })
      },
      getCounterParams() {
        return {
          name:  this.name ? this.name : null,
          color: this.textColors.hex.substring(1),
          time: this.dateInMilliseconds,
          xOffset: this.xOffset ? Number(this.xOffset) : null,
          yOffset: this.yOffset ? Number(this.yOffset) : null,
          fontSize: this.fontSize ? Number(this.fontSize) : null,
          templateImage: this.template.image ? this.template.image : null,
          template: this.template['@id'] ? this.template['@id'] : null,
          font: this.font ? this.font : null,
        }
      }
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