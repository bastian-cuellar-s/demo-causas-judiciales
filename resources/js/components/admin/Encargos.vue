<template>
<section class="content">
    <div class="container-fluid">
    <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Lista de Tipos de Encargo</h3>
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
                        <th>Ruta</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="encargo in encargos" :key="encargo.id">
                    <td>{{encargo.id}}</td>
                    <td>{{encargo.name}}</td>
                    <td>{{encargo.path}}</td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-1" data-placement="top" @click="deleteEncargo(encargo)" title="Delete"><i class="fa fa-trash"></i></button>
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
                          <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Agregar nuevo Encargo</h5>
                          <h5 class="modal-title" v-show="editmode" id="addNewLabel">Editar información del Encargo</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <form @submit.prevent="editmode ? updateEncargo() : createEncargo()" enctype="multipart/form-data">
                      <div class="modal-body">
                              
                              <!--<div class="form-group">
                                <input v-model="form.name" type="text" name="name"
                                  placeholder="Nombre del encargo"
                                  class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                <has-error :form="form" field="name"></has-error>
                              </div>-->

                              <div class="form-group">
                                <input type="file" class="form-control" v-on:change="onChange">
                              </div>
                              
                              </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Encargo</button>
                                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Encargo</button>
                  
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
            name: '',
            file: '',
            success: ''
          }
        },
        methods: {
          onChange(e){
            this.file = e.target.files[0];
          },
          createEncargo(e){
            this.$Progress.start();
            //e.preventDefault();
            //let existingObj = this;
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
            }
            let data = new FormData();
            data.append('file', this.file);

              this.$store.dispatch('paramDeligencias/createEncargo', data, config)
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
          /*updateEncargo(){
              this.$Progress.start();
              this.$store.dispatch('paramDeligencias/editEncargo', this.form)
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
          },*/
          /*editModal(encargo){
                this.editmode = true;
                //this.reset();
                this.file='';
               $('#addNew').modal('show');
                this.form.fill(encargo);
          },*/
          newModal(){
                this.editmode = false;
                //this.reset();
                this.file='';
                $('#addNew').modal('show');
          },
          deleteEncargo(encargo){
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
                                this.$store.dispatch('paramDeligencias/deleteEncargo', encargo).then(()=>{
                                        Swal.fire(
                                        'Borrado!',
                                        'El Encargo fue borrado',
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
            
            
        },
        mounted() {
        this.$Progress.start();
          this.$store.dispatch('paramDeligencias/loadAllEncargos');
        this.$Progress.finish();
        },
        computed:{
           
          ...mapState({
              encargos: state => state.paramDeligencias.encargos,
          }),
         
          },
        }
</script>