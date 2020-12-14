<template>

  <!-- inicio do template -->
        
        <!-- modal form - inicio -->
        <v-dialog
          :value="isEdit || isNew || isShow"
          max-width="500px"
          @outside="close()"
          @input="v => v || close()"
        >
          <v-card>

            <v-form
              ref="form"
              v-model="isValid"
              lazy-validation
              @submit.prevent="submit"
            >

            <v-card-title>
              <span class="headline">{{ dialogTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                    <v-text-field
                      v-model="dataItem.name"
                      label="Nome"
                      :rules="[v => !!v || 'Nome é obrigatório']"
                      :disabled="disabled"
                    ></v-text-field>
                  </v-col>
                </v-row>

                <v-row>
                  <v-col
                    cols="6"
                    sm="6"
                    md="6"
                  >
                  Preço
                    <v-text-field
                      v-model="dataItem.price"
                      type="number"
                      label="Preço"
                      :rules="[v => !!v || 'Preço é obrigatório']"
                      :disabled="disabled"
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="6"
                    sm="6"
                    md="6"
                  >
                  Status
                  <v-select 
                    v-model="dataItem.status"
                    :items="status"
                    :label="'Status'"  
                    :disabled="disabled"
                    item-text="name"
                    item-value="value"
                    persistent-hint
                    return-object
                    single-line
                    @change="changeStatus($event)"
                  ></v-select>
                  </v-col>

                </v-row>

                <v-row>
                 
                  <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                  <v-select 
                    v-model="dataItem.category_id"
                    :items="categories"
                    :label="'Categoria'"  
                    :disabled="disabled"
                    item-text="name"
                    item-value="id"
                    no-data-text="Não possui categorias cadastradas"
                    @change="changeCategory($event)"
                  ></v-select>
                  </v-col>

                </v-row>

                <v-row v-if="isNew || isEdit">              

                   <v-col
                    cols="12"
                    sm="12"
                    md="12"
                  >
                  <v-file-input
                    id="image"
                    truncate-length="15"
                    @change="selectFile($event)"                    
                  ></v-file-input>

                  </v-col>

                </v-row>

                <v-row v-if="isShow || isEdit">             

                   <v-col
                    cols="12"
                    sm="12"
                    md="12"
                    v-if="dataItem.image"
                  >
                  <v-img
                    :lazy-src="urlApi+'/images/products/'+dataItem.image"
                    max-width="100"
                    :src="urlApi+'/images/products/'+dataItem.image"
                  ></v-img>

                  </v-col>

                </v-row>
               

              </v-container>
            </v-card-text>


            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn
                color="blue darken-1"
                text
                @click="close"
              >
                Fechar
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                type="submit"
                v-if="isForm"
              >
                Salvar
              </v-btn>
            </v-card-actions>
            
            </v-form>
          </v-card>
        </v-dialog>
        <!-- modal form - fim -->
  
</template>

<script>

import { mapState, mapMutations, mapActions, mapGetters } from "vuex";
import ENV from '@/env';

  export default {
    props: {

    },
    data () {
      return {
        label: 'Produto',
        isValid: '',
        dataItem:{},
        urlApi: ENV.urlApi,
        status: [
          {
            name:'Pendente',
            value:0
          },
          {
            name:'Ativo',
            value:1
          },
          {
            name:'Finalizado',
            value:2
          },
        ]
      }
    },
    created () {
      
    },
    beforeDestroy(){
    
    },
    updated () {

    },
    mounted () {
    
    },
    computed: {
      ...mapState({
        isNew: state => state.product.create,
        isEdit: state => state.product.edit,
        isShow: state => state.product.show,
        isForm: state => state.product.form,
      }),
      ...mapGetters({
        item: "product/item",//item selecionado
        indexItem: "product/indexItem",
        hasItem: "product/hasItem",
        categories: "category/items"
      }),
      dialogTitle () {

        let mode;
        
        if( this.isNew ) mode = 'Nova';
        if( this.isEdit ) mode = 'Editar';
        if( this.isShow ) mode = 'Visualizar';

        return mode + ' ' + this.label;

      },
      disabled () {
        return this.isShow;
      },
    },
    methods: {

      changeStatus(event){
        this.dataItem.status = event.value;
      },
      changeCategory(event){
        this.dataItem.category_id = event;
      },
      selectFile(event) {
        console.log(event)
        this.dataItem.image = event;
      },
      close () {
        
        this.$store.dispatch('product/reset');
        
      },

      submit () {

        if (this.$refs.form.validate()) {

          let mode = 'update'

          if(this.isNew) mode = 'store'  

          
          
          this.$nextTick(() => {
            this.$store.dispatch('product/'+mode, this.dataItem);      
          })
          
        }
      },
    },
    watch: {
      isForm(val) {

        this.$store.dispatch('category/fetchItems');

        this.dataItem = {
          category: {
            id:'',
            image:''
          }
        };

        if(this.hasItem){

          this.dataItem = {
            name: this.item.name,
            price: this.item.price,
            status: this.item.status,
            image: this.item.image,
            category_id: this.item.category_id
          };

          if(this.item.id!=undefined) this.dataItem.id = this.item.id
        }
      },
      isShow(val) {
        this.dataItem = this.item
      },
      isNew(val) {
          this.dataItem = {
            name: '',
            price: '',
            status: '',
            image: '',
            category_id: ''
          };
      },
    },
  }
</script>
<style>

  tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, .05);
  }

</style>
