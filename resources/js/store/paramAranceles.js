export default {
    namespaced: true,
    state: {
        tipoAranceles: [],
    },
    mutations: {
        //Mutaciones para tipos de aranceles parametizables
        SET_TIPO_ARANCEL(state, payload) {
            state.tipoAranceles = payload;
        },
        ADD_TIPO_ARANCEL(state, payload) {
            let tipoAranceles = state.tipoAranceles.concat(payload);
            state.tipoAranceles = tipoAranceles;
        },
        EDIT_TIPO_ARANCEL(state, payload) {
            let idx = state.tipoAranceles.indexOf(state.tipoAranceles.find(p => {
                p.id === payload.id;
              }));
            console.log(payload);
            state.tipoAranceles.splice(idx, 1, payload);
        },
        DELETE_TIPO_ARANCEL(state, payload){
            let tipoAranceles = state.tipoAranceles.filter(p => p.id != payload)
            state.tipoAranceles = tipoAranceles;
        },
    },
    actions: {
        //Actions para tipos de aranceles parametizables
        async loadAllTipoArancel({commit}){
            let response = await axios.get('api/tipoArancel/');
            let tipoAranceles = response.data.data; 
            commit('SET_TIPO_ARANCEL', tipoAranceles);
        },
        async createTipoArancel({commit}, tipoArancel) {
            let response = await axios.post('api/tipoArancel', tipoArancel);
            let savedTipoArancel = response.data.data;
            commit('ADD_TIPO_ARANCEL', savedTipoArancel);
            return response;
        },
        async editTipoArancel({commit}, tipoArancel) {
            let response = await axios.put(`api/tipoArancel/${tipoArancel.id}`, tipoArancel);
            let newTipoArancel = response.data.data;
            commit('EDIT_TIPO_ARANCEL', newTipoArancel);
            //console.log(newTipoArancel); 
            return newTipoArancel;
        },
        async deleteTipoArancel({commit}, tipoArancel) {
            let response = await axios.delete(`api/tipoArancel/${tipoArancel.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_TIPO_ARANCEL', tipoArancel.id);
            }
        },
    }
};