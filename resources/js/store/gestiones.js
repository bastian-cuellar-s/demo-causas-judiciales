export default {
    namespaced: true,
    state: {
        gestiones: [],
        reporte_gestiones: [],
        pagination: [],
        reporte_pagination: [],
    },
    mutations: {
        //gestiones correspondientes al cliente
        SET_GESTIONES(state, payload) {
            state.gestiones = payload.data.data;
            state.pagination = payload.pagination;
        },
        SET_REPORTE_GESTIONES(state, payload) {
            state.reporte_gestiones = payload.data.data;
            state.reporte_pagination = payload.pagination;
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
        ADD_GESTION(state, payload) {
            let gestiones = state.gestiones.concat(payload);
            state.gestiones = gestiones;
        },
        ADD_GESTIONES(state, payload) {
            if(payload.isArray){
                payload.forEach(gestion => {
                    let gestiones = state.gestiones.concat(gestion);
                    state.gestiones = gestiones;
                });
            }
        },
        EDIT_GESTION(state, payload) {
            let payloadx = payload.data.data;
            state.gestiones = state.gestiones.map(x => (x.id === payloadx.id) ? payloadx : x);
        },
        DELETE_GESTION(state, payload){
            let gestiones = state.gestiones.filter(p => p.id != payload)
            state.gestiones = gestiones;
        },
    },
    actions: {
        //Actions para los gestiones del cliente 
        async loadAll({commit}, payload){
            let response = await axios.get('api/gestiones/',{
                params: {
                  persona_id: payload
                }
             });
            let gestiones = response.data.data;
            commit('SET_GESTIONES', gestiones);
        },
        async searchGestion({commit}, payload){
            let response = await axios.post('/api/gestiones/search', payload);
             let gestiones = response.data;
            commit('SET_GESTIONES', gestiones);
        },
        async getGestionClienteAbogado({commit}, payload){
            let response = await axios.post('/api/gestiones/getGestionClienteAbogado',payload);
            let gestiones = response.data;
            commit('SET_REPORTE_GESTIONES', gestiones);
        },
        async create({commit}, gestion) {
            let response = await axios.post('api/gestiones', gestion);
            let savedGestion = response.data.data;
            commit('ADD_GESTION', savedGestion);
            return response;
        },
        async createExcel({commit}, gestion, config) {
            let response = await axios.post('api/gestiones/createExcel', gestion, config);
            let savedGestion = response[0];
            commit('ADD_GESTIONES', savedGestion);
            return response;
        },
        async edit({commit}, gestion) {
            let response = await axios.put(`api/gestiones/${gestion.id}`, gestion);
            let newGestion = response;
            commit('EDIT_GESTION', newGestion);
            return newGestion;
        },
        async delete({commit}, gestion) {
            let response = await axios.delete(`api/gestiones/${gestion.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_GESTION', gestion.id);
            }
        },
        async editCorreo({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editCorreo/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editEstampe({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editEstampe/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editCobrado({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editCobrado/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editPagado({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editPagado/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editCorreoF({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editCorreoF/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editEstampeF({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editEstampeF/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editCobradoF({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editCobradoF/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
        },
        async editPagadoF({commit}, gestion) {
            let response = await axios.put(`api/gestiones/editPagadoF/${gestion}`);      
            let newGestiones = response;
            commit('EDIT_GESTION', newGestiones);
            return newGestiones;
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