<template>
  <div class="modal hide fade" id="modalArancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
        </div>
        <form @submit.prevent="createArancel()">
          <div class="modal-body">
            <div class="form-group" v-if="this.grupoArancelProp.id">
                <v-select 
                v-model="form.persona_id" 
                :options="personas" 
                :reduce="personas => personas.id"
                :filterable="false"
                @option:selecting="onSelecting"
                @close="onDeselected" 
                @search="onSearchPersona"
                label="name" 
                placeholder="Seleccione la persona para asignar un arancel" 
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

            <div class="form-group" v-if="ModalArancelVisible">

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
        </form>
      </div>
    </div>
  </div>
</template>

<script>

  import { mapState } from 'vuex';

  export default {
    name: 'ArancelModal',
    props: {
      grupoArancelProp:{
        Object,
      },
      ModalArancelVisible:{
        Boolean,
      },
    },
    data(){
      return{
        searchQuery: null,
        sort_direction : 'desc',
        sort_field: 'updated_at',
        paginate: 15,
        fun: null,
        form: new Form({
          name: '',
          valor: '',
          persona_id: '',
        }),
      }
    },
    methods: {
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
      getPersonas(){
            this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
              });
      },
      arancelPersonaClean(){
        this.form.reset();
        this.searchQuery= null;
        this.sort_direction = 'desc';
        this.sort_field= 'updated_at';
        this.paginate = 15;
        this.fun= null;
      },
      arancelPersonaFill(){
        if(this.ModalArancelVisible){
          this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
          });

          this.$store.dispatch('paramAranceles/loadAllTipoArancel');

          if(this.grupoArancelProp.id){
            this.form.persona_id = this.grupoArancelProp.id; 
          }
        }

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
      createArancel(){
            this.$Progress.start();
              this.$store.dispatch('aranceles/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  this.form.reset();
                  $('#modalArancel').modal('hide');
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
    },
    computed:
    {
       ...mapState({
            personas: state => state.personas.personas,
            tipoAranceles: state => state.paramAranceles.tipoAranceles,
          }),
    },
    watch:{
      searchQuery: function (val){
        this.onSearchPersona();
      },
      ModalArancelVisible: function(newtext){
            this.arancelPersonaClean();
            this.arancelPersonaFill();
      },
    }
  };
</script>

