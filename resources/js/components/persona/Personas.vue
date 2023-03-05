
<template>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">               
                <h3 class="card-title">Lista de Clientes</h3>

                <div class="card-tools">
                  <div class="btn">
                    <div class="input-group">                                  
                      <label for="fun" class="text-nowrap mr-2 mb-0"
                          >Funcion</label
                      >
                      <select
                          v-model="fun"
                          class="form-control-sm"
                      >
                          <option value="">Todos</option>
                          <option value="cliente">Cliente</option>
                          <option value="abogado">Abogado</option>
                          <option value="demandado">Demandado</option>
                      </select>                              
                    </div>
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
                        
                        
                <div class="btn">
                  <button v-if="checked.length > 0"
                      class="btn btn-danger"
                      @click="deleteAllPersona"
                  >
                     Eliminar [{{ checked.length }}] registros
                  </button>
                </div>

                  <button class="btn btn-success" @click="newModal">Agregar<b> </b><i class="fas fa-user-plus fa-fw"></i></button>
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
                        <a href="#" @click.prevent="change_sort('name')">Nombre</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('rut')">Rut</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'rut'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'rut'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('email')">Email</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'email'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'email'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('telefono')">Telefono</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'telefono'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'telefono'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('tipo_persona')">Tipo de persona</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'tipo_persona'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'tipo_persona'">&darr;</span>
                      </th>
                      <th>
                        <i class="fas fa-exclamation text-danger"></i>
                      </th>
                      <th>                          
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="persona in personas" :key="persona.id">

                    <td>
                      <input type="checkbox" :value="persona.id" v-model="checked"/>
                    </td>

                    <td>{{persona.name | truncate(20, '...')}}</td>
                    <td>{{persona.rut}}</td>
                    <td>{{persona.email}}</td>
                    <td>{{persona.telefono}}</td>
                    <td>{{persona.tipo_persona | upText }}</td>
                    <td>
                      <ul class="list-inline m-0">
                        <li class="list-inline-item">
                          <div v-if="persona.domicilio">
                            <i v-if="persona.domicilio.length ==0" class="fas fa-house-damage"></i>
                          </div>
                          <div v-if="persona.arancel">
                            <i v-if="persona.arancel.length ==0" class="fas fa-receipt"></i>
                          </div>
                        </li>
                      </ul>
                    </td>
                    <td>
                      <ul class="list-inline m-0">
                        <li class="list-inline-item">                      
                          <div class="dropdown">
                                <button class="btn btn-primary" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fab fa-elementor"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                  <router-link :to="{name: 'DomPersonas', params: {p_id: persona.id, p_name: persona.name}}">
                                      <button class="btn btn-secondary btn-sm rounded-1 dropdown-item"><i class="fas fa-house-user"> Domicilios</i></button>
                                  </router-link>
                                </div>
                          </div>
                        </li>
                        <li class="list-inline-item">                     
                          <div class="dropdown">
                                <button class="btn btn-success" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-plus-circle"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                  <button 
                                    class="btn btn-secondary btn-sm rounded-1 dropdown-item" 
                                    data-toggle="modal" 
                                    data-target="#modalDomPersona"
                                    @click="showModalDomPersonaModal(persona.id)">
                                    <i class="fas fa-house-user">Domicilio</i>
                                  </button>
                                </div>
                          </div>
                        </li>
                        <li class="list-inline-item">                      
                          <div class="dropdown">
                                <button class="btn btn-secondary" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-tools"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                  <button class="btn btn-success btn-sm rounded-1 dropdown-item" data-placement="top" @click="editModal(persona)" title="edit"><i class="fa fa-edit"> Editar</i></button>
                                  <button class="btn btn-danger btn-sm rounded-1 dropdown-item" data-placement="top" @click="deletePersona(persona)" title="Delete"><i class="fa fa-trash"> Borrar</i></button>
                                  <router-link :to="`/personas/${persona.id}`">
                                      <button class="btn btn-secondary btn-sm rounded-1 dropdown-item"><i class="fas fa-address-card"> Informacion</i></button>
                                  </router-link>
                                </div>
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
              <!--<div class="card-footer">
                  <pagination :data="personas" @pagination-change-page="getResults"></pagination>
              </div>-->
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!--Modal Agregar Aranceles y quizás Domicilio-->
          <!--<div>
            <ArancelModal
                  v-show="ModalArancelVisible"
                  @close="closeModalArancel"
                  :idxPersona="idxPersona"
                  :ModalArancelVisible="ModalArancelVisible"
                >
                  <template v-slot:header>
                    Agregar Arancel
                  </template>

                  <template v-slot:body>
                    This is a new modal body.
                  </template>

                  <template v-slot:footer>
                  </template>
                </ArancelModal>
          </div>-->
          <!--Modal Agregar Aranceles y quizás Domicilio-->
          <div>
            <DomPersonaModal
                  v-show="ModalDomicilioVisible"
                  @close="closeModalDomPersonaModal"
                  :idxPersona="idxPersona"
                  :ModalDomicilioVisible="ModalDomicilioVisible"
                >
                  <template v-slot:header>
                    Agregar Arancel
                  </template>

                  <template v-slot:body>
                    This is a new modal body.
                  </template>

                  <template v-slot:footer>
                  </template>
                </DomPersonaModal>
          </div>
            <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar nuevo Cliente</h5>
                          <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar información del Cliente</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form @submit.prevent="editmode ? updatePersona() : createPersona()">
                      <div class="modal-body">

                              <div class="form-group">
                                <label class="typo__label">Tipo de Persona</label>
                              </div>
                              <div class="form-row rounded border">
                                <div class="col-sm-1"></div> 
                              <div class="col-sm-4 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" @change="tipoPersona($event)" 
                                v-model="form.tipo_persona" id="juridica" value="juridica" name="tipoPersonaJuridica"
                                :class="{ 'is-invalid': form.errors.has('tipo_persona') }">
                                <has-error :form="form" field="tipo_persona"></has-error>
                                <label class="custom-control-label" for="juridica">Persona Juridica</label>
                              </div>

                              <!-- Default inline 2-->
                              <div class="col-sm-4 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" @change="tipoPersona($event)" 
                                v-model="form.tipo_persona" id="natural" value="natural" name="tipoPersonaNatural"
                                :class="{ 'is-invalid': form.errors.has('tipo_persona') }">
                                <has-error :form="form" field="tipo_persona"></has-error>
                                <label class="custom-control-label" for="natural">Persona Natural</label>
                              </div>
                              </div>

                              <div class="form-group">
                              </div>   

                              <div class="form-group">
                                <label class="typo__label">Funcion de la Persona</label>
                              </div>
                              <div class="form-row rounded border"> 
                              <div class="col-sm-1"></div>
                              <div class="col-sm-3 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" @change="funcionPersona($event)" 
                                v-model="form.funcion" value="cliente" id="cliente" name="funcionCliente"
                                :class="{ 'is-invalid': form.errors.has('funcion') }">
                                <has-error :form="form" field="funcion"></has-error>
                                <label class="custom-control-label" for="cliente">Cliente</label>
                              </div>

                              <!-- Default inline 2-->
                              <div class="col-sm-3 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" @change="funcionPersona($event)" 
                                v-model="form.funcion" id="abogado" value="abogado" name="funcionAbogado"
                                :class="{ 'is-invalid': form.errors.has('funcion') }">
                                <has-error :form="form" field="funcion"></has-error>
                                <label class="custom-control-label" for="abogado">Abogado</label>
                              </div>

                              <!-- Default inline 3-->
                              <div class="col-sm-3 custom-control custom-radio custom-control-inline">
                                <input type="radio" class="custom-control-input" @change="funcionPersona($event)" 
                                v-model="form.funcion" id="demandado" value="demandado" name="funcionDemandado"
                                :class="{ 'is-invalid': form.errors.has('funcion') }">
                                <has-error :form="form" field="funcion"></has-error>
                                <label class="custom-control-label" for="demandado">Demandado</label>
                              </div>
                              </div>                          

                              <div class="form-group">
                              </div>

                              <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                  placeholder="Nombre"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" required>
                                <has-error :form="form" field="name"></has-error>
                              </div>

                              <!--<div class="form-group">

                                  <label >Funciones del Usuario</label>
                                  
                                  <v-select 
                                  multiple 
                                  v-model="form.funciones"
                                  label="name"
                                  :options="funcionPersonas">
                                  <template v-slot:option="option">
                                      {{ option.name }}
                                  </template>
                                  </v-select>

                              </div>-->                          

                              <div class="form-group" v-show="!(editTipoPersona=='juridica')">
                                <input v-model="form.APaterno" type="text" name="APaterno"
                                  placeholder="Apellido Paterno"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('APaterno') }">
                                <has-error :form="form" field="APaterno"></has-error>
                              </div>

                              <div class="form-group" v-show="!(editTipoPersona=='juridica')">
                                <input v-model="form.AMaterno" type="text" name="AMaterno"
                                  placeholder="Apellido Materno"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('AMaterno') }">
                                <has-error :form="form" field="AMaterno"></has-error>
                              </div>
                              

                              <div class="form-group">
                                <input v-model="form.rut" type="text" name="user[rut]"
                                  placeholder="Rut"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('rut') }" v-rut:live> 
                                  <has-error :form="form" field="rut"></has-error>                                
                              </div>
                              
                              
                              <div class="form-group">
                              <input v-model="form.email" type="email" name="email"
                                  placeholder="Email Address"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                              <has-error :form="form" field="email"></has-error>
                              </div>

                              <div class="form-group">
                                <input v-model="form.telefono" type="tel" id="phone" name="telefono" 
                                placeholder="+569 12345678" 
                                class="form-control" :class="{ 'is-invalid': form.errors.has('telefono') }">
                                <has-error :form="form" field="telefono"></has-error>
                              </div>

                              <div class="form-group">
                                  <textarea v-model="form.obs" name="Comentarios" id="obs"
                                  placeholder="Comenatios del Cliente(Opcional)"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('obs') }"></textarea>
                                  <has-error :form="form" field="obs"></has-error>
                              </div>
                              
                              <div class="form-group" v-show="(editTipoPersona=='juridica')">
                                  <input v-model="form.representante" name="Representante" id="representante"
                                  placeholder="Representante Legal"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('representante') }">
                                  <has-error :form="form" field="representante"></has-error>
                              </div>

                              <div class="form-group">
                                <label>Grupo de aranceles</label>
                                <v-select 
                                v-model="form.g_arancel_id" 
                                :options="grupo_aranceles" 
                                :reduce="grupo_aranceles => grupo_aranceles.id"
                                label="name" 
                                placeholder="Seleccione el grupo de aranceles" >
                                  <template #selected-option="{ name, obs }">
                                    <div style="display: flex; align-items: baseline;">
                                    <strong>{{ name }}</strong>&nbsp;
                                    <em style="margin-left: .5rem;"> - [{{ obs | truncate(10, '...') }}]</em>
                                    </div>
                                  </template>
                                  <template v-slot:option="option">
                                      <strong>{{ option.name }}</strong>&nbsp; - [{{option.obs | truncate(10, '...')}}]
                                  </template>
                                </v-select>
                              </div>


                              <!--<div class="form-group" v-show="!(editFuncionPersona=='abogado')">

                                  <label >Abogado del Cliente</label>
                                  
                                  <v-select multiple v-model="form.abogado" label="name" :options="abogados">
                                  <template v-slot:option="option">
                                      {{ option.name }} - [{{option.rut}}]
                                  </template>
                                  </v-select>

                              </div>-->

                              </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Cliente</button>
                                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Cliente</button>
                  
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
//import ArancelModal from '../../components/arancel/ArancelModal.vue';
import DomPersonaModal from '../../components/persona/DomPersonaModal.vue';


    export default {
        components:{
          //ArancelModal,
          DomPersonaModal,
        },
        data(){
          return{
            editmode: false,
            editTipoPersona: false,
            editFuncionPersona: false,
            //ModalArancelVisible: false,
            ModalDomicilioVisible: false,
            idxPersona: 0,
            searchQuery: null,
            searchAbogado: null,
            sort_direction : 'desc',
            sort_field: 'updated_at',
            offset: 3,
            initial: 1,
            paginate: 15,
            fun: null,
            checked: [],
            selectPage : false,
            selectAll : false,
            form: new Form({
                id: '',
                name: '',
                APaterno: '',
                AMaterno: '',
                rut: '',
                email: '',
                telefono: '',
                obs: '',
                funcion: '',
                tipo_persona: '',
                representante: '',
                g_arancel_id: '',
                //funciones: [],
                //abogado: [],
            }),
          }
        },
        methods: {
          //Metodo para rellenar los id en checked
          selectAllRecords(){
              axios.get('/api/personas/all/')
              .then(response => {
                  this.checked = response.data;
                  this.selectAll = true;
              }).catch((e)=>{
                  console.log(e);
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
              });
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
            this.getPersonas();
          },
          //Metodo para la paginacion
          changePage: function(page) {
            this.$store.dispatch('personas/pagination', page);
            this.$store.dispatch('personas/searchPersona', 
            {
              searchQuery: this.searchQuery,
              page:page
            });
          },
          //Metodo para la paginacion
          incrementPagination(){
              this.$store.dispatch('personas/incrementPagination');
              return this.pagination.current_page;
          },
          //Metodo para la paginacion
          decrementPagination(){
              this.$store.dispatch('personas/decrementPagination');
              return this.pagination.current_page;
          },
          funcionPersona(event) {
                this.editFuncionPersona = event.target.value;
          },
          tipoPersona(event) {
                this.editTipoPersona = event.target.value;
          },
          //Metodo para vue-select
          getIndex (item) {
              console.log(item.findIndex(i => i.id === 1))
              return item.findIndex(i => i.id === 1);
          },
          //Metodo para vue-select
          addTag (newTag) {
              const tag = {
                name: newTag,
                code: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
              }
              this.abogados.push(tag)
              this.form.abogados.push(tag)
          },
          //Metodo para vue-select
          nameWithLang ({ name, rut }) {
              return `${name} — [${rut}]`
          },
          //MODALES                  
          //Modal perteneciente a el componente Personas que se usa para agregar y modificar a la entidad Personas
          editModal(persona){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal({backdrop: 'static', keyboard: false}, 'show');
                this.editFuncionPersona = persona.funcion;
                this.editTipoPersona = persona.tipo_persona;
                this.form.fill(persona);
          },
          newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal({backdrop: 'static', keyboard: false}, 'show');
          },
          //Componenete Modal usado para poder agregar los Aranceles a la respectiva persona
          showModalArancel(persona_id) {
            this.ModalArancelVisible = true;
            this.idxPersona = persona_id;
          },
          closeModalArancel() {
            this.ModalArancelVisible = false;
          },
          sendModalPersona(persona){
            this.idxPersona = persona;
          },
          //Componenete Modal usado para poder agregar los Aranceles a la respectiva persona
          showModalDomPersonaModal(persona_id) {
            this.ModalDomicilioVisible = true;
            this.idxPersona = persona_id;
          },
          closeModalDomPersonaModal() {
            this.ModalDomicilioVisible = false;
          },
          //Llamada al store para obtener los registros del componente
          getPersonas(){
            this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
              });
          },
          getGrupoAranceles(){
            let sort_direction = 'desc';
            let sort_field= 'updated_at';
            let paginate= 15;

            this.$store.dispatch('grupoAranceles/searchGrupoArancel', {
                sort_direction: sort_direction,
                sort_field: sort_field,
                paginate: paginate,
              });
          },
          //CRUD (crear)
          createPersona(){
            this.$Progress.start();

              this.$store.dispatch('personas/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  $('#addNew').modal('hide');

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
          updatePersona(){
              this.$Progress.start();
              this.$store.dispatch('personas/edit', this.form)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
              })
              .catch((e) => {
                  console.log(e);
                  this.$Progress.fail();
              });
          },
          //CRUD (eliminar)
          deletePersona(persona){
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
                                this.$store.dispatch('personas/delete', persona).then(()=>{
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
                          this.$store.dispatch('personas/deleteAll', this.checked).then(()=>{
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
        }
        },   
        created() {
            this.$Progress.start();

            this.$Progress.finish();
            //setInterval(() => this.loadUsers(), 3000);
        },
        mounted() {
            this.$store.dispatch('personas/loadAllAbogados',{
              searchQuery: this.searchAbogado
            });
            //this.$store.dispatch('personas/loadAll', this.initial);
            this.getPersonas();
            this.getGrupoAranceles();
            this.$store.dispatch('paramAranceles/loadAllTipoArancel');
            console.log('Componente Personas montado.')            
        },
        watch:{
          searchQuery: function (val){
              this.getPersonas();
          },
          paginate: function(val) {
            this.getPersonas();
          },
          fun: function(val) {
            this.getPersonas();
          },
          selectPage: function(value){
            this.checked = [];
            if(value){
                this.personas.forEach(persona => {
                    this.checked.push(persona.id);
                });
            }else{
                this.checked = [];
                this.selectAll = false;
            }
          },
        },
        computed:{
          ...mapState({
            personas: state => state.personas.personas,
            pagination: state => state.personas.pagination,
            abogados: state => state.personas.abogados,
            grupo_aranceles: state => state.grupoAranceles.grupo_aranceles,
          }),
          //Funciones para la paginación de las personas.
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
          }
        },
    }
</script>
