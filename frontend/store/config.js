export const state = () => ({
    loading: false,
  });
  
  export const getters = {
    isLoading(state) {
      return state.loading
    },
  };
  
  export const mutations = {
    SET_LOADING(state, payload) {
      state.loading = payload;
    },  
  };
  
  export const actions = {
    loading({ commit }, payload) {
    
      commit("SET_LOADING", payload);
    },
  };

  export const strict = false