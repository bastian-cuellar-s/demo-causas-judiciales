export default {
    namespaced: true,
    state: {
        encargos: [],
        materias: [],
        tribunales: [],
        tipoCuadernos: [],
    },
    mutations: {
        //mutaciones para los tipos de ENCARGOS, necesarios para el dropdown de ENCARGOS en las DELIGENCIAS
        SET_ENCARGOS(state, payload) {
            state.encargos = payload;
        },
        ADD_ENCARGO(state, payload) {
            let encargos = state.encargos.concat(payload);
            state.encargos = encargos;
        },
        EDIT_ENCARGO(state, payload) {
            let idx = state.encargos.indexOf(state.encargos.find(p => {
                p.id === payload.id;
              }));
            state.encargos.splice(idx, 1, payload);
        },
        DELETE_ENCARGO(state, payload){
            let encargos = state.encargos.filter(p => p.id != payload)
            state.encargos = encargos;
        },
        //mutaciones para los tipos de MATERIAS, necesarios para el dropdown de MATERIAS en las deligencias
        SET_MATERIAS(state, payload) {
            state.materias = payload;
        },
        ADD_MATERIA(state, payload) {
            let materias = state.materias.concat(payload);
            state.materias = materias;
        },
        EDIT_MATERIA(state, payload) {
            let idx = state.materias.indexOf(state.materias.find(p => {
                p.id === payload.id;
              }));
            state.materias.splice(idx, 1, payload);
        },
        DELETE_MATERIA(state, payload){
            let materias = state.materias.filter(p => p.id != payload)
            state.materias = materias;
        },
        //mutaciones para los tipos de TRIBUNALES, necesarios para el dropdown de TRIBUNALES en las deligencias
        SET_TRIBUNALES(state, payload) {
            state.tribunales = payload;
        },
        ADD_TRIBUNAL(state, payload) {
            let tribunales = state.tribunales.concat(payload);
            state.tribunales = tribunales;
        },
        EDIT_TRIBUNAL(state, payload) {
            let idx = state.tribunales.indexOf(state.tribunales.find(p => {
                p.id === payload.id;
              }));
            state.tribunales.splice(idx, 1, payload);
        },
        DELETE_TRIBUNAL(state, payload){
            let tribunales = state.tribunales.filter(p => p.id != payload)
            state.tribunales = tribunales;
        },
        //mutaciones para los tipos de CUADERNO, necesarios para el dropdown de CUADERNO en las deligencias
        SET_TIPO_CUADERNOS(state, payload) {
            state.tipoCuadernos = payload;
        },
        ADD_TIPO_CUADERNO(state, payload) {
            let tipoCuadernos = state.tipoCuadernos.concat(payload);
            state.tipoCuadernos = tipoCuadernos;
        },
        EDIT_TIPO_CUADERNO(state, payload) {
            let idx = state.tipoCuadernos.indexOf(state.tipoCuadernos.find(p => {
                p.id === payload.id;
              }));
            state.tipoCuadernos.splice(idx, 1, payload);
        },
        DELETE_TIPO_CUADERNO(state, payload){
            let tipoCuadernos = state.tipoCuadernos.filter(p => p.id != payload)
            state.tipoCuadernos = tipoCuadernos;
        },
        
    },
    actions: { 
        //Actions para los tipos de ENCARGOS, necesarios para el dropdown de ENCARGOS en las DELIGENCIAS
        async loadAllEncargos({commit}){
            let response = await axios.get('/api/encargos');
            let encargos = response.data.data;
            commit('SET_ENCARGOS', encargos);
        },
        async createEncargo({commit}, encargo, config) {
            let response = await axios.post('api/encargos', encargo, config);
            let savedEncargo = response.data.data;
            commit('ADD_ENCARGO', savedEncargo);
            return response;
        },
        async editEncargo({commit}, encargo) {
            let response = await axios.put(`api/encargos/${encargo.id}`, encargo);
            let newEncargo = response.data.data;
            commit('EDIT_ENCARGO', newEncargo);
            return newEncargo;
        },
        async deleteEncargo({commit}, encargo) {
            let response = await axios.delete(`api/encargos/${encargo.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_ENCARGO', encargo.id);
            }
        },
        //Actions para los tipos de MATERIAS, necesarios para el dropdown de MATERIAS en las deligencias
        async loadAllMaterias({commit}){
            let response = await axios.get('/api/materias');
            let materias = response.data.data;
            commit('SET_MATERIAS', materias);
        },
        async createMateria({commit}, materia) {
            let response = await axios.post('api/materias', materia);
            let savedMateria = response.data.data;
            commit('ADD_MATERIA', savedMateria);
            return response;
        },
        async editMateria({commit}, materia) {
            let response = await axios.put(`api/materias/${materia.id}`, materia);
            let newMateria = response.data.data;
            commit('EDIT_MATERIA', newMateria);
            return newMateria;
        },
        async deleteMateria({commit}, materia) {
            let response = await axios.delete(`api/materias/${materia.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_MATERIA', materia.id);
            }
        },
        //Actions para los tipos de TRIBUNALES, necesarios para el dropdown de TRIBUNALES en las deligencias
        async loadAllTribunales({commit}){
            let response = await axios.get('/api/tribunales');
            let tribunales = response.data.data;
            commit('SET_TRIBUNALES', tribunales);
        },
        async createTribunal({commit}, tribunal) {
            let response = await axios.post('api/tribunales', tribunal);
            let savedTribunal = response.data.data;
            commit('ADD_TRIBUNAL', savedTribunal);
            return response;
        },
        async editTribunal({commit}, tribunal) {
            let response = await axios.put(`api/tribunales/${tribunal.id}`, tribunal);
            let newTribunal = response.data.data;
            commit('EDIT_TRIBUNAL', newTribunal);
            return newTribunal;
        },
        async deleteTribunal({commit}, tribunal) {
            let response = await axios.delete(`api/tribunales/${tribunal.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_TRIBUNAL', tribunal.id);
            }
        },
        //Actions para los tipos de CUADERNO, necesarios para el dropdown de CUADERNO en las deligencias
        async loadAllTipoCuadernos({commit}){
            let response = await axios.get('/api/tipoCuaderno');
            let tipoCuadernos = response.data.data.data;
            commit('SET_TIPO_CUADERNOS', tipoCuadernos);
        },
        async createTipoCuaderno({commit}, tipoCuaderno) {
            let response = await axios.post('api/tipoCuaderno', tipoCuaderno);
            let savedTipoCuaderno = response.data.data;
            commit('ADD_TIPO_CUADERNO', savedTipoCuaderno);
            return response;
        },
        async editTipoCuaderno({commit}, tipoCuaderno) {
            let response = await axios.put(`api/tipoCuaderno/${tipoCuaderno.id}`, tipoCuaderno);
            let newTipoCuaderno = response.data.data;
            commit('EDIT_TIPO_CUADERNO', newTipoCuaderno);
            return newTribunal;
        },
        async deleteTipoCuaderno({commit}, tipoCuaderno) {
            let response = await axios.delete(`api/tipoCuaderno/${tipoCuaderno.id}`);
            if(response.status == 200 || response.status == 204){
              commit('DELETE_TIPO_CUADERNO', tipoCuaderno.id);
            }
        },
    }
};