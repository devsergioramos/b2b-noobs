<template>

  <div>

    <Header />

      <b-container fluid class="p-5 margin-header">

        <b-row class="my-5">

          <h2>Aqui é Site</h2>

           <router-view></router-view>

        </b-row>

      </b-container>

    <Footer />
  </div>

</template>

<script>

import Header from '@/components/Header.vue'
import Footer from '@/components/Footer.vue'

export default {
  name: 'Site',
  components: {
    Header,
    Footer
  }
}
</script>
