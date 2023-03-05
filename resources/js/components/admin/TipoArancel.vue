<template>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Tipos de Arancel</h3>
                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Agregar<b> </b><i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="tipoArancel in tipoAranceles" :key="tipoArancel.id">
                    <td>{{tipoArancel.id}}</td>
                    <td>{{tipoArancel.name}}</td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-success btn-sm rounded-1" data-placement="top" @click="editModal(tipoArancel)" title="edit"><i class="fa fa-edit"></i></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-1" data-placement="top" @click="deleteTipoArancel(tipoArancel)" title="Delete"><i class="fa fa-trash"></i></button>
                            </li>
                        </ul>
                    </td>
                  </tr>
                  </tbody>
                </table>
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
                          <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar nuevo Tipo de Arancel</h5>
                          <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar información del Tipo de Arancel</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form @submit.prevent="editmode ? updateTipoArancel() : createTipoArancel()">
                      <div class="modal-body">
                              
                              <div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                  placeholder="Nombre del Tipo de Arancel"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }" required>
                                <has-error :form="form" field="name"></has-error>
                              </div>
                              
                              </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Tipo de Arancel</button>
                                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Tipo de Arancel</button>
                  
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

    export default {
        data(){
          return{
            editmode: false,
            form: new Form({
                id: '',
                name: '',
            }),
          }
        },
        methods: {
          updateTipoArancel(){
              this.$Progress.start();
              this.$store.dispatch('paramAranceles/editTipoArancel', this.form)
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
          editModal(tipoArancel){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(tipoArancel);
          },
          newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
          },
          deleteTipoArancel(tipoArancel){
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
                                this.$store.dispatch('paramAranceles/deleteTipoArancel', tipoArancel).then(()=>{
                                        Swal.fire(
                                        'Borrado!',
                                        'El Tipo de Arancel fue borrado',
                                        'success'
                                        )
                                }).catch((e)=> {
                                    Swal.fire("Failed!", "There was something wronge.", "warning");
                                    console.log(e);
                                });
                         }
                    })
          },
          createTipoArancel(){
            this.$Progress.start();

              this.$store.dispatch('paramAranceles/createTipoArancel', this.form)
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
          }
        },
        created() {
            
            
        },
        mounted() {
        this.$Progress.start();
          this.$store.dispatch('paramAranceles/loadAllTipoArancel');
        this.$Progress.finish();
        },
        computed:{
           
          ...mapState({
              tipoAranceles: state => state.paramAranceles.tipoAranceles,
          }),
         
          },
        }
</script>