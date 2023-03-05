<template>
  <div class="modal hide fade" id="modalCrearPersona" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="createPersona()">
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

              </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="close">Cerrar</button>
                      <button v-show="editmode" type="submit" class="btn btn-success">Editar Cliente</button>
                      <button v-show="!editmode" type="submit" class="btn btn-primary">Agregar Cliente</button>
  
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

import { mapState } from 'vuex';

  export default {
    name: 'CrearPersonaModal',
    props: {
      ModalCrearPersonaVisible:{
        Boolean,
      },
    },
    data(){
      return{
        editTipoPersona: false,
        editmode: false,
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
        }),
      }
    },
    methods: {
      //CRUD (crear)
      createPersona(){
            this.$Progress.start();

              this.$store.dispatch('personas/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  $('#modal5').modal('hide');

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
      crearPersonaClean(){
        this.form.reset();
        this.editTipoPersona = false;
      },
      tipoPersona(event) {
        this.editTipoPersona = event.target.value;
      },
      funcionPersona(event) {
        this.editFuncionPersona = event.target.value;
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
      close() {
        this.$emit('close');
      },    
    },
    mounted() {
            this.getGrupoAranceles();
            console.log('Componente Crear Personas montado.')
            
    },
    computed:{
          ...mapState({
              grupo_aranceles: state => state.grupoAranceles.grupo_aranceles,

          }),
    },
    watch: {
        ModalCrearPersonaVisible: function(newtext){
            this.crearPersonaClean();
        },
    },
  };
</script>

