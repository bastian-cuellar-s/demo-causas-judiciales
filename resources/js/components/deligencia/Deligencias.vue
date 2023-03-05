<template>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                  <h3 class="card-title">Lista de Diligencias</h3>
                  
                <div class="card-tools">
                  <div class="btn">
                        <button v-if="checked.length > 0"
                            class="btn btn-danger"
                            @click="deleteAllPersona"
                        >
                          Eliminar [{{ checked.length }}] registros
                        </button>
                  </div>

                  <div class="btn">
                     <div class="input-group">                                  
                       <label for="paginate" class="text-nowrap mr-2 mb-0"
                           >Por Pagina</label
                       >
                       <select
                           v-model="paginate"
                           class="form-control-sm"
                       >
                           <option value="15">15</option>
                           <option value="30">30</option>
                           <option value="50">50</option>
                       </select>                              
                     </div>
                  </div>

                  <button type="button" class="btn btn-primary" @click="isHiddenActions = !isHiddenActions"><i class="fas fa-caret-square-down"></i></button>

                  <button class="btn btn-success" @click="newModal">Agregar <b> </b><i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>

              <div v-if="isHiddenActions" class="card-header">
                <h3 class="card-title">Acciones Extra</h3>
                <div class="card-tools">
                <button class="btn btn-success" 
                data-toggle="modal" 
                data-target="#modalCrearPersona"
                title="CrearPersona"
                @click="showModalCrearPersona">Agregar Persona <b> </b><i class="fas fa-user-plus fa-fw"></i></button>
                <button class="btn btn-success"
                data-toggle="modal" 
                data-target="#modalDomPersona"
                title="CrearDomPersona" 
                @click="showModalDomPersona">Agregar Domicilio <b> </b><i class="fas fa-house-user"></i></button>
                <!--<button class="btn btn-success"
                data-toggle="modal" 
                data-target="#modalArancel"
                title="ArancelPersona" 
                @click="showModalArancel">Agregar Arancel <b> </b><i class="fas fa-money-bill"></i></button>-->
                </div>

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="col-md-10 mb-2" v-if="selectPage">
                    <div v-if="selectAll">
                        Ya has seleccionado todos los registros
                        <strong>{{ checked.length }}</strong> registros.
                    </div>
                    <div v-else>
                        Has seleccionado <strong>{{ checked.length }}</strong> registros. Te gustaría
                        seleccionarlos todos <strong>{{ this.pagination.total }}</strong>?
                        <a @click.prevent="selectAllRecords" href="#" class="ml-2">Todos</a>
                    </div>
                </div>
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th><input type="checkbox" v-model="selectPage" /></th>
                      <th>
                        <a href="#" @click.prevent="change_sort('rol')">ROL</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'rol'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'rol'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('tribunal')">Tribunal</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'tribunal'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'tribunal'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('caratulado')">Caratulado</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'caratulado'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'caratulado'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('updated_at')">Modificación</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'updated_at'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'updated_at'">&darr;</span>
                      </th>
                      <th>                          
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="deligencia in deligencias" :key="deligencia.id" :class="isChecked(deligencia.id) ? 'table-primary' : ''">
                    
                    <td>
                      <input type="checkbox" :value="deligencia.id" v-model="checked"/>
                    </td>
                    <td>{{deligencia.rol}}</td>
                    <td>{{deligencia.tribunal}}</td>
                    <td>{{deligencia.caratulado}}</td>
                    <td>{{deligencia.updated_at  | formatDate  }}</td>
                    <td>
                      <ul class="list-inline m-0">
                          <li class="list-inline-item">
                            <button type="button" 
                            class="btn btn-success col-mb-1"
                            data-toggle="modal" 
                            data-target="#ModalCreateGestion"
                            title="CreateGestion"
                            @click="showModalCrearGestion(deligencia)">
                              <i class="fas fa-plus"></i>
                            </button>
                          </li>
                          <li class="list-inline-item">
                            <button type="button" 
                            class="btn btn-secondary col-mb-1"
                            data-toggle="modal" 
                            data-target="#ModalMenuGestion"
                            data-backdrop="static" 
                            data-keyboard="false"
                            title="MenuGestion"
                            @click="showModalMenuGestion(deligencia)">
                              <i class="fas fa-bars"></i>
                            </button>
                          </li>
                          <li class="list-inline-item">
                            <button class="btn btn-secondary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-tools"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                              <button class="btn btn-success btn-sm rounded-1 dropdown-item" 
                              data-placement="top" 
                              @click="editModal(deligencia)" 
                              title="edit"><i class="fa fa-edit"> Editar</i>
                              </button>

                              <button class="btn btn-danger btn-sm rounded-1 dropdown-item" 
                              data-placement="top" 
                              @click="deleteDeligencia(deligencia)" 
                              title="Delete"><i class="fa fa-trash "> Eliminar</i>
                              </button>
                            </div>
                          </li>
                      </ul>
                    </td>
                  </tr>
                  </tbody>
                </table>
                <div class="card-footer text-muted">
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item" v-if="this.pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="changePage(decrementPagination())">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>

                    <li class="page-item" v-for="page in pagesNumber" :key="page" v-bind:class="[ page == isActived ? 'active' : '']">
                      <a class="page-link" href="#" @click.prevent="changePage(page)">
                        {{ page }}
                      </a>
                    </li>

                    <li class="page-item" v-if="this.pagination.current_page < this.pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="changePage(incrementPagination())">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <div>
            <CrearPersonaModal
                  v-show="ModalCrearPersonaVisible"
                  @close="closeModalCrearPersona"
                  :idxDeligencia="idxDeligencia"
                  :ModalCrearPersonaVisible="ModalCrearPersonaVisible"
            >
            
            <template v-slot:header>
              Crear Persona
            </template>
            </CrearPersonaModal>
          </div>
          <div>
            <DomPersonaModal
                  v-show="ModalDomicilioVisible"
                  @close="closeModalDomPersona"
                  :ModalDomicilioVisible="ModalDomicilioVisible"
            >
            
              <template v-slot:header>
                Crear Domicilio
              </template>
            </DomPersonaModal>
          </div>
          <!--<div>
            <ArancelModal
                  v-show="ModalArancelVisible"
                  @close="closeModalArancel"
                  :ModalArancelVisible="ModalArancelVisible"
            >
            
              <template v-slot:header>
                Crear Arancel
              </template>
            </ArancelModal>
          </div>-->
          <div>
            <ModalCreateGestion
                  v-show="ModalCreateGestionVisible"
                  @close="closeModalCrearGestion"
                  :idxDeligencia="idxDeligencia"
                  :ModalCreateGestionVisible="ModalCreateGestionVisible"
            >
            
              <template v-slot:header>
                Crear Gestión
              </template>
            </ModalCreateGestion>
          </div>
          <div>
            <ModalMenuGestion
                  v-show="ModalMenuGestionVisible"
                  @close="closeModalMenuGestion"
                  :idxDeligencia="idxDeligencia"
                  :ModalMenuGestionVisible="ModalMenuGestionVisible"
            >
            
              <template v-slot:header>
                Menu de Gestiones
              </template>
            </ModalMenuGestion>
          </div>
            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar nueva Diligencia</h5>
                          <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar información de la Diligencia</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form @submit.prevent="editmode ? updateDeligencia() : createDeligencia()">
                      <div class="modal-body">

                              <div class="form-group">
                                <input v-model="form.rol" type="text" name="rol"
                                  placeholder="ROL"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('rol') }" required>
                                <has-error :form="form" field="rol"></has-error>
                              </div>

                              <div class="form-group">
                                <input v-model="form.caratulado" type="text" name="caratulado"
                                  placeholder="Caratulado"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('caratulado') }" required>
                                <has-error :form="form" field="caratulado"></has-error>
                              </div>

                              <div class="form-group">

                                <v-select 
                                v-model="form.tribunal" 
                                :options="tribunales" 
                                :reduce="tribunales => tribunales.name"
                                label="name" 
                                placeholder="Seleccione el Tribunal" >
                                </v-select>
                                
                              </div>


                              <div class="form-group">

                                <v-select 
                                v-model="form.materia" 
                                :options="materias" 
                                :reduce="materias => materias.name"
                                label="name" 
                                placeholder="Seleccione la Materia" >
                                </v-select>
                                
                              </div>
                              
                              <div class="form-group">
                                <label>Cliente</label>
                                <v-select 
                                v-model="form.cliente_id" 
                                :options="clientes_abogados" 
                                :reduce="clientes_abogados => clientes_abogados.id"
                                :filterable="false"
                                @option:selecting="onSelecting"
                                @close="onDeselected" 
                                @search="onSearchClienteAbogado"
                                label="name" 
                                placeholder="Seleccione el Cliente" 
                                >
                                  <template #selected-option="{ representante , name, rut }">
                                    <div style="display: flex; align-items: baseline;">
                                    <strong>{{ name }}</strong>&nbsp;
                                    {{ representante }}
                                    <em style="margin-left: .5rem;"> - [{{ rut }}]</em>
                                    </div>
                                  </template>
                                  <template v-slot:option="option">
                                      <strong>{{ option.name }}</strong>&nbsp;{{ option.representante }} - [{{option.rut}}]
                                  </template>
                                </v-select>

                              </div>

                              <div class="form-group">
                                <label>Abogado del Cliente</label>
                                <v-select 
                                v-model="form.abogado_id" 
                                :options="clientes_abogados" 
                                :reduce="clientes_abogados => clientes_abogados.id"
                                :filterable="false"
                                @option:selecting="onSelecting"
                                @close="onDeselected" 
                                @search="onSearchClienteAbogado"
                                label="name" 
                                placeholder="Seleccione el Abogado del Cliente" >
                                  <template #selected-option="{ name, rut }">
                                    <div style="display: flex; align-items: baseline;">
                                    <strong>{{ name }}</strong>&nbsp;
                                    <em style="margin-left: .5rem;"> - [{{ rut }}]</em>
                                    </div>
                                  </template>
                                  <template v-slot:option="option">
                                      <strong>{{ option.name }}</strong>&nbsp; - [{{option.rut}}]
                                  </template>
                                </v-select>
                              </div>

                              <div class="form-group">
                                <label>Demandado Principal</label>
                                <v-select 
                                v-model="form.demandado_id" 
                                :options="demandados"
                                :reduce="demandados => demandados.id" 
                                :filterable="false"
                                @option:selecting="onSelecting"
                                @option:selected="onSelectedDemandado"
                                @input="offSelectedDemandado"
                                @close="onDeselected" 
                                @search="onSearchDemandado"
                                label="name"
                                placeholder="Seleccione el Demandando" >
                                  <template #selected-option="{ representante , name, rut}">
                                    <div style="display: flex; align-items: baseline;">
                                    <strong>{{ name }}</strong>&nbsp;
                                    {{ representante }}
                                    <em style="margin-left: .5rem;"> - [{{ rut }}]</em>
                                    </div>
                                  </template>
                                  <template v-slot:option="option">
                                      <strong>{{ option.name }}</strong>&nbsp;{{ option.representante }} - [{{option.rut}}]
                                  </template>
                                  <!--<template #list-footer>
                                    <li v-show="hasNextPage" ref="load" class="loader">
                                      Loading more options...
                                    </li>
                                  </template>-->
                                </v-select>
                              </div>

                              <div class="form-group">
                                <label>Demandados</label>
                                <v-select 
                                v-model="form.demandados" 
                                :options="demandados"
                                @option:selecting="onSelecting"
                                @close="onDeselected" 
                                @search="onSearchDemandado"
                                :filterable="false"
                                label="name"
                                multiple
                                placeholder="Seleccione el Demandando" >
                                  <template #selected-option="{ representante , name, rut}">
                                    <div style="display: flex; align-items: baseline;">
                                    <strong>{{ name }}</strong>&nbsp;
                                    {{ representante }}
                                    <em style="margin-left: .5rem;"> - [{{ rut }}]</em>
                                    </div>
                                  </template>
                                  <template v-slot:option="option">
                                      <strong>{{ option.name }}</strong>&nbsp;{{ option.representante }} - [{{option.rut}}]
                                  </template>
                                  <!--<template #list-footer>
                                    <li v-show="hasNextPage" ref="load" class="loader">
                                      Loading more options...
                                    </li>
                                  </template>-->
                                </v-select>
                              </div>

                              <div class="form-group">
                                  <textarea v-model="form.obs" name="obs" id="obs"
                                  placeholder="Observaciones sobre la diligencia"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('obs') }"></textarea>
                                  <has-error :form="form" field="obs"></has-error>
                              </div>

                              </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Diligencia</button>
                                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Diligencia</button>
                  
                                  </div>
                      </form>
                        
                      </div>
                      
                  </div>
                </div>
               </div>  
            </div>
  </section>           
