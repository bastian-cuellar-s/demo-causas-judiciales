export default {
    namespaced: true,
    state: {
        gestionFechas: [],
        reciboExtras: [],
    },
    mutations: {
        //Mutaciones para las fechas extras de las gestiones 
        SET_GESTION_FECHA(state, payload) {
            state.gestionFechas = payload;
        },
        ADD_GESTION_FECHA(state, payload) {
            let gestionFechas = state.gestionFechas.concat(payload);
            state.gestionFechas = gestionFechas;
        },
        EDIT_GESTION_FECHA(state, payload) {
            let idx = state.gestionFechas.indexOf(state.gestionFechas.find(p => {
                p.id === payload.id;
              }));
            console.log(payload);
            state.gestionFechas.splice(idx, 1, payload);
        },
        DELETE_GESTION_FECHA(state, payload){
            let gestionFechas = state.gestionFechas.filter(p => p.id != payload)
            state.gestionFechas = gestionFechas;
        },
        //Mutaciones para los costos extras de los recibos
        ADD_RECIBO_EXTRA(state, payload) {
            let reciboExtras = state.reciboExtras.concat(payload);
            state.reciboExtras = reciboExtras;
        },
        DELETE_RECIBO_EXTRA(state, payload){
            let reciboExtras = state.reciboExtras.filter(p => p.id != payload)
            state.reciboExtras = reciboExtras;
        },
    },
    actions: {
        //Actions para tipos de aranceles parametizables
        async loadAllGestionFecha({commit}){
            let response = await axios.get('api/gestionFecha/');
            let gestionFechas = response.data.data; 
            commit('SET_GESTION_FECHA', gestionFechas);
        },
        async createGestionFecha({commit}, gestionFecha) {
            let response = await axios.post('api/gestionFecha', gestionFecha);
            let savedGestionFecha = response.data.data;
            commit('ADD_GESTION_FECHA', savedGestionFecha);
            return response;
        },
        async editGestionFecha({commit}, gestionFecha) {
            let response = await axios.put(`api/gestionFecha/${gestionFecha.id}`, gestionFecha);
            let newGestionFecha = response.data.data;
            commit('EDIT_GESTION_FECHA', newGestionFecha);
            //console.log(newGestionFecha); 
            return newGestionFecha;
        },
        async deleteGestionFecha({commit}, gestionFecha) {
            let response = await axios.delete(`api/gestionFecha/${gestionFecha}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_GESTION_FECHA', gestionFecha.id);
            }
        },
        //Actions para los Extras de los recibos
        async createReciboExtra({commit}, reciboExtra) {
            let response = await axios.post('api/reciboExtra', reciboExtra);
            let savedreciboExtra = response.data.data;
            commit('ADD_RECIBO_EXTRA', savedreciboExtra);
            return response;
        },
        async deleteReciboExtra({commit}, reciboExtra) {
            let response = await axios.delete(`api/reciboExtra/${reciboExtra}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_RECIBO_EXTRA', reciboExtra.id);
            }
        },
    }
};