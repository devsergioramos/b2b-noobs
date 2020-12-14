<template>
  <v-row justify="center">

    <v-dialog
      :value="isShowList"
      @outside="close()"
      @input="v => v || close()"
      max-width="70%"
    >

  <v-data-table
    :headers="headers"
    :items="items"    
    class="elevation-1"
    light
    :footer-props="{
      showFirstLastPage: true,
      'items-per-page-text':'item por página'
    }"
    :search="search"
    :custom-filter="filterOnlyCapsText"
    :loading="loading"
  >
    <template v-slot:no-data>
      Sem dados disponiveis
    </template>

    <template v-slot:top>

      <v-toolbar
        flat
        dark
      >
        <v-toolbar-title >Produtos</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>

            <v-icon
              small
              class="mr-2"
              dark
              @click="fetchData()"
            >
              mdi-refresh
            </v-icon>

          <v-spacer></v-spacer>

            <v-icon
              small
              class="mr-2"
              dark
              @click="dialogItem({},'create')"
            >
              mdi-plus
            </v-icon>
       
        
      </v-toolbar>

      <v-text-field
        v-model="search"
        label="Buscar (apenas minusculo)"
        class="mx-4"
      ></v-text-field>

    </template>

    
    <template v-slot:item.admin="{ item }">

      <v-icon
        small
        class="mr-2"
        v-if="item.is_admin"
      >
        mdi-lock
      </v-icon>

    </template>

    <template v-slot:item.actions="{ item }">

      <v-icon
        small
        class="mr-2"
        @click="dialogItem(item,'edit')"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        small
        @click="dialogItem(item,'show')"
      >
        mdi-eye
      </v-icon>
      <v-icon
        small
        @click="dialogItem(item,'delete')"
      >
        mdi-delete
      </v-icon>

    </template>
    
  </v-data-table>

          <v-spacer></v-spacer>
          <v-btn
            color="gray darken-1"
            @click="close()"
          >
            Fechar
          </v-btn>

    </v-dialog>
  </v-row>
</template>

<script>



  import { mapGetters, mapState } from "vuex";

  export default {

    data () {
      return {
        search: '',
      }
    },
    created () {
     
    },
    beforeDestroy(){
 
    },
    mounted() {
   
    },
    components: {

    },
    computed: {
      ...mapState({
        isNew: state => state.product.create,
        isEdit: state => state.product.edit,
        isShow: state => state.product.show,
        isShowList: state => state.product.showList,
        loading: state => state.config.loading,
      }),
      ...mapGetters({
        items: "product/items",
        item: "product/item",
        hasItemForm: "product/hasItemForm",
        dataItem: "product/itemForm",
        itemSelected: "product/itemSelected",
      }),
      headers () {
        return [
          { text: '#', value: 'id' },
          { text: 'Nome', value: 'name' },
          { text: 'Preço', value: 'price' },
          { text: 'Categoria', value: 'category' },
          { text: 'Opções', value: 'actions', sortable: false },          
        ]
      },
    },
    methods: {
      filterOnlyCapsText (value, search, item) {
        return value != null &&
          search != null &&
          typeof value === 'string' &&
          value.toString().toLocaleLowerCase().indexOf(search) !== -1
      },
      async fetchData() {

        this.$store.dispatch('product/fetchItems');

      },
      close () {

        this.$store.dispatch('product/showList',false);
        
      },
      dialogItem (item, mode) {  
        
        this.$store.dispatch('product/'+mode);

        this.$store.dispatch('product/item',Object.assign({}, item));  
        this.$store.dispatch('product/indexItem',this.items.indexOf(item));
      },

    },
    watch: {
      isShowList (val) {

        if(this.isShowList) this.fetchData()           
          
      }
    },
  }
</script>
<style>

tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, .05);
}

</style>