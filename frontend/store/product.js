export const state = () => ({
    items: [],
    item: {},
    indexItem: -1,
    edit: false,
    create: false,
    show: false,    
    delete: false,
    showList: false,
    form: false
  });
  
  export const getters = {
    items(state) {
      return state.items
    },
    item(state) {
      return state.item
    },
    indexItem(state) {
      return state.indexItem
    },
    itemSelected(state) {
      return Object.keys(state.item).length > 0 ? true : false
    },
    hasItem(state) {
      return Object.keys(state.item).length > 0 ? true : false
    },
  };
  
  export const mutations = {
    SET_ITEMS(state,payload) {
      state.items = payload
    },
    STORE(state,payload) {
      state.items.push(payload) 
    },
    UPDATE(state) {
      Object.assign(state.items[state.indexItem], state.item) 
    },
    REMOVE(state) {
      state.items.splice(state.indexItem, 1)
    },
    SET_ITEM(state,payload) {

      state.item = payload
    },
    SET_INDEX_ITEM(state,payload) {
      state.indexItem = payload
    },
    SET_CREATE(state) {
      state.create = true
      state.edit = false
      state.show = false
      state.indexItem = -1
      state.form = true
    },
    SET_EDIT(state) {
      state.create = false
      state.edit = true
      state.show = false
      state.form = true
    },
    SET_SHOW(state) {
      state.create = false
      state.edit = false
      state.show = true      
    },
    SET_DELETE(state, payload) {
      state.delete = payload;
    },
    SET_SHOW_LIST(state, show) {
      state.create = false
      state.edit = false
      state.show = false
      state.showList = show
    },
    FETCH_ITEMS (state, payload) {      

      state.items = payload

    },
    SET_RESET(state) {
      state.create = false
      state.edit = false
      state.show = false   
      state.form = false
    },
  };
  
  export const actions = {

    async fetchItems({ commit }, payload = {}) {

      this.commit("config/SET_LOADING", true)

      const items = await this.$axios.$get('/api/produto').then(response => {
      
        if(response.status){  

          this.commit("config/SET_LOADING", false)
          
          return response.items  
          
        }else{

          this.$toast.error(response.msg,{
            position:'top-right',
            duration:3000,
            keepOnHover:true
          })

          return []

        }                  
         
      }).catch(error => {

        this.$toast.error(error.message,{
          position:'top-right',
          duration:3000,
          keepOnHover:true
        })

      });

      commit("FETCH_ITEMS", items)
    },
    items({ commit }, payload) {
    
      commit("SET_ITEMS", payload)
    },
    item({ commit }, payload) {
    
      commit("SET_ITEM", payload)
    },
    indexItem({ commit }, payload) {
    
      commit("SET_INDEX_ITEM", payload)
    },
    create({ commit }) {
    
      commit("SET_CREATE")
    },
    edit({ commit }) {
      
      commit("SET_EDIT")
    },
    show({ commit }) {
    
      commit("SET_SHOW")
    },
    reset({ commit }) {
    
      commit("SET_RESET")
    },
    delete({ commit }, payload = true) {
    
      commit("SET_DELETE", payload)
    },
    showList({ commit }, show) {
    
      commit("SET_SHOW_LIST", show)
    }, 
    async store({ commit }, item) {
    
      this.commit("config/SET_LOADING", true)
    
      await this.$axios.$post('/api/produto',item).then(response => {
        
        if(response.status){

          this.commit("config/SET_LOADING", false)  
                   
          commit("STORE",response.item)
          
          this.$toast.success(response.msg,{
            position:'top-right',
            duration:3000,
            keepOnHover:true
          })
          
          commit("SET_RESET")          

        }else{

          this.$toast.error(response.msg,{
            position:'top-right',
            duration:3000,
            keepOnHover:true
          })
        }   

      }).catch(error => {

        this.$toast.error(error.message,{
          position:'top-right',
          duration:3000,
          keepOnHover:true
        })

      }); 
    },
    async update({ commit }, item) {
 
      if(Object.keys(item).length > 0 && item.id != undefined) {  
        
        this.commit("config/SET_LOADING", true)

        const config = {
            headers: { 'content-type': 'multipart/form-data' }
        }      

        let formData = new FormData()
        formData.append("id", item.id)
        formData.append("image", item.image)
        formData.append("name", item.name)
        formData.append("price", item.price)
        formData.append("status", item.status)
        formData.append("category_id", item.category_id)
        formData.append('_method', 'PATCH')   
        
        await this.$axios.$post('/api/produto/'+item.id, formData).then(response => {
      
          if(response.status){ 

            item.image = response.item.image
            
            this.commit("config/SET_LOADING", false)

            commit("SET_ITEM", item)

            commit("UPDATE")   
            
            this.$toast.success(response.msg,{
              position:'top-right',
              duration:3000,
              keepOnHover:true
            })

            commit("SET_RESET")
            
          }else{

            this.$toast.error(response.msg,{
              position:'top-right',
              duration:3000,
              keepOnHover:true
            })
          }   

        }).catch(error => {

          this.$toast.error(error.message,{
            position:'top-right',
            duration:3000,
            keepOnHover:true
          })

        });
      }else{

        console.log(item)

        this.$toast.error('Item não enviado para salvar ou Codigo do item não informado!',{
          position:'top-right',
          duration:3000,
          keepOnHover:true
        })  

      }
     
    },
    async deleteItem({ commit }, item) {
    
      if(Object.keys(item).length > 0 && item.id != undefined) { 

        this.commit("config/SET_LOADING", true)

        await this.$axios.$delete('/api/produto/'+item.id).then(response => {
         
          if(response.status){  

            this.commit("config/SET_LOADING", false)

            commit("REMOVE")  

            this.$toast.success(response.msg,{
              position:'top-right',
              duration:3000,
              keepOnHover:true
            })

            commit("SET_DELETE", false)
            
          }else{

            this.$toast.error(response.msg,{
              position:'top-right',
              duration:3000,
              keepOnHover:true
            })
          }   

        }).catch(error => {

          this.$toast.error(error.message,{
            position:'top-right',
            duration:3000,
            keepOnHover:true
          })

        });
      }else{

        console.log(item)

        this.$toast.error('Item não enviado para deletar ou Codigo do item não informado!',{
          position:'top-right',
          duration:3000,
          keepOnHover:true
        })  

      }
    },
  };

  export const strict = false