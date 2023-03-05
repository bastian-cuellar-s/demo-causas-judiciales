export default {
    namespaced: true,
    state: {
        recibos: [],
    },
    mutations: {
        //Recibos correspondientes al cliente
        SET_RECIBOS(state, payload) {
            state.recibos = payload;
        },
        ADD_RECIBO(state, payload) {
            let recibos = state.recibos.concat(payload);
            state.recibos = recibos;
        },
        EDIT_RECIBO(state, payload) {
            let idx = state.recibos.indexOf(state.recibos.find(p => {
                p.id === payload.id;
              }));
            state.recibos.splice(idx, 1, payload);
        },
        DELETE_RECIBO(state, payload){
            let recibos = state.recibos.filter(p => p.id != payload)
            state.recibos = recibos;
        },
    },
    actions: {
        //Actions para los recibos del cliente 
        async loadAll({commit}, payload){
            let response = await axios.get('api/recibos/');
            let recibos = response.data.data;
            commit('SET_RECIBOS', recibos);
        },
        async create({commit}, recibo) {
            let response = await axios.post('api/recibos', recibo);
            let savedRecibo = response.data.data;
            commit('ADD_RECIBO', savedRecibo);
            return response;
        },
        async edit({commit}, recibo) {
            let response = await axios.put(`api/recibos/${recibo.id}`, recibo);
            let newRecibo = response.data.data;
            commit('EDIT_RECIBO', newRecibo);
            return newRecibo;
        },
        async delete({commit}, recibo) {
            let response = await axios.delete(`api/recibos/${recibo.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_RECIBO', recibo.id);
            }
        },
    }
};