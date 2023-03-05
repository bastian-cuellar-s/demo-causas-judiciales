<template>
<section class="content" v-if="p_id">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">

                <h3 class="card-title">Lista Aranceles <span v-if="p_id">del Cliente {{p_name}}</span> </h3>

                <div class="card-tools">
                  
                  <button class="btn btn-success" @click="newExcelModal">Agregar Excel<b> </b><i class="fas fa-file-excel"></i></button>
                  
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
                        <a href="#" @click.prevent="change_sort('valor')">Valor</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'valor'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'valor'">&darr;</span>
                      </th>
                      <th>                          
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="arancel in aranceles" :key="arancel.id">
                    
                    <td>{{arancel.name}}</td>
                    <td>{{arancel.valor}}</td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-success btn-sm rounded-1" data-placement="top" @click="editModal(arancel)" title="edit"><i class="fa fa-edit"></i></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-1" data-placement="top" @click="deleteArancel(arancel.id)" title="Delete"><i class="fa fa-trash"></i></button>
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
                      <form @submit.prevent="editmode ? updateArancel() : createArancel()">
                      <div class="modal-body">
                            <div class="form-group">

                                <v-select 
                                v-model="form.name" 
                                :options="tipoAranceles" 
                                :reduce="tipoAranceles => tipoAranceles.name"
                                label="name"
                                placeholder="Seleccione el Arancel" >
                                </v-select>
                            
                            </div>

                            <div class="form-group">
                                <input v-model="form.valor" type="tel" id="valor" name="valor" 
                                placeholder="Ingrese el Valor del Arancel" 
                                min="1" pattern="^[0-9]+"
                                class="form-control" :class="{ 'is-invalid': form.errors.has('valor') }" required>
                                <has-error :form="form" field="valor"></has-error>
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
                                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Arancel</button>
                                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Arancel</button>
                  
                                  </div>
                      </form>
                        
                      </div>
                      
                  </div>
                
                </div>
            <div class="modal fade" id="addExcel" tabindex="-1" role="dialog" aria-labelledby="addNewExcelLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar nuevo Cliente</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form @submit.prevent="createArancelExcel()">
                        <div class="modal-body">
                          <div class="form-group">
                            <input type="file" class="form-control" v-on:change="onChange">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                          <button v-show="!editmode" type="submit" class="btn btn-primary">Subir Archivo</button>
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
            region_id: '',
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
                valor: '',
                g_arancel_id: this.p_id,
            }),
          }
        },
        methods: {
          onChange(e){
            this.file = e.target.files[0];
          },
          //metodo para ordenar los datos por campo
          change_sort(field){
            if(this.sort_field == field){
                this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
            }else{
                this.sort_field = field;
            }
            this.getAranceles();
          }, 
          //Metodo para interactuar con el modal donde se edita un arancel
          editModal(arancel){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(arancel);
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
          //Metodos para paginacion
          changePage: function(page) {
            this.$store.dispatch('aranceles/pagination', page);
            this.$store.dispatch('aranceles/searchArancel', {
            p_id:this.p_id,
            searchQuery: this.searchQuery,
            page:page,
            });
          },
          //Metodo para la paginacion
          incrementPagination(){
              this.$store.dispatch('aranceles/incrementPagination');
              return this.pagination.current_page;
          },
          //Metodo para la paginacion
          decrementPagination(){
              this.$store.dispatch('aranceles/decrementPagination');
              return this.pagination.current_page;
          },
          //Llamada al store para obtener los registros del componente
          getAranceles(){
            this.$store.dispatch('aranceles/searchArancel', {
                searchQuery: this.searchQuery,
                p_id:this.p_id,
                page:this.initial,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                });
          },
          createArancelExcel(e){
            this.$Progress.start();
            //e.preventDefault();
            //let existingObj = this;
            console.log
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
            }
            let data = new FormData();
            data.append('file', this.file);
            data.append('g_arancel_id', this.p_id);

              this.$store.dispatch('aranceles/createExcel', data, config)
              .then((response)=>{
                if(response.data.success){
                  $('#addExcel').modal('hide');

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
          //CRUD (crear)
          createArancel(){
            this.$Progress.start();

              this.$store.dispatch('aranceles/create', this.form)
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
          updateArancel(){
              this.$Progress.start();
              this.$store.dispatch('aranceles/edit', this.form)
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
          deleteArancel(arancel){
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
                                this.$store.dispatch('aranceles/delete', arancel).then(()=>{
                                        Swal.fire(
                                        'Borrado!',
                                        'El Arancel fue borrado',
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
                return text.substring(0, length) + suffix;
            },
        },
        mounted() {
            //this.$store.dispatch('aranceles/loadAll', this.p_id);
            this.getAranceles();
            this.$store.dispatch('paramAranceles/loadAllTipoArancel');
        },
        watch:{
          searchQuery: function (val){
              this.getAranceles();
          },
          paginate: function(val) {
            this.getAranceles();
          },
        },
        computed:{
           
          ...mapState({
            aranceles: state => state.aranceles.aranceles,
            pagination: state => state.aranceles.pagination,
            tipoAranceles: state => state.paramAranceles.tipoAranceles,
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