</template>

<script>

import { mapState } from 'vuex';
import CrearPersonaModal from '../../components/persona/CrearPersonaModal.vue';
import DomPersonaModal from '../../components/persona/DomPersonaModal.vue';
import ArancelModal from '../../components/arancel/ArancelModal.vue';
import ModalCreateGestion from '../../components/gestion/ModalCreateGestion.vue';
import ModalMenuGestion from '../../components/gestion/ModalMenuGestion.vue';
//import ReciboModal from '../../components/recibo/ReciboModal.vue';
//import SendEmailModal from '../../components/deligencia/SendEmailModal.vue';
//import PrintCedulaModal from '../../components/deligencia/PrintCedulaModal.vue';
//import EstampadoModal from '../../components/deligencia/EstampadoSelectModal.vue';


    export default {
      components:{
          CrearPersonaModal,
          DomPersonaModal,
          ArancelModal,
          //ReciboModal,
          //SendEmailModal,
          //PrintCedulaModal,
          //EstampadoModal,
          ModalCreateGestion,
          ModalMenuGestion,
        },
        data(){
          return{
            editmode: false,
            editmodeGestion: false,
            ModalCrearPersonaVisible: false,
            ModalDomicilioVisible: false,
            //ModalArancelVisible: false,
            //ModalReciboVisible: false,
            //ModalEmailVisible: false,
            //ModalCedulaVisible: false,
            //ModalEstampadoVisible: false,
            ModalCreateGestionVisible: false,
            ModalMenuGestionVisible: false,
            searchQuery: null,
            searchQueryDemandado: null,
            offset: 3,
            initial: 1,
            sort_direction : 'desc',
            sort_field: 'updated_at',
            paginate: 15,
            checked: [],
            selectPage : false,
            selectAll : false,
            selecting : false,
            isHiddenActions : false,
            form: new Form({
                id:           '',
                rol:          '',
                tribunal:     '',
                materia:      '',
                caratulado:   '',
                cliente_id:   '',
                abogado_id:   '',
                demandado_id: '',
                demandados: [],
                obs:    '',
            }),
            idxcliente: [],
            idxDeligencia: [],

          }
        },
        methods: {
          listaDiligencia(deligencia){
            let sumEstampado = 0;
            let sumCorreo = 0;
            let sumRecibo = 0;
            let sumLista = 0;

            if(deligencia.estampe){
              sumEstampado = 1;
            }
            if(deligencia.correo){
              sumCorreo = 1;
            }
            if(deligencia.recibo){
              sumRecibo = 1;
            }
          
          sumLista = sumEstampado + sumCorreo + sumRecibo;

          return sumLista;
            
          },
          //metodos para infinite scroll en v-select
          onSearchClienteAbogado(query) {
            if(!this.selecting){

              this.$store.dispatch('personas/loadAllClientesAbogados',{ 
                  searchQuery : query})            
            }

          },
          onSearchDemandado(query) {
            if(!this.selecting){

              this.$store.dispatch('personas/loadAllDemandados',{ 
                  searchQuery : query})            
            }

          },
          onSelectedDemandado(e){
            if(e){
              if(this.form.demandados.length > 0){
                this.form.demandados = [];
                this.form.demandados.push(e);
              }else{
                this.form.demandados.push(e);
              }
            }
          },
          offSelectedDemandado(e){
            if(!e){
              this.form.demandados.splice(e,1);
            }
          },
          onSelecting(e){
              this.selecting = true;
          },
          onDeselected(){
            this.selecting = false;
          },
          //Metodo para rellenar los id en checked
          selectAllRecords(){
            axios.get('/api/deligencias/all/')
            .then(response => {
                this.checked = response.data;
                this.selectAll = true;
          }).catch((e)=>{
                  console.log(e);
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
          },
          isChecked(id){
            return this.checked.includes(id);
          },
          //metodo para ordenar los datos por campo
          change_sort(field){
            if(this.sort_field == field){
                this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
            }else{
                this.sort_field = field;
            }
            this.getDeligencias();
          },
          //Metodos para la paginacion
          changePage: function(page) {
            this.$store.dispatch('personas/pagination', page);
            this.$store.dispatch('deligencias/searchDeligencia', 
            {
              searchQuery: this.searchQuery,
              page:page,
              sort_direction: this.sort_direction,
              sort_field: this.sort_field,
              paginate: this.paginate,
            });
          },
          incrementPagination(){
              this.$store.dispatch('deligencias/incrementPagination');
              return this.pagination.current_page;
          },
          decrementPagination(){
              this.$store.dispatch('deligencias/decrementPagination');
              return this.pagination.current_page;
          },
          //Metodo para poder seleccionar los abogados de un cliente
          getAbogados(value){
              this.$store.dispatch('personas/loadAllAbogadosCliente',{
                cliente_id  : value,
                searchQuery : this.searchQueryDemandado,
                }); 
          },
          getStoreName(props) {
              return this.clientes.find(i => i.id === props.option).name
          },
          getStoreRut(props) {
              return this.clientes.find(i => i.id === props.option).rut
          },
          //Metodo para tener el horario y fechas en formato latinoamericano
          customFormatter(date) {
              return moment(date).format('L');
          },
          //Metodo para interactuar con el modal donde se edita una deligencia
          editModal(deligencia){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal({backdrop: 'static', keyboard: false}, 'show');
                this.form.fill(deligencia);
          },
          //Metodo para interactuar con el modal donde se crea una deligencia
          newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal({backdrop: 'static', keyboard: false}, 'show');
          },
          //Componenete Modal usado para crear una persona cliente, abogado demandado
          showModalCrearPersona() {
            this.ModalCrearPersonaVisible = true;
          },
          closeModalCrearPersona() {
            this.ModalCrearPersonaVisible = false;
          },
          //Componenete Modal usado para crear un domicilio para persona cliente, abogado demandado
          showModalDomPersona() {
            this.ModalDomicilioVisible = true;
          },
          closeModalDomPersona() {
            this.ModalDomicilioVisible = false;
          },
          //Componenete Modal usado para poder agregar los Recibo a la respectiva persona
          showModalRecibo(deligencia) {
            this.idxDeligencia = deligencia;
            this.ModalReciboVisible = true;
          },
          closeModalRecibo() {
            this.ModalReciboVisible = false;
          },
          //Componenete Modal usado para poder agregar los Aranceles a la respectiva persona
          /*showModalArancel() {
            this.ModalArancelVisible = true;
          },
          closeModalArancel() {
            this.ModalArancelVisible = false;
          },*/
          //Metodos para mostrar el component modal de los Email
          showModalEmail(deligencia) {
            this.idxDeligencia = deligencia;
            this.ModalEmailVisible = true;
          },
          closeModalEmail() {
            this.ModalEmailVisible = false;
          },
          //Metodos para mostrar el component modal para crear la cedula
          showModalCedula(deligencia) {
            this.idxDeligencia = deligencia;
            this.ModalCedulaVisible = true;            
          },
          closeModalCedula() {
            this.ModalCedulaVisible = false;
          },
          //Metodos para mostrar el component modal para crear estampado
          showModalEstampado(deligencia) {
            this.idxDeligencia = deligencia;
            this.ModalEstampadoVisible = true;            
          },
          closeModalEstampado() {
            this.ModalEstampadoVisible = false;
          },
          //Metodo para mostrar el component modal para crear una gestión
          showModalCrearGestion(deligencia) {
            this.idxDeligencia = deligencia;
            this.ModalCreateGestionVisible = true;            
          },
          closeModalCrearGestion() {
            this.ModalCreateGestionVisible = false;
          },
          //Metodo para mostrar el component modal menu para gestión
          showModalMenuGestion(deligencia) {
            this.idxDeligencia = deligencia;
            this.ModalMenuGestionVisible = true;
          },
          closeModalMenuGestion() {
            this.ModalMenuGestionVisible = false;
          },
          sendModalPersonas(cliente_idx,abogado_idx,demandado_idx){
              this.$store.dispatch('personas/loadAllPersonasRecibo',{ 
                cliente_idx : cliente_idx,
                abogado_idx : abogado_idx,
                demandado_idx : demandado_idx});
          },
          tieneRecibo(deligencia_idx){
            return this.recibos.find(i => i.deligencia_id === deligencia_idx)
          },
          //CRUD (crear)
          createDeligencia(){
            this.$Progress.start();

              this.$store.dispatch('deligencias/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  $('#addNew').modal('hide');
                  this.getDeligencias();

                  Toast.fire({
                        icon: 'success',
                        title: response.data.message
                    });
                  this.$Progress.finish();
                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });

                  this.$Progress.failed();
                }
              })
              .catch((e)=>{
                  console.log(e);
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              })
            

          },
          //CRUD (editar)
          updateDeligencia(){
              this.$Progress.start();
              this.$store.dispatch('deligencias/edit', this.form)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  this.getDeligencias();
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
              })
              .catch(() => {
                  this.$Progress.fail();
              });
          },
          //CRUD (eliminar)
          deleteDeligencia(deligencia){
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás recuperar está infor mación!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.$store.dispatch('deligencias/delete', deligencia).then(()=>{
                                        Swal.fire(
                                        'Borrado!',
                                        'La deligencia fue borrada',
                                        'success'
                                        )
                                }).catch((e)=> {
                                    Swal.fire("Failed!", "There was something wronge.", "warning");
                                    console.log(e);
                                });
                         }
                    })
          },
          deleteAllPersona(){
          Swal.fire({
              title: '¿Estás seguro?',
              text: "No podrás recuperar está información!",
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Si, borrar!'
              }).then((result) => {
                  // Send request to the server
                   if (result.value) {
                          this.$store.dispatch('deligencias/deleteAll', this.checked).then(()=>{
                                  Swal.fire(
                                  'Borrado!',
                                  'La persona fue borrada',
                                  'success'
                                  )
                          }).catch((e)=> {
                              Swal.fire("Failed!", "There was something wronge.", "warning");
                              console.log(e);
                          });
                   }
              })
        },
        getDeligencias(){
            this.$store.dispatch('deligencias/searchDeligencia', {
              searchQuery: this.searchQuery,
              initial: this.initial,
              sort_direction: this.sort_direction,
              sort_field: this.sort_field,
              paginate: this.paginate,
              });

          },
        },
        created() {
            this.$Progress.start();

            this.$Progress.finish();
            //setInterval(() => this.loadUsers(), 3000);
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        watch:{
          searchQuery: function (val){
              this.getDeligencias();
          },
          paginate: function(val) {
            this.getPersonas();
          },
          selectPage: function(value){
            this.checked = [];
            if(value){
                this.deligencias.forEach(deligencia => {
                    this.checked.push(deligencia.id);
                });
            }else{
                this.checked = [];
                this.selectAll = false;
            }
          },
        },
        mounted() {
            //this.$store.dispatch('deligencias/loadAll');
            this.getDeligencias();
            this.$store.dispatch('personas/loadAllClientesAbogados',{ 
                searchQuery : this.searchQueryDemandado});
            this.$store.dispatch('personas/loadAllDemandados',{ 
                searchQuery : this.searchQueryDemandado});
            this.$store.dispatch('paramDeligencias/loadAllEncargos');
            this.$store.dispatch('paramDeligencias/loadAllMaterias');
            this.$store.dispatch('paramDeligencias/loadAllTribunales');
            this.$store.dispatch('paramDeligencias/loadAllTipoCuadernos');
            this.$store.dispatch('recibos/loadAll');
            console.log('Componente deligencias montado.')
            
        },
        computed:{
          ...mapState({
              deligencias: state  => state.deligencias.deligencias,
              pagination: state   => state.deligencias.pagination,
              clientes_abogados: state     => state.personas.clientes_abogados,
              demandados: state   => state.personas.demandados,
              encargos: state     => state.paramDeligencias.encargos,
              materias: state     => state.paramDeligencias.materias,
              tribunales: state   => state.paramDeligencias.tribunales,
              tipoCuadernos: state   => state.paramDeligencias.tipoCuadernos,
              aranceles: state    => state.aranceles.aranceles,
              recibos: state      => state.recibos.recibos,
              grupo_aranceles: state => state.grupoAranceles.grupo_aranceles,

          }),
          //Funciones para la paginación de las deligencias.
          isActived: function() {
            return this.pagination.current_page;
          },
          pagesNumber: function() {
            if(!this.pagination.to){
              return [];
            }

            var from = this.pagination.current_page - this.offset; 
            if(from < 1){
              from = 1;
            }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){
              to = this.pagination.last_page;
            }

            var pagesArray = [];
            while(from <= to){
              pagesArray.push(from);
              from++;
            }
            return pagesArray;
          },
        },
    }
</script>
