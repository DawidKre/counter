<template>
  <v-flex
    xs12
    mb-5
    text-xs-center
  >
      <div class="text-xs-center" id="countdown-template">
        <div class="countdown" :style="'background-color:'+ bgColor">
          <div class="block">
            <p class="digit" :style="'color:'+ counterColor">{{ days | twoDigits }}</p>
            <p class="text" :style="'color:'+ textColor">Days</p>
          </div>
          <div class="block">
            <p class="digit" :style="'color:'+ counterColor">{{ hours | twoDigits }}</p>
            <p class="text" :style="'color:'+ textColor">Hours</p>
          </div>
          <div class="block">
            <p class="digit" :style="'color:'+ counterColor">{{ minutes | twoDigits }}</p>
            <p class="text" :style="'color:'+ textColor">Minutes</p>
          </div>
          <div class="block">
            <p class="digit" :style="'color:'+ counterColor">{{ seconds | twoDigits }}</p>
            <p class="text" :style="'color:'+ textColor">Seconds</p>
          </div>
        </div>
      </div>
  </v-flex>
</template>

<script>
  export default {
    name: 'CreateCounters',
    data: () => ({
      title: 'TITLE',
      now: Math.trunc((new Date()).getTime() / 1000),
      date: '2019-02-24 10:53:11',
      bgColor: '#74baea',
      counterColor: '#b6000d',
      textColor: '#0b2116',
    }),
    mounted() {
      window.setInterval(() => {
        this.now = Math.trunc((new Date()).getTime() / 1000);
      },1000);
    },
    computed: {
      dateInMilliseconds() {
        return Math.trunc(Date.parse(this.date) / 1000)
      },
      seconds() {
        return (this.dateInMilliseconds - this.now) % 60;
      },
      minutes() {
        return Math.trunc((this.dateInMilliseconds - this.now) / 60) % 60;
      },
      hours() {
        return Math.trunc((this.dateInMilliseconds - this.now) / 60 / 60) % 24;
      },
      days() {
        return Math.trunc((this.dateInMilliseconds - this.now) / 60 / 60 / 24);
      }
    },
    filters: {
      twoDigits: (value) => {
        if (value < 0) {
          return '00';
        }
        if (value.toString().length <= 1) {
          return `0${value}`;
        }
        return value;
      }
    }
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
