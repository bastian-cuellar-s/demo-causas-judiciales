<template>
<section class="content" v-if="p_id">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 flex-grow-1 bd-highlight">
                      <h3 class="card-title">Lista Domicilios <span v-if="p_id">del Cliente {{p_name}}</span> </h3>
                    </div>

                    <div class="p-2 bd-highlight">
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

                    <div class="p-2 bd-highlight">
                      <div class="card-tools">
                          <button class="btn btn-success" @click="newModal">Agregar<b> </b><i class="fas fa-user-plus fa-fw"></i></button>
                      </div>
                    </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>
                        <a href="#" @click.prevent="change_sort('direccion')">Dirección</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'direccion'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'direccion'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('numero')">Numero</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'numero'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'numero'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('comuna')">Comuna</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'comuna'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'comuna'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('region')">Region</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'region'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'region'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('obs')">Comentarios</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'obs'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'obs'">&darr;</span>
                      </th>
                      <th>                          
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="domicilio in domicilios" :key="domicilio.id">
                    
                    <td>{{domicilio.direccion}}</td>
                    <td>{{domicilio.numero}}</td>
                    <td>{{domicilio.comuna}}</td>
                    <td>{{domicilio.region}}</td>
                    <td>{{domicilio.obs | truncate(15, '...')}}</td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-success btn-sm rounded-1" data-placement="top" @click="editModal(domicilio)" title="edit"><i class="fa fa-edit"></i></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-1" data-placement="top" @click="deleteDomicilio(domicilio)" title="Delete"><i class="fa fa-trash"></i></button>
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
                      <form @submit.prevent="editmode ? updateDomicilio() : createDomicilio()">
                      <div class="modal-body">
                              <div class="form-group">
                                <input v-model="form.direccion" type="text" name="dirección"
                                  placeholder="Dirección"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('direccion') }" required>
                                <has-error :form="form" field="direccion"></has-error>
                              </div>

                              <div class="form-group">
                                <input v-model="form.numero" type="numeric" name="numero"
                                  placeholder="Número de la dirección"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('numero') }">
                                <has-error :form="form" field="numero"></has-error>
                              </div>

                              <div class="form-group">
                                <input v-model="form.complemento" type="text" name="complemento"
                                  placeholder="Apartamento. (opcional)"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('complemento') }">
                                <has-error :form="form" field="complemento"></has-error>
                              </div>

                             <!--<div class="form-group">
                                <select name="type" v-model="form.region" class="form-control" 
                                  @change='getComunas($event)'
                                  :class="{ 'is-invalid': form.errors.has('region') }" required>
                                    <option value="" disabled selected hidden>Seleccione Region</option>
                                    <option 
                                    v-for="(region, index) in regiones" :key="index"
                                    :value='region.name'
                                    >{{ region.name }}
                                    </option>
                                </select>
                                <has-error :form="form" field="region"></has-error>
                              </div>-->

                              <!--<div class="form-group">
                                <select name="type" v-model="form.comuna" class="form-control" 
                                  :class="{ 'is-invalid': form.errors.has('comuna') }" required>
                                    <option value="" disabled selected hidden>Seleccione Comuna</option>
                                    <option 
                                    v-for="comuna in comunas" :key="comuna.id"
                                    :value='comuna.name'
                                    >{{ comuna.name }}
                                    </option>
                                </select>
                                <has-error :form="form" field="comuna"></has-error>
                              </div>-->

                              
                              <div class="form-group">

                              <v-select 
                              v-model="form.comuna" 
                              :options="comunas" 
                              :reduce="comunas => comunas.name"
                              label="name" 
                              placeholder="Seleccione Comuna" >
                              </v-select>
                                                
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
                                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Domicilio</button>
                                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Domicilio</button>
                  
                                  </div>
                      </form>
                        
                      </div>
                      
                  </div>
                
                </div>
               </div>  
            </div>
  </section>
  <section v-else>
      <not-found></not-found>
  </section>           
</template>

<script>
    
  import { mapState } from 'vuex';

    export default {
        props:{
            p_id:{
                type: Number,
            },
            p_name:{
              type: String,
            }
        },
        data(){
          return{
            editmode: false,
            region_id: 8,
            offset: 3,
            initial: 1,
            searchQuery: null,
            sort_direction : 'desc',
            sort_field: 'updated_at',
            paginate: 15,
            form: new Form({
                id: '',
                direccion: '',
                numero: '',
                complemento: '',
                comuna: '',
                region: 8,
                obs: '',
                persona_id: this.p_id,
            }),
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
            this.getDomicilios();
          },          
          //Metodo para interactuar con el modal donde se edita un domicilio
          editModal(domicilio){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(domicilio);
          },
          //Metodo para interactuar con el modal donde se crea un domicilio
          newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
          },
          //Metodo para poder seleccionar las comunas de una region
          getComunas(){
              this.$store.dispatch('domicilios/loadAllComunas', this.region_id); 
          },
          //Metodo para la paginacion
          changePage: function(page) {
            this.$store.dispatch('domicilios/pagination', page);
            this.$store.dispatch('domicilios/searchDomicilio', {
            p_id:this.p_id,
            searchQuery: this.searchQuery,
            page:page,
            });
          },
          //Metodo para la paginacion
          incrementPagination(){
              this.$store.dispatch('domicilios/incrementPagination');
              return this.pagination.current_page;
          },
          //Metodo para la paginacion
          decrementPagination(){
              this.$store.dispatch('domicilios/decrementPagination');
              return this.pagination.current_page;
          },
          //Llamada al store para obtener los registros del componente
          getDomicilios(){
            this.$store.dispatch('domicilios/searchDomicilio', {
                searchQuery: this.searchQuery,
                p_id:this.p_id,
                page:this.initial,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                });
          },
          //CRUD (crear)
          createDomicilio(){
            this.$Progress.start();

              this.$store.dispatch('domicilios/create', this.form)
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
          updateDomicilio(){
              this.$Progress.start();
              this.$store.dispatch('domicilios/edit', this.form)
              .then((response) => {
                  // success
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
          deleteDomicilio(domicilio){
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
                                this.$store.dispatch('domicilios/delete', domicilio).then(()=>{
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
        },
        created() {
            this.$Progress.start();

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
              if(text){
                 return text.substring(0, length) + suffix;
              }
            },
        },
        mounted() {
          this.getDomicilios();
          this.getComunas();
          //this.$store.dispatch('domicilios/loadAllRegion');
        },
        watch:{
          searchQuery: function (val){
              this.getDomicilios();
          },
          paginate: function(val) {
            this.getDomicilios();
          },
        },
        computed:{           
          ...mapState({
              domicilios: state => state.domicilios.domicilios,
              pagination: state => state.domicilios.pagination,
              //regiones: state => state.domicilios.regiones,
              comunas: state => state.domicilios.comunas,
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