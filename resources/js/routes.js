import Dashboard from './components/Dashboard.vue';
import Profile from './components/Profile.vue';
import Developer from './components/Developer.vue';
import Users from './components/Users.vue';
import Personas from './components/persona/Personas.vue';
import VistaPersona from './components/persona/VistaPersona.vue';
import DomPersona from './components/persona/DomPersona.vue';
import Deligencias from './components/deligencia/Deligencias.vue';
import Reportes from './components/reporte/Reportes.vue';
import TipoArancel from './components/admin/TipoArancel.vue';
import TipoCuaderno from './components/admin/TipoCuaderno.vue';
import Aranceles from './components/arancel/Aranceles.vue';
import GrupoAranceles from './components/arancel/grupoAranceles.vue';
import Encargos from './components/admin/Encargos.vue';
import Materias from './components/admin/Materias.vue';
import Tribunales from './components/admin/Tribunales.vue';
import NotFound from './components/NotFound.vue';

export const routes = [
    {
        path: '/dashboard',
        component: Dashboard,
    },
    {
        path: '/profile',
        component: Profile
    },
    {
        path: '/developer',
        component: Developer
    },
    {
        path: '/users',
        component: Users
    },
    {
        path: '/personas',
        component: Personas,
        name: 'Personas',
    },
    {
        path: '/personas/:id',
        component: VistaPersona,
        name: 'PersonasId',

    },
    {
        path: '/domicilio/',
        component: DomPersona,
        name: 'DomPersonas',
        props: true,

    },
    {
        path: '/deligencias/',
        component: Deligencias,
        name: 'Deligencias',

    },
    {
        path: '/reportes/',
        component: Reportes,
        name: 'Reportes',

    },
    {
        path: '/aranceles/',
        component: Aranceles,
        name: 'Aranceles',
        props: true,

    },
    {
        path: '/grupo-aranceles/',
        component: GrupoAranceles,
        name: 'GrupoAranceles',

    },
    {
        path: '/tipo-arancel/',
        component: TipoArancel,
        name: 'TipoArancel',

    },
    {
        path: '/tipo-cuaderno/',
        component: TipoCuaderno,
        name: 'TipoCuaderno',

    },
    {
        path: '/encargos/',
        component: Encargos,
        name: 'Encargos',

    },
    {
        path: '/materias/',
        component: Materias,
        name: 'Materias',

    },
    {
        path: '/tribunales/',
        component: Tribunales,
        name: 'Tribunales',

    },
    {
        path: '*',
        component: NotFound,
        name: 'NotFound',
    },
];
