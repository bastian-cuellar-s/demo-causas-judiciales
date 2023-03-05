export default {
    namespaced: true,
    state: {
        deligencias: [],
        pagination: [],
    },
    mutations: {
        SET_DELIGENCIAS(state, payload) {
            state.deligencias = payload.data.data;
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
        ADD_DELIGENCIA(state, payload) {
            let deligencias = state.deligencias.concat(payload);
            state.deligencias = deligencias;
        },
        EDIT_DELIGENCIA(state, payload) {
            /*let idx = state.deligencias.indexOf(state.deligencias.find(p => {
                p.id === payload.id;
              }));
            state.deligencias.splice(idx, 1, payload);*/
            let payloadx = payload.data.data;
            state.deligencias = state.deligencias.map(x => (x.id === payloadx.id) ? payloadx : x);
        },
        DELETE_DELIGENCIA(state, payload){
            let deligencias = state.deligencias.filter(p => p.id != payload)
            state.deligencias = deligencias;
        },
        DELETE_ALL_DELIGENCIA(state, payload){            
            let deligencias = state.deligencias.filter(item => !payload.includes(item.id));          
            state.deligencias = deligencias;
        },
    },
    actions: { 
        async loadAll({commit}){
            let response = await axios.get('/api/deligencias');
            let deligencias = response.data.data.data;
            commit('SET_DELIGENCIAS', deligencias);
        },
        async searchDeligencia({commit}, payload){
            let response = await axios.post('/api/deligencias/search',payload);
            let deligencias = response.data;
            commit('SET_DELIGENCIAS', deligencias);
        },
        async create({commit}, deligencia) {
            let response = await axios.post('api/deligencias', deligencia);
            let savedDeligencia = response.data.data;
            commit('ADD_DELIGENCIA', savedDeligencia);
            return response;
        },
        async edit({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/${deligencia.id}`, deligencia);
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editCorreo({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editCorreo/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editEstampe({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editEstampe/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editCobrado({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editCobrado/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editPagado({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editPagado/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editCorreoF({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editCorreoF/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editEstampeF({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editEstampeF/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editCobradoF({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editCobradoF/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async editPagadoF({commit}, deligencia) {
            let response = await axios.put(`api/deligencias/editPagadoF/${deligencia}`);      
            let newDeligencia = response;
            commit('EDIT_DELIGENCIA', newDeligencia);
            return newDeligencia;
        },
        async delete({commit}, deligencia) {
            let response = await axios.delete(`api/deligencias/${deligencia.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_DELIGENCIA', deligencia.id);
            }
        },
        async deleteAll({commit}, deligencia) {
            let response = await axios.delete('api/deligencias/all/' + deligencia);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_ALL_DELIGENCIA', deligencia);
            }
        },
        //action para enviar el correo
        async sendEmail(_,payload) {
            let response = await axios.post('api/sendEmail', payload);
            return response;
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