<template>
  <div>
  <v-row>
    <v-col
      cols="4"
      class="purple--text text-center"
    >
      <h2>Galeria de Produtos</h2>
    </v-col>
    <v-col
      cols="8"
    >
        <v-text-field
        v-model="search"
        placeholder="Buscar"
        style="background:purple;border-radius: 15px;"
    ></v-text-field>
    
    </v-col>
  </v-row>
      
  <v-row>
    <v-col
      v-for="item in filteredList"
      :key="item.id"
      class="d-flex child-flex"
      cols="2"
      v-if="item.image"
    >
    <v-card>  

      <v-img
        :src="urlApi+'/images/products/'+item.image"
        :lazy-src="urlApi+'/images/products/'+item.image"
        aspect-ratio="1"
        class="grey lighten-2"
      >
        <template v-slot:placeholder>
          <v-row
            class="fill-height ma-0"
            align="center"
            justify="center"
          >
            <v-progress-circular
              indeterminate
              color="grey lighten-5"
            ></v-progress-circular>
          </v-row>
        </template>
      </v-img>

        <v-card-title style="font-size:12px;">

          <v-badge
            bordered
            :color="item.category.color"
            overlap
            style="color:black;"
          >
            <v-btn
              x-small
              text
            >
             {{item.name}}
            </v-btn>
          </v-badge>

          

        </v-card-title>
        <v-card-text>

        <p><i style="color:grey;font-size:10px;">{{item.category.name}}</i></p>

        <v-chip class="ma-2" style="font-size:12px;">R$ {{item.price}}</v-chip>

        
    
    
    </v-card-text>

      </v-card>

    </v-col>
  </v-row>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

import ENV from '@/env';

export default {
  data: () => ({
    urlApi: ENV.urlApi,
    search:''
  }),
  components: {

  },
  mounted(){
    this.$store.dispatch('config/sidebarLeft',false)

    this.fetchProducts()   
  },
  computed: {
    ...mapGetters({
      products: "product/items"        
    }),
    filteredList() {
        if(this.search === '') return this.products
        return this.products.filter(product => {
            return product.name.toLowerCase().includes(this.search.toLowerCase()) || product.category.name.toLowerCase().includes(this.search.toLowerCase()) || product.price.includes(this.search)
        })   
    }
  },
  methods:{
    fetchProducts(){
      this.$store.dispatch('product/fetchItems');
    }
  }
}
</script>
<style scoped>


</style>
