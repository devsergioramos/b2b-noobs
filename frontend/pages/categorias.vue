<template>
  <div>
 
      <v-divider
        class="mx-2"
        inset
        vertical
      ></v-divider>      
      
  <v-data-table
    :headers="headers"
    :items="data"    
    class="elevation-1"
    light
    :footer-props="{
      showFirstLastPage: true,
      'items-per-page-text':'item por página'
    }"
    :search="search"
    :custom-filter="filterOnlyCapsText"
    :loading="loading"
    v-if="isShowList"
  >
    <template v-slot:no-data>
      Sem dados disponiveis
    </template>

    <template v-slot:top>

      <v-toolbar
        flat
        color="success"
      >

        <v-toolbar-title >        
          <v-icon
          slot="icon"
          color="default"
          size="36"
          class="mr-5"
        >
          mdi-table
        </v-icon>
        Categorias
        </v-toolbar-title>

        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>

        <v-spacer></v-spacer>
        
     <v-badge
        bordered
        color="primary"
        icon="mdi-refresh"
        overlap        
      >
        <v-btn
          class="white--text"
          color="info"
          depressed
          @click="fetchData()"
        >
          Atualizar
        </v-btn>
      </v-badge>
        <v-divider
          class="mx-1"
          inset
          vertical
        ></v-divider>
       

    <v-badge
        bordered
        color="error"
        icon="mdi-plus"
        overlap        
      >
        <v-btn
          class="white--text"
          color="info"
          depressed
          @click="dialogItem({},'create')"
        >
          Nova Categoria
        </v-btn>
      </v-badge>
       
        
      </v-toolbar>


      <v-text-field
        v-model="search"
        label="Buscar (apenas minusculo)"
        class="mx-4"
      ></v-text-field>

 
<!--
      <v-select
          :items="filters"
          label="Filtro"
          @change="filter($event)"
      ></v-select>
-->
    

 

    </template>

    
    <template v-slot:item.status="{ item }">

      {{item.status == 0 ?'Pendente':item.status == 1 ? 'Ativo' : 'Inativo'}}

    </template>

    <template v-slot:item.cor="{ item }">

      <v-chip
        :color="item.color"
      >
      </v-chip>

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
        v-if="Object.keys(item.products).length==0"
      >
        mdi-delete
      </v-icon>

    </template>
    
  </v-data-table>     
     
    <CategoryForm />
    <CategoryDelete />

  </div>
</template>
<script>
  import { mapState, mapActions, mapGetters, mapMutations } from "vuex";

  import CategoryForm from "@/components/category/CategoryForm";
  import CategoryDelete from "@/components/category/CategoryDelete";

  export default {
    data: () => ({
      search:'',
      data:[],
      pesoSelecionado: false,
      alturaSelecionada: false,
      filters: ['Acima do Peso', 'Peso Ideal', 'Abaixo do Peso', 'Pessoas Altas','Pessoas Medianas','Pessoas Baixas',
      'Pessoas Intolerantes a Lactose','Pessoas Atletas'],
      selecteds: []
    }),
    layout: "default",
    components: {
      CategoryForm,
      CategoryDelete,  
    },
    created () {

      

    },
    updated () {
      
    },
    computed: {
      ...mapState({
        isShowList: state => state.category.showList,
        loading: state => state.config.loading,
        isNewCategory: state => state.category.create,
      }),
      ...mapGetters({
        items: "category/items",
      }),

      headers () {
        return [
          { text: '#', value: 'id' },
          { text: 'Nome', value: 'name' },
          { text: 'Status', value: 'status' },
          { text: 'Slug', value: 'slug' },
          { text: 'Cor', value: 'cor' },
          { text: 'Opções', value: 'actions', sortable: false },          
        ]
      },
    },
    watch: {

      
    },

    mounted () {
      this.fetchData()      
    },

    methods: {
      filterOnlyCapsText (value, search, item) {
        return value != null &&
          search != null &&
          typeof value === 'string' &&
          value.toString().toLocaleLowerCase().indexOf(search) !== -1
      },
      fetchData() {

        this.$store.dispatch('category/showList',true);
        this.$store.dispatch('category/fetchItems');

      },
      dialogItem (item, mode) {  
        
        this.$store.dispatch('category/'+mode);

        this.$store.dispatch('category/item',Object.assign({}, item));  
        this.$store.dispatch('category/indexItem',this.items.indexOf(item));
      },
  
    },
    watch: {
     
      items ( val ) {
        this.data = this.items
      }
    },
  }
</script>
<style>
/*
  table {
     table-layout: fixed;
  }*/
</style>
