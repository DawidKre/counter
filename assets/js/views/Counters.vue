<template>
  <v-app>
    <v-content>
      <nav-bar></nav-bar>
      <v-container>
        <v-layout wrap>
          <v-flex xs12 mb-5>
            <alert-error :message="error.message" v-if="error.show"/>
            <h2>Counters list</h2>
            <v-data-table
              :headers="headers"
              :items="counters"
              :pagination.sync="pagination"
              :total-items="totalCounters"
              :loading="loading"
              :rows-per-page-items="rowsPerPageItems"
              class="elevation-1"
            >
              <template slot="items" slot-scope="props">
                <td class="text-xs-left">{{ props.item.name }}</td>
                <td class="text-xs-left">{{ getDateFromItem(props.item.time) }}</td>
                <td class="text-xs-left text-xs-center"><i :class="`material-icons ${getFinishedIcon(props.item.time)}`">{{ getFinishedIcon(props.item.time) }}</i></td>
                <td class="text-xs-center">
                  <v-btn color="info" @click.prevent="showDialog(props.item)">Show</v-btn>
                  <v-btn color="error" @click.prevent="openDeleteCounterDialog(props.item)">Delete</v-btn>
                  <v-btn color="primary" @click="copyScript(props.item)">Copy script</v-btn>
                </td>
              </template>
            </v-data-table>
          </v-flex>
          <v-dialog
            v-model="dialog.show"
            max-width="530px"
          >
            <v-card>
              <v-card-title class="headline">{{ dialog.title }}</v-card-title>
              <v-card-text class="text-xs-center">
                <iframe  frameBorder="0" scrolling="no" style="width:100%; height:100%; overflow:hidden; margin: 0 auto" :src="dialog.script"></iframe>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="green darken-1"
                  flat="flat"
                  @click="dialog.show = false"
                >
                  Close
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
          <v-dialog
            v-model="dialogDelete"
            max-width="530px"
          >
            <v-card>
              <v-card-title class="headline">Are you sure want to delete this counter ? </v-card-title>
              <v-card-text class="text-xs-center">
                <iframe  frameBorder="0" scrolling="no" style="width:100%; height:100%; overflow:hidden; margin: 0 auto" :src="dialog.script"></iframe>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                  color="green darken-1"
                  flat="flat"
                  @click="dialogDelete = false"
                >
                  Disagree
                </v-btn>

                <v-btn
                  color="green darken-1"
                  flat="flat"
                  @click="deleteDialog()"
                >
                  Agree
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
  import NavBar from '../components/NavBar'
  import AlertError from '../components/AlertError'

  export default {
    name: 'Counters',
    components: {
      NavBar, AlertError
    },
    data () {
      return {
        dialogDelete: false,
        script: '',
        dialog: {
          show: false,
          title: '',
          id: null
        },
        error: {
          message: '',
          show: false
        },
        rowsPerPageItems: [5, 10, 25, 100],
        totalCounters: 0,
        lastPage: 0,
        loading: true,
        pagination: {
          rowsPerPage: 10,
          descending: false,
          page: 1,
          sortBy: 'id',
          totalItems: 0,
        },
        counters: [],
        headers: [
          {text: 'Name', value: 'name',sortable: false},
          {text: 'Countdown to', value: 'time',sortable: false},
          {text: 'Finished', value: 'finished',sortable: false, align: 'center'},
          {text: 'Actions', value: 'actions', sortable: false, align: 'center'},
        ],
      }
    },
    watch: {
      pagination: {
        handler() {
          this.getCounters()
        },
        deep: true
      },
    },
    activated() {
      this.getCounters()
    },
    methods: {
      getFinishedIcon(timestamp) {
        let counterTime = new Date(timestamp * 1000)
        let now = new Date()
        let difference = counterTime - now

        if(difference > 0 ) {
          return 'timelapse'
        }

        return 'check_circle_outline'
      },
      copyScript(item) {
        this.$copyText(`<img src="${`${this.axios.defaults.baseURL}/script/identifier/${item.identifier}`}">`).then(function (e) {
          alert('Copied')
        }, function (e) {
          alert('Can not copy')
        })
      },
      openDeleteCounterDialog(item) {
        this.dialogDelete = true
        this.dialog.script = `${this.axios.defaults.baseURL}/script/identifier/${item.identifier}`
        this.dialog.id = item.id
      },
      deleteDialog() {
        this.dialogDelete = false
        this.$http.delete(`api/counters/${this.dialog.id}`).then(() => {
          this.dialogDelete = false
          this.getCounters()
        })
      },
      showDialog(item) {
        this.dialog.show = true
        this.dialog.title = item.name
        this.dialog.script = `${this.axios.defaults.baseURL}/script/identifier/${item.identifier}`
      },
      getDateFromItem(timestamp) {
        let date = new Date(timestamp*1000).toLocaleDateString()
        let time = new Date(timestamp*1000).toLocaleTimeString()

        return date + ' ' + time
      },
      getCounters() {
        this.loading = true
        this.$http.get(`api/counters?itemsPerPage=${this.pagination.rowsPerPage}&page=${this.pagination.page}`)
          .then((response) => {
            this.counters = response.data['hydra:member']
            this.totalCounters = response.data['hydra:totalItems']
          })
          .catch(error => {
            this.error.show = true
            this.error.message = 'Error with server'
          })
          .finally(() => {
            this.loading = false
          })
      },
    }
  }
</script>

<style>
.timelapse {
  color: red;
}
.check_circle_outline {
  color: green;
}
</style>
