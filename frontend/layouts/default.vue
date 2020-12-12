<template>
 <v-app >

    <v-navigation-drawer left app v-if="sidebarLeft" mobile-breakpoint="650" 
    dark style="background-color:#8f8f90">

  <v-card
    class="mx-auto"
    max-width="344"
    outlined
  >
    <v-list-item three-line>

      <v-list-item-avatar
        tile
        size="80"
      >
      <v-img
        :src="require('assets/images/logo.jpg')"
      ></v-img>
      </v-list-item-avatar>

      <v-list-item-content>

        <!--
        <v-list-item-title class="headline mb-1">
          *
        </v-list-item-title>
        -->
        <v-list-item-subtitle>{{projectName}}</v-list-item-subtitle>
        <div class="overline mb-2">

        Bem vindo

        </div>
      </v-list-item-content>

    </v-list-item>

  </v-card>


  <v-card
    class="mx-auto"
    max-width="344"
    light
  >

        <v-list>
          <v-list-item-group
            active-class="border"
            color="indigo"
            >                  
   
          <NuxtLink to="/dashboard">
            <v-list-item>
              <v-list-item-icon>
                <v-icon v-text="'mdi-adjust'"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="'Dashboard'"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </NuxtLink>

          <NuxtLink to="/produtos">
            <v-list-item>
              <v-list-item-icon>
                <v-icon v-text="'mdi-sitemap'"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="'Produtos'"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </NuxtLink>
   

          <NuxtLink to="/categorias">
            <v-list-item>
              <v-list-item-icon>
                <v-icon v-text="'mdi-table'"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="'Categorias'"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </NuxtLink>

          <NuxtLink to="/">
            <v-list-item>
              <v-list-item-icon>
                <v-icon v-text="'mdi-arrow-expand-all'"></v-icon>
              </v-list-item-icon>
              <v-list-item-content>
                <v-list-item-title v-text="'Página do Site'"></v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </NuxtLink>
      
            

          </v-list-item-group>
        </v-list>

   



  </v-card>
     
   </v-navigation-drawer>



   <v-app-bar app>   
     
     <v-app-bar-nav-icon @click="sidebar()"></v-app-bar-nav-icon>  

     <v-toolbar-title>{{projectName}}</v-toolbar-title>
  
     
<!--
      <v-tooltip right>
        <template v-slot:activator="{ on, attrs }">
          <v-btn 
            icon 
            class="mx-1" 
            @click="exit"
            v-bind="attrs"
            v-on="on"
            >
            <v-icon>mdi-exit-to-app</v-icon>
          </v-btn>
        </template>
        <span>Sair</span>
      </v-tooltip>
-->


     <v-spacer></v-spacer>
   </v-app-bar>
 
   <v-main light style="background-color:#fff">
     <v-container fluid style="height: 100%">

       <nuxt />

     </v-container>
   </v-main>

   <Loading />

 </v-app>
</template>
 
<script>

import { mapState, mapMutations, mapActions, mapGetters } from "vuex";

import Loading from "@/components/loading";
import ENV from '@/env';

 
export default {
 data: () => ({
    time: '',
    date: '',
    projectName: ENV.projectName
 }),
  components: {   
    Loading
   },
 computed: {  
      ...mapState({
        sidebarLeft: state => state.config.sidebarLeft
      }),
    ...mapGetters({
      isAuthenticated: "isAuthenticated",
      loggedInUser: "loggedInUser"
    })
 },
  watch: {

  },

 methods: {
    exit() {
      //this.$auth.logout();
      this.$router.push("/logout");
    },
    sidebar(){
      if(this.sidebarLeft) 
        this.$store.dispatch('config/sidebarLeft',false)
      else
        this.$store.dispatch('config/sidebarLeft',true)
    },
    updateTime() {      

      setInterval(function(){

          var week = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];

          var cd = new Date();
          this.time = this.zeroPadding(cd.getHours(), 2) + ':' + this.zeroPadding(cd.getMinutes(), 2) + ':' + this.zeroPadding(cd.getSeconds(), 2);
          this.date = this.zeroPadding(cd.getFullYear(), 4) + '-' + this.zeroPadding(cd.getMonth()+1, 2) + '-' + this.zeroPadding(cd.getDate(), 2) + ' ' + week[cd.getDay()];
    
      }.bind(this), 1000);

   },
    zeroPadding(num, digit) {
        var zero = '';
        for(var i = 0; i < digit; i++) {
            zero += '0';
        }
        return (zero + num).slice(-digit);
    },
 },
 created() {
    var timerID = setInterval(this.updateTime, 1000);
    this.updateTime();
 },
  mounted(){
   
    if(this.$nuxt.$route.path == '/')
      this.$store.dispatch('config/sidebarLeft',false)
    else 
      this.sidebar();
 }
};
</script>
<style scoped>
.v-application {
  background-color: #fff;
}
.theme--dark.v-application {
  background-color: var(--v-background-base, #121212) !important;
}
.theme--light.v-application {
  background-color: var(--v-background-base, white) !important;
}
.border {
  border: 2px dashed orange;
}
a {  text-decoration: none;}
</style>
