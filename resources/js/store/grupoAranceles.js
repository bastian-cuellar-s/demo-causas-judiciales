export default {
    namespaced: true,
    state: {
        grupo_aranceles: [],
        pagination: [],
    },
    mutations: {
        //paginacion para aranceles
        PAGINATION(state, payload) {
            state.pagination.current_page = payload;
        },
        INCREMENT_PAGINATION(state) {
            state.pagination.current_page++;
        },
        DECREMENT_PAGINATION(state) {
            state.pagination.current_page--;
        },
        //Mutations para grupo de aranceles
        SET_GRUPO_ARANCELES(state, payload) {
            state.grupo_aranceles = payload.data.data;
            state.pagination = payload.pagination;
        },
        ADD_GRUPO_ARANCEL(state, payload) {
            let grupo_aranceles = state.grupo_aranceles.concat(payload);
            state.grupo_aranceles = grupo_aranceles;
        },
        EDIT_GRUPO_ARANCEL(state, payload) {
            let payloadx = payload;
            state.grupo_aranceles = state.grupo_aranceles.map(x => (x.id === payloadx.id) ? payloadx : x);
        },
        DELETE_GRUPO_ARANCEL(state, payload){
            let grupo_aranceles = state.grupo_aranceles.filter(p => p.id != payload)
            state.grupo_aranceles = grupo_aranceles;
        },
    },
    actions: {
        //Actions para los aranceles del cliente 
        async loadAll({commit}, payload){
            let response = await axios.get('api/grupoAranceles/');
            let aranceles = response.data.data;
            commit('SET_GRUPO_ARANCELES', aranceles);
        },
        //Actions para Grupo aranceles
        async searchGrupoArancel({commit}, payload){
            let response = await axios.post('/api/grupoAranceles/search', payload);
             let grupoAranceles = response.data;
            commit('SET_GRUPO_ARANCELES', grupoAranceles);
        },
        async create({commit}, arancel) {
            let response = await axios.post('api/grupoAranceles', arancel);
            let savedGrupoArancel = response.data.data;
            commit('ADD_GRUPO_ARANCEL', savedGrupoArancel);
            return response;
        },
        async edit({commit}, arancel) {
            let response = await axios.put(`api/grupoAranceles/${arancel.id}`, arancel);
            let newGrupoArancel = response.data.data;
            commit('EDIT_GRUPO_ARANCEL', newGrupoArancel);
            return response;
        },
        async delete({commit}, arancel) {
            let response = await axios.delete(`api/grupoAranceles/${arancel}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_GRUPO_ARANCEL', arancel);
            }
        },
        //Actions para paginacion
        incrementPagination({commit}) {           
            commit('INCREMENT_PAGINATION');              
        },
        decrementPagination({commit}) {           
                commit('DECREMENT_PAGINATION');            
        },
        pagination({commit}, payload) {                       
                commit('PAGINATION', payload);                        
        },
    }
};