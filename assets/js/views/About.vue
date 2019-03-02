<template>
  <v-app>
    <v-content>
      <nav-bar></nav-bar>
      <v-container>
        <v-layout wrap>
          <v-flex xs6 mb-5>
          </v-flex>
        </v-layout>
        <div style="position:relative; width:100%; height:0px; padding-bottom:56.25%;">
          <iframe  frameBorder="0" scrolling="no" style="position:absolute; left:0; top:0; width:100%; height:100%; overflow:hidden;" src="http://counter.local/counters?time=tomorrow"></iframe>
        </div>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import NavBar from '../components/NavBar'

  export default {
    name: 'Home',
    components: {
      NavBar
    },
    data () {
      return {
      }
    },
  }
</script>

<style>
  .countdown {
    display: flex;
    border-radius: 20px;
  }

  .block {
    display: flex;
    flex-direction: column;
    margin: 20px;
  }

  .text {
    color: #1abc9c;
    font-size: 25px;
    margin-top:10px;
    margin-bottom: 10px;
    text-align: center;
  }

  .digit {
    color: #ecf0f1;
    font-size: 100px;
    margin: 10px;
    text-align: center;
  }
</style>
