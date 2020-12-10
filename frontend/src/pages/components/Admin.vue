<template>

  <div id="app">

    <Header />

      <b-container fluid class="p-5 margin-header">

        <b-row class="my-5">

          <h2>Admin</h2>

        </b-row>

      </b-container>

    <Footer />
  </div>

</template>

<script>

import Header from '../site/components/static/Header.vue'
import Footer from '../site/components/static/Footer.vue'

export default {
  name: 'App',
  components: {
    Header,
    Footer
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
