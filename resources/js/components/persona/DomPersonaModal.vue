<template v-if="this.ModalDomicilioVisible">
  <div class="modal hide fade" id="modalDomPersona" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="createDomicilio()">
            <div class="modal-body">
              <div class="form-group" v-if="!this.idxPersona">
                <v-select 
                v-model="form.persona_id" 
                :options="personas" 
                :reduce="personas => personas.id"
                :filterable="false"
                @option:selecting="onSelecting"
                @close="onDeselected" 
                @search="onSearchPersona"
                label="name" 
                placeholder="Seleccione la persona para asignar domicilio" 
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
                              
          <div class="modal-footer">
              <slot name="footer">
              </slot>
              <button
              type="button" 
              class="btn btn-secondary" 
              data-dismiss="modal"
              @click="close">
              
              Cerrar
              
              </button>
            <button type="submit" class="btn btn-primary">Agregar</button>
          </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

  import { mapState } from 'vuex';

  export default {
    name: 'DomPersonaModal',
    props: {
      idxPersona:{
        Number,
      },
      ModalDomicilioVisible:{
        Boolean,
      },
    },
    data(){
      return{
        region_id: 8,
        searchQuery: null,
        sort_direction : 'desc',
        sort_field: 'updated_at',
        paginate: 15,
        fun: null,
        form: new Form({
          id: '',
          dirección: '',
          numero: '',
          complemento: '',
          comuna: '',
          region: 8,
          obs: '',
          persona_id: '',
        }),
      }
    },
    methods: {
      getComunas(){
          this.$store.dispatch('domicilios/loadAllComunas', this.region_id); 
      },
      onSearchPersona(query) {
        if(!this.selecting){
          this.$store.dispatch('personas/searchPersona', {
                searchQuery: query,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
          });            
        }else{
          this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
          });    
        }
      },

      onSelecting(e){
        this.selecting = true;
      },
      onDeselected(){
        this.selecting = false;
      },
      /* getPersonas(){
            this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
              });
      }, */
      domPersonaClean(){
        this.form.reset();
        this.form.region_id = 8;
        this.searchQuery= null;
        this.sort_direction = 'desc';
        this.sort_field= 'updated_at';
        this.paginate = 15;
        this.fun= null;
      },
      domPersonaFill(){
        if(this.ModalDomicilioVisible){
          this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
          });
          
          if(this.idxPersona){
            this.form.persona_id = this.idxPersona;
          }
        }

      },
      //CRUD (crear)
          createDomicilio(){
            this.$Progress.start();

              this.$store.dispatch('domicilios/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  this.form.reset();
                  $('#modalDomPersona').modal('hide');
                  this.getDiligencia();

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
      close() {
        this.$emit('close');
      },    
      getDiligencia(){
        let searchQuery= null;
        let sort_direction = 'desc';
        let sort_field= 'updated_at';
        let paginate= 15;

        this.$store.dispatch('deligencias/searchDeligencia', {
              searchQuery: searchQuery,
              sort_direction: sort_direction,
              sort_field: sort_field,
              paginate: paginate,
        });
      },    
    },
    mounted() {
        this.getComunas();
        //this.$store.dispatch('domicilios/loadAllRegion');
    },
    computed:
    {
       ...mapState({
            personas: state => state.personas.personas,
            //regiones: state => state.domicilios.regiones,
            comunas: state => state.domicilios.comunas,
          }),
    },
    watch:{
      searchQuery: function (val){
        this.onSearchPersona();
      },
      ModalDomicilioVisible: function(newtext){
            this.domPersonaClean();
            this.domPersonaFill();
      },
    }
  };
</script>

