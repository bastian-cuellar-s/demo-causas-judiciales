<template>
  <div class="modal hide fade" id="modalEstampado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
        </div>
        <form @submit.prevent="EstampadoDeligencia(modalGestion)">
          <div class="modal-body">
            <div class="form-group">

            <div class="form-group">
            <label>Demandado</label>
            <v-select v-if="ModalEstampadoVisible"
              v-model="xdemandadoModel"
              :options="idxGestion.deligencia.demandados"
              label="name" 
              placeholder="Seleccione el Demandado" 
              @option:selected="onSelectedDomicilio"
              @input="offSelectedArancel"
              required>
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

            <v-select v-if="this.arrayDomicilio.length>0"
                v-model="xdomicilio"
                :options="arrayDomicilio" 
                label="direccion"
                placeholder="Seleccione el Domicilio" 
                @option:selected="onSelected"
                required>
              <template #selected-option="{ direccion, numero, comuna, region}">
                <div style="display: flex; align-items: baseline;">
                  {{ direccion }} {{ numero }}, {{ comuna }}, {{region}}
                </div>
              </template>
              <template v-slot:option="option">
                  {{ option.direccion }} {{ option.numero }}, {{ option.comuna }}, {{option.region}}
              </template>
              </v-select>
            </div>

          </div>
          <div class="modal-footer">
              <slot name="footer">
              </slot>
              <button
              type="button" 
              class="btn btn-secondary" 
              @click="close">
              
              Cerrar
              
              </button>
            <button v-if="this.modalGestion" type="submit" class="btn btn-primary">Imprimir Estampado</button>
            <!--<button 
              class="btn btn-dark btn-sm rounded-1 dropdown-item" 
              data-placement="top" 
              @click="EstampadoDeligencia(deligencia)" 
              title="Estampado">
              <i class="fas fa-file-invoice"> </i>
              <i v-if="!deligencia.estampe" class="fas fa-times"> Estampado</i>
              <i v-else class="fas fa-check"> Estampado</i>
            </button>-->

          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>

  import { mapState } from 'vuex';

  export default {
    name: 'EstampadoSelectModal',
    props: {
      idxGestion:{
        Object,
      },
      ModalEstampadoVisible:{
        Boolean,
      },
    },
    data(){
      return{
        modalGestion: {},
        arrayDomicilio: [],
        xdomicilio: [],
        xdemandadoModel: [],
      }
    },
    methods: {
      onSelectedDomicilio(e){
        if(e.domicilio){
          this.arrayDomicilio = e.domicilio;
          this.modalGestion.demandado = e;
          //this.estampadoSelectFill(e);
        }else{
          console.log('El cliente no tiene Domicilios');
        }
      },
      offSelectedArancel(e){
        if(!e){
          this.arrayDomicilio = [];
          }
      },
      onSelected(e){
        if(this.modalGestion){
          this.modalGestion.demandado.domicilio = [];
          this.modalGestion.demandado.domicilio.push(e);
        }
      },
      editEstampe(deligencia_id){
            this.$store.dispatch('gestiones/editEstampe', deligencia_id);
      },
      EstampadoDeligencia(gestion){
            
        this.$Progress.start();

            axios.post('api/estampado',
            gestion,
            {responseType: 'blob'})
            .then((response)=>{
              Toast.fire({
                        icon: 'success',
                        title: response.data.message
                });
              $('#modalEstampado').modal('hide');
              this.editEstampe(gestion.id);
              this.getGestion();
              this.close();
              var headers = response.headers;
              console.log(headers)
              var blob = new Blob([response.data], {type: headers['content-type']});
              var link = document.createElement('a');
              link.href = window.URL.createObjectURL(blob);
              link.setAttribute('download', gestion.deligencia.rol+gestion.deligencia.tribunal);
              link.click();
              link.remove()
            }).catch(error=>{
              Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
              });
              if(error){
                console.log(error)
              }
              this.$Progress.failed();
            });

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
      getGestion(){
        let searchQuery= null;
        let sort_direction = 'desc';
        let sort_field= 'updated_at';
        let paginate= 15;

        this.$store.dispatch('gestiones/searchGestion', {
              searchQuery: searchQuery,
              deligencia_id: this.idxGestion.deligencia.id,
              sort_direction: sort_direction,
              sort_field: sort_field,
              paginate: paginate,
        });

      },
      estampadoSelectClean(){
        this.modalGestion = {};
        this.arrayDomicilio = [];
        this.xdomicilio = [];
        this.xdemandadoModel = [];
      },
      estampadoSelectFill(){

        this.modalGestion = structuredClone(this.idxGestion);  
      
      },
      close() {
        $('#modalEstampado').modal('hide');
        this.$emit('close');
      },    
    },
    watch:{
      ModalEstampadoVisible: function(newtext){
            this.estampadoSelectClean();
            this.estampadoSelectFill();
      },
    }
  };
</script>

