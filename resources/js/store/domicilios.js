export default {
    namespaced: true,
    state: {
        domicilios: [],
        pagination: [],
        regiones: [],
        comunas: [],
    },
    mutations: {
        SET_DOMICILIOS(state, payload) {
            state.domicilios = payload.data.data;
            state.pagination = payload.pagination;
        },
        PAGINATION(state, payload) {
            state.pagination.current_page = payload;
        },
        INCREMENT_PAGINATION(state) {
            state.pagination.current_page++;
        },
        DECREMENT_PAGINATION(state) {
            state.pagination.current_page--;
        },
        SET_REGIONES(state, payload) {
            state.regiones = payload;
        },
        SET_COMUNAS(state, payload) {
            state.comunas = payload;
        },
        ADD_DOMICILIO(state, payload) {
            let domicilios = state.domicilios.concat(payload);
            state.domicilios = domicilios;
        },
        EDIT_DOMICILIO(state, payload) {
            /*let idx = state.domicilios.indexOf(state.domicilios.find(p => {
                p.id === payload.id;
              }));
            state.domicilios.splice(idx, 1, payload);*/

            let payloadx = payload.data.data;
            state.domicilios = state.domicilios.map(x => (x.id === payloadx.id) ? payloadx : x);
        },
        DELETE_DOMICILIO(state, payload){
            let domicilios = state.domicilios.filter(p => p.id != payload)
            state.domicilios = domicilios;
        },
    },
    actions: { 
        async loadAll({commit}, payload){
            let response = await axios.get('api/domicilios/?page='+ payload.page,{
                params: {
                  persona_id: payload.p_id
                }
             });
            let domicilios = response.data;
            commit('SET_DOMICILIOS', domicilios);
        },
        async searchDomicilio({commit}, payload){
            let response = await axios.post('/api/domicilios/search', payload);
             let domicilios = response.data;
            commit('SET_DOMICILIOS', domicilios);
        },
        async loadAllRegion({commit}){
            let response = await axios.get('api/getRegiones/');
            let regiones = response.data.data;
            commit('SET_REGIONES', regiones);
        },
        async loadAllComunas({commit}, payload){
            let response = await axios.get('api/getComunas/',{
                params: {
                  region_id: payload
                }
             });
            let domicilios = response.data.data;
            commit('SET_COMUNAS', domicilios);
        },
        async create({commit}, domicilio) {
            let response = await axios.post('api/domicilios', domicilio);
            let savedDomicilio = response.data.data;
            commit('ADD_DOMICILIO', savedDomicilio);
            return response;
        },
        async edit({commit}, domicilio) {
            let response = await axios.put(`api/domicilios/${domicilio.id}`, domicilio);
            let newDomicilio = response;
            commit('EDIT_DOMICILIO', newDomicilio);
            return newDomicilio;
        },
        async delete({commit}, domicilio) {
            let response = await axios.delete(`api/domicilios/${domicilio.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_DOMICILIO', domicilio.id);
            }
        },
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