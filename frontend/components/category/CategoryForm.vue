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
                      value="color"
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
                  Status
                  <v-select 
                    v-model="dataItem.status"
                    :items="status"
                    :label="'Status'"  
                    :disabled="disabled"
                    item-text="name"
                    item-value="value"
                    :rules="[v => !!v || 'Selecione o Status']"
                  ></v-select>
                  </v-col>
                  <v-col
                    cols="6"
                    sm="6"
                    md="6"
                  >
                  Cor
                    
                    <v-chip
                      v-if="dataItem.color"
                      :color="dataItem.color"
                    >
                    </v-chip>
                  </v-col>
                </v-row>  

                <v-row  v-if="isNew || isEdit">
                  <v-col
                    cols="6"
                    sm="6"
                    md="6"
                  >
                  Selecionar Nova Cor
                    <v-color-picker
                      v-model="color"
                      dot-size="25"
                      swatches-max-height="200"
                      :rules="[v => !!v || 'Escola a Cor']"                     
                    ></v-color-picker>
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

  export default {
    props: {

    },
    data () {
      return {
        label: 'Categoria',
        isValid: '',
        dataItem:{},
        color: '',
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
        isNew: state => state.category.create,
        isEdit: state => state.category.edit,
        isShow: state => state.category.show,
        isForm: state => state.category.form,
      }),
      ...mapGetters({
        item: "category/item",//item selecionado
        indexItem: "category/indexItem",
        hasItem: "category/hasItem",
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

      close () {
        
        this.$store.dispatch('category/reset');
        
      },

      submit () {

        if (this.$refs.form.validate()) {

          let mode = 'update'

          if(this.isNew) mode = 'store'  
          
          this.dataItem.color = this.color;

          this.$nextTick(() => {
            this.$store.dispatch('category/'+mode, this.dataItem);      
          })
          
        }
      },
    },
    watch: {
      isForm(val) {

        //this.dataItem = {color:"#FFF"};

        if(this.hasItem){

          this.dataItem = {
            name: this.item.name,
            status: this.item.status,
            color: this.item.color
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
          status: '',
          color: ''
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
