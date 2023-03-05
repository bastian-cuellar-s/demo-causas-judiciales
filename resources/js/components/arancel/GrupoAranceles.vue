<template>
    <section class="content">
        <div class="container-fluid">
        <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
    
                    <h3 class="card-title">Lista Grupo Aranceles</h3>
    
                    <div class="card-tools">
                                            
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
                        <button class="btn btn-success" @click="newModal">Agregar<b> </b><i class="fas fa-user-plus fa-fw"></i></button>
                    </div>
    
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                      <thead>
                        <tr>
                          <th>
                            <a href="#" @click.prevent="change_sort('name')">Nombre</a>
                            <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                            <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                          </th>
                          <th>
                            <a href="#" @click.prevent="change_sort('obs')">Observaciones</a>
                            <span v-if="sort_direction == 'desc' && sort_field == 'obs'">&uarr;</span>
                            <span v-if="sort_direction == 'asc' && sort_field == 'obs'">&darr;</span>
                          </th>
                          <th>                          
                                <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="grupo_arancel in grupo_aranceles" :key="grupo_arancel.id">
                        
                        <td>{{grupo_arancel.name}}</td>
                        <td>{{grupo_arancel.obs | truncate(10,'...')}}</td>
                        <td>
                            <ul class="list-inline m-0">
                                <!--<li class="list-inline-item">
                                  <button type="button" 
                                  class="btn btn-secondary col-mb-1"
                                  data-toggle="modal" 
                                  data-target="#ModalMenuAranceles"
                                  title="MenuAranceles"
                                  @click="showModalMenuAranceles(grupo_arancel)">
                                    <i class="fas fa-bars"></i>
                                  </button>
                                </li>-->
                                <li class="list-inline-item">
                                <button 
                                    class="btn btn-secondary btn-sm rounded-1" 
                                    data-toggle="modal" 
                                    data-target="#modalArancel"
                                    @click="showModalArancel(grupo_arancel)">
                                    <i class="fas fa-plus-square"></i>
                                </button>
                                </li>
                                <li class="list-inline-item">
                                  <router-link :to="{name: 'Aranceles', params: {p_id: grupo_arancel.id, p_name: grupo_arancel.name}}">
                                      <button class="btn btn-secondary btn-sm rounded-1"><i class="fas fa-clipboard-list"></i></button>
                                  </router-link>
                                </li>
                                <li class="list-inline-item">
                                    <button class="btn btn-success btn-sm rounded-1" data-placement="top" @click="editModal(grupo_arancel)" title="edit"><i class="fa fa-edit"></i></button>
                                </li>
                                <li class="list-inline-item">
                                    <button class="btn btn-danger btn-sm rounded-1" data-placement="top" @click="deleteGrupoArancel(grupo_arancel.id)" title="Delete"><i class="fa fa-trash"></i></button>
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
              <!--<div>
                <ModalMenuAranceles
                      v-show="ModalMenuArancelesVisible"
                      @close="closeModalMenuAranceles"
                      :grupoArancelProp="grupoArancelProp"
                      :ModalMenuArancelesVisible="ModalMenuArancelesVisible"
                >
                
                  <template v-slot:header>
                    Menu Aranceles
                  </template>
                </ModalMenuAranceles>
              </div>-->
              <!--Modal Agregar Aranceles y quizás Domicilio-->
              <div>
                <ArancelModal
                      v-show="ModalArancelVisible"
                      @close="closeModalArancel"
                      :grupoArancelProp="grupoArancelProp"
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
                          <form @submit.prevent="editmode ? updateGrupoArancel() : createGrupoArancel()">
                          <div class="modal-body">
                                                            
                                <div class="form-group">
                                    <input v-model="form.name" type="text" name="name"
                                    placeholder="Nombre del grupo de aranceles"
                                    class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" required>
                                    <has-error :form="form" field="name"></has-error>
                                </div>      
                            
                                <div class="form-group">
                                      <textarea v-model="form.obs" name="Comentarios" id="obs"
                                      placeholder="Comenatios del Cliente(Opcional)"
                                      class="form-control" :class="{ 'is-invalid': form.errors.has('obs') }"></textarea>
                                      <has-error :form="form" field="obs"></has-error>
                                  </div>
                                  
    
                                  </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                          <button v-show="editmode" type="submit" class="btn btn-success">Editar Grupo Arancel</button>
                                          <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Grupo Arancel</button>
                      
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
      //import ModalMenuAranceles from '../../components/arancel/ModalMenuAranceles.vue';
      import ArancelModal from '../../components/arancel/ArancelModal.vue';


    
        export default {
            components:{
              //ModalMenuAranceles,
              ArancelModal,
            },
            name: 'GrupoAranceles',
            data(){
              return{
                editmode: false,
                offset: 3,
                initial: 1,
                searchQuery: null,
                sort_direction : 'desc',
                sort_field: 'updated_at',
                paginate: 15,
                file: '',
                form: new Form({
                    id: '',
                    name: '',
                    obs: '',
                }),
                ModalArancelVisible: false,
                ModalMenuArancelesVisible: false,
                grupoArancelProp: [],
              }
            },
            methods: {
              //metodo para ordenar los datos por campo
              change_sort(field){
                if(this.sort_field == field){
                    this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
                }else{
                    this.sort_field = field;
                }
                this.getGrupoAranceles();
              }, 
              //Metodo para interactuar con el modal donde se edita un arancel
              editModal(grupo_arancel){
                    this.editmode = true;
                    this.form.reset();
                    $('#addNew').modal('show');
                    this.form.fill(grupo_arancel);
              },
              //Metodo para interactuar con el modal donde se crea un arancel
              newModal(){
                    this.editmode = false;
                    this.form.reset();
                    $('#addNew').modal('show');
              },
              newExcelModal(){
                    $('#addExcel').modal('show');
              },
              showModalArancel(grupo_arancel) {
                this.ModalArancelVisible = true;
                this.grupoArancelProp = grupo_arancel;
              },
              closeModalArancel() {
                this.ModalArancelVisible = false;
              },
              showModalMenuAranceles(grupo_arancel) {
                this.grupoArancelProp = grupo_arancel;
                this.ModalMenuArancelesVisible= true;
              },
              closeModalMenuAranceles() {
                this.ModalMenuArancelesVisible = false;
              },
              //Metodos para paginacion
              changePage: function(page) {
                this.$store.dispatch('grupoAranceles/pagination', page);
                this.$store.dispatch('grupoAranceles/searchGrupoArancel', {
                p_id:this.p_id,
                searchQuery: this.searchQuery,
                page:page,
                });
              },
              //Metodo para la paginacion
              incrementPagination(){
                  this.$store.dispatch('grupoAranceles/incrementPagination');
                  return this.pagination.current_page;
              },
              //Metodo para la paginacion
              decrementPagination(){
                  this.$store.dispatch('grupoAranceles/decrementPagination');
                  return this.pagination.current_page;
              },
              //Llamada al store para obtener los registros del componente
              getGrupoAranceles(){
                this.$store.dispatch('grupoAranceles/searchGrupoArancel', {
                    searchQuery: this.searchQuery,
                    page:this.initial,
                    sort_direction: this.sort_direction,
                    sort_field: this.sort_field,
                    paginate: this.paginate,
                    });
              },
              //CRUD (crear)
              createGrupoArancel(){
                this.$Progress.start();
    
                  this.$store.dispatch('grupoAranceles/create', this.form)
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
              updateGrupoArancel(){
                  this.$Progress.start();
                  this.$store.dispatch('grupoAranceles/edit', this.form)
                  .then((response) => {
                      $('#addNew').modal('hide');
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
              deleteGrupoArancel(arancel){
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
                                    this.$store.dispatch('grupoAranceles/delete', arancel).then(()=>{
                                            Swal.fire(
                                            'Borrado!',
                                            'El Grupo Arancel fue borrado',
                                            'success'
                                            )
                                    }).catch((e)=> {
                                        Swal.fire("Failed!", "There was something wronge.", "warning");
                                        console.log(e);
                                    });
                             }
                        })
              },
            },
            filters: {
                truncate: function (text, length, suffix) {
                  if(!text){
                    return;
                  }
                  return text.substring(0, length) + suffix;
                },
            },
            mounted() {
                this.getGrupoAranceles();
            },
            watch:{
              searchQuery: function (val){
                  this.getGrupoAranceles();
              },
              paginate: function(val) {
                this.getGrupoAranceles();
              },
            },
            computed:{
               
              ...mapState({
                grupo_aranceles: state => state.grupoAranceles.grupo_aranceles,
                pagination: state => state.grupoAranceles.pagination,
              }),
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