export default {
    namespaced: true,
    state: {
        aranceles: [],
        pagination: [],
    },
    mutations: {
        //Aranceles correspondientes al cliente
        SET_ARANCELES(state, payload) {
            state.aranceles = payload.data.data;
            state.pagination = payload.pagination;
        },
        ADD_ARANCEL(state, payload) {
            let aranceles = state.aranceles.concat(payload);
            state.aranceles = aranceles;
        },
        ADD_ARANCELES(state, payload) {
                payload.forEach(arancel => {
                    let aranceles = state.aranceles.concat(arancel);
                    state.aranceles = aranceles;
                });
        },
        EDIT_ARANCEL(state, payload) {
            let payloadx = payload.data.data;
            state.aranceles = state.aranceles.map(x => (x.id === payloadx.id) ? payloadx : x);
        },
        DELETE_ARANCEL(state, payload){
            let aranceles = state.aranceles.filter(p => p.id != payload)
            state.aranceles = aranceles;
        },
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
    },
    actions: {
        //Actions para los aranceles del cliente 
        async loadAll({commit}, payload){
            let response = await axios.get('api/aranceles/',{
                params: {
                  persona_id: payload
                }
             });
            let aranceles = response.data.data;
            commit('SET_ARANCELES', aranceles);
        },
        async searchArancel({commit}, payload){
            let response = await axios.post('/api/aranceles/search', payload);
             let aranceles = response.data;
            commit('SET_ARANCELES', aranceles);
        },
        async create({commit}, arancel) {
            let response = await axios.post('api/aranceles', arancel);
            let savedArancel = response.data.data;
            commit('ADD_ARANCEL', savedArancel);
            return response;
        },
        async createExcel({commit}, arancel, config) {
            let response = await axios.post('api/aranceles/createExcel', arancel, config);
            let savedArancel = response.data.data;
            commit('ADD_ARANCELES', savedArancel);
            return response;
        },
        async edit({commit}, arancel) {
            let response = await axios.put(`api/aranceles/${arancel.id}`, arancel);
            let newArancel = response.data.data;
            commit('EDIT_ARANCEL', newArancel);
            return newArancel;
        },
        async delete({commit}, arancel) {
            let response = await axios.delete(`api/aranceles/${arancel}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_ARANCEL', arancel);
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