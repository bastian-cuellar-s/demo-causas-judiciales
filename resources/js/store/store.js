import personasModule from './personas.js';
import domicilioModule from './domicilios.js';
import deligenciaModule from './deligencias.js';
import gestionModule from './gestiones.js';
import arancelesModule from './aranceles.js';
import grupoAarancelesModule from './grupoAranceles.js';
import paramDeligenciasModule from './paramDeligencias.js';
import paramArancelesModule from './paramAranceles.js';
import paramGestionesModule from './paramGestiones.js';
import recibosModule from './recibo.js';


export default {
    modules:{
        personas            : personasModule,
        domicilios          : domicilioModule,
        deligencias         : deligenciaModule,
        gestiones           : gestionModule,
        aranceles           : arancelesModule,
        grupoAranceles      : grupoAarancelesModule,
        paramDeligencias    : paramDeligenciasModule,
        paramAranceles      : paramArancelesModule,
        paramGestiones      : paramGestionesModule,
        recibos             : recibosModule,
    }
};