<template>
        <v-dialog
          v-model="loading"
          hide-overlay
          persistent
          width="300"
        >
          <v-card
            color="primary"
            dark
          >
            <v-card-text>
              Aguarde, por favor ..
              <v-progress-linear
                indeterminate
                color="white"
                class="mb-0"
              ></v-progress-linear>
            </v-card-text>
          </v-card>
        </v-dialog>
</template>
<script>
import { mapState } from "vuex";

  export default {
    props: {

    },
    data () {
      return {

      }
    },
    created () {
      
    },
    beforeDestroy(){
    
    },
    updated () {

    },
    computed: {
      ...mapState({
        loading: state => state.config.loading,
      }),
    },
  }
</script>