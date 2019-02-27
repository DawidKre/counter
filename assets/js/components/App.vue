<template>
  <div>
    <button @click="print">Print</button>
    <div class="row" ref="printMe">
      <h2>{{ now }}</h2>
    </div>
    <img :src="output">
    <h2>Server:</h2>
    <img src="http://counter.local/upload/counter">
  </div>
</template>
<script>
  export default {
    data: () => ({
      title: 'TITLE',
      now: Math.trunc((new Date()).getTime() / 1000),
      output: null
    }),

    methods: {
      print() {
        const el = this.$refs.printMe;
        const options = {
          type: 'dataURL'
        };

        this.$html2canvas(el, options).then(canvas => {
          this.output = canvas
          this.uploadFile();
        });
      },
      uploadFile() {
        const formData = new FormData();
        formData.append('file', this.output);

        this.axios.post('/counter/image-upload',formData, {headers: {
            'Content-Type': 'multipart/form-data'
          }}).then((response) => {
        }).catch((e) => {
        })
      }
    },
    mounted() {
      window.setInterval(() => {
        this.now = Math.trunc((new Date()).getTime() / 1000);
        this.print()
      },1000);
    },
  }
</script>
