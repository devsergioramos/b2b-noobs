export const state = () => ({
    loading: false,
    sidebarLeft: false
  });
  
  export const getters = {
    isLoading(state) {
      return state.loading
    },
    isSidebarLeft(state) {
      return state.sidebarLeft
    },
  };
  
  export const mutations = {
    SET_LOADING(state, payload) {
      state.loading = payload;
    },  
    SET_SIDEBAR(state, payload) {
      state.sidebarLeft = payload;
    },  
  };
  
  export const actions = {
    loading({ commit }, payload) {
    
      commit("SET_LOADING", payload);
    },
    sidebarLeft({ commit }, payload) {
    
      commit("SET_SIDEBAR", payload);
    },
  };

  export const strict = false