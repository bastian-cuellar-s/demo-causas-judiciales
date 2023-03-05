export default {
    namespaced: true,
    state: {
        personas: [],
        pagination: [],
        clientes: [],
        abogados: [],
        demandados: [],
        clientes_abogados: [],
        personas_recibo: [],
    },
    mutations: {
        SET_PERSONAS(state, payload) {
            state.personas = payload.data.data;
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
        ADD_PERSONA(state, payload) {
            let personas = state.personas.concat(payload);
            state.personas = personas;
        },
        EDIT_PERSONA(state, payload) {

            /*let idx = state.personas.indexOf(state.personas.find(p => {
                p.id === payload.id;
              }))
            state.personas.splice(idx, 1, payload);*/
            let payloadx = payload.data.data;
            state.personas = state.personas.map(x => (x.id === payloadx.id) ? payloadx : x);

        },
        DELETE_PERSONA(state, payload){
            let personas = state.personas.filter(p => p.id != payload)
            state.personas = personas;
        },
        DELETE_ALL_PERSONA(state, payload){            
            //let personas = state.personas.filter(p => p.id != payload)
            let personas = state.personas.filter(item => !payload.includes(item.id));          
            state.personas = personas;
        },
        SET_CLIENTES(state, payload) {
            state.clientes = payload;
        },
        SET_ABOGADOS(state, payload) {
            state.abogados = payload;
        },
        SET_DEMANDADOS(state, payload) {
            state.demandados = payload;
        },
        SET_PERSONAS_RECIBO(state, payload) {
            state.personas_recibo = payload;
        },
        SET_CLIENTES_ABOGADOS(state, payload) {
            state.clientes_abogados = payload;
        },
    },
    actions: { 
        async loadAll({commit}, payload){
            let response = await axios.get('/api/personas?page='+ payload);
            let personas = response.data;
            commit('SET_PERSONAS', personas);
        },
        async searchPersona({commit}, payload){
            let response = await axios.post('/api/personas/search',payload);
            let personas = response.data;
            commit('SET_PERSONAS', personas);
        },
        //Cargo los clientes y los abogados en conjunto
        async loadAllClientesAbogados({commit}, payload){
            let response = await axios.get('api/clientesAbogados/listaClientesAbogadosAll',{
                params: {
                    searchQuery: payload.searchQuery,
                }
                });
            let clientesAbogados = response.data.data.data;
            commit('SET_CLIENTES_ABOGADOS', clientesAbogados);
        },
        async loadAllClientes({commit}, payload){
            let response = await axios.get('api/clientes/listaClientes',{
                params: {
                    searchQuery: payload.searchQuery,
                }
                });
            let clientes = response.data.data.data;
            commit('SET_CLIENTES', clientes);
        },
        async loadAllAbogados({commit}, payload){
            let response = await axios.get('api/abogados/listaAbogados',{
                params: {
                    searchQuery: payload.searchQuery,
                }
                });
            let abogados = response.data.data.data;
            commit('SET_ABOGADOS', abogados);
        },
        async loadAllAbogadosCliente({commit}, payload){
            let response = await axios.get('api/abogadosCliente/listaAbogadosCliente',{
                params: {
                  cliente_id: payload.cliente_id,
                  searchQuery: payload.searchQuery
                }
             });
            let abogados = response.data.data.data;
            commit('SET_ABOGADOS', abogados);
        },
        async loadAllPersonasRecibo({commit}, payload){
            let response = await axios.get('api/personasRecibo/listaPersonasRecibo',{
                params: {
                  cliente_id: payload.cliente_idx,
                  abogado_id: payload.abogado_idx,
                  demandado_id: payload.demandado_idx,
                }
             });
            let personas_recibo = response.data.data;
            commit('SET_PERSONAS_RECIBO', personas_recibo);
        },
        async loadAllDemandados({commit}, payload){
            let response = await axios.get('api/demandados/listaDemandados',{
            params: {
                searchQuery: payload.searchQuery,
            }
            });
            let demandados = response.data.data.data;
            commit('SET_DEMANDADOS', demandados);
        },        
        async create({commit}, persona) {
            let response = await axios.post('api/personas', persona);
            let savedPersona = response.data.data;
            commit('ADD_PERSONA', savedPersona);
            return response;
        },
        async edit({commit}, persona) {
            let response = await axios.put(`api/personas/${persona.id}`, persona)
            let newPersona = response;
            commit('EDIT_PERSONA', newPersona);
            return newPersona;
        },
        async delete({commit}, persona) {
            let response = await axios.delete(`api/personas/${persona.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_PERSONA', persona.id);
            }
        },
        async deleteAll({commit}, persona) {
            let response = await axios.delete('api/personas/all/' + persona);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_ALL_PERSONA', persona);
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