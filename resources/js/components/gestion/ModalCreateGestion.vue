<template>
  <div class="modal hide fade" id="ModalCreateGestion" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="createGestion()">
          <div class="modal-body">
            <div class="form-group">

              <v-select 
              v-model="form.encargo" 
              :options="encargos" 
              :reduce="encargos => encargos.name"
              label="name" 
              placeholder="Seleccione el Encargo" >
              </v-select>

            </div>

            <div class="form-group">

              <VueCtkDateTimePicker 
                v-model="form.f_notificacion"
                class="DateTimePicker"
                label="Seleccione fecha de notificación y hora"
                format="YYYY-MM-DD HH:mm"
                noLabel
                buttonNowTranslation="Hoy"
              ></VueCtkDateTimePicker>

            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">

                  <v-select 
                  v-model="form.cuaderno" 
                  :options="tipoCuadernos" 
                  :reduce="tipoCuadernos => tipoCuadernos.name"
                  label="name" 
                  placeholder="Seleccione Cuaderno" >
                  </v-select>
                                    
                </div>
              </div>
              <div class="col">
                <div class="form-group">

                  <VueCtkDateTimePicker 
                    v-model="form.f_estampado"
                    class="DatePicker"
                    label="Fecha Estampado"
                    format="YYYY-MM-DD"
                    noLabel
                    formatted= "ll"
                    only-date
                    buttonNowTranslation="Hoy"
                  ></VueCtkDateTimePicker>

                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="col">
                <div class="form-group">
                  <input v-model="form.folio" type="number" name="folio"
                    placeholder="Folio"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('folio') }">
                  <has-error :form="form" field="folio"></has-error>
                </div>
              </div>
              <div class="col">
                <div class="form-group">
                  <input v-model="form.deuda" type="number" name="deuda"
                    placeholder="Deuda"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('deuda') }">
                  <has-error :form="form" field="deuda"></has-error>
                </div>
              </div>
            </div>

            <div class="form-group">
              <textarea v-model="form.resultado" name="Resultado" id="resultado"
              placeholder="Resultados sobre la diligencia"
              class="form-control" :class="{ 'is-invalid': form.errors.has('resultado') }"></textarea>
              <has-error :form="form" field="resultado"></has-error>
            </div>

            <div class="container col-12">
              <label>Fechas</label>
              <div class="form-row"> 
                <div class="form-group col-md-5">
                    <input v-model="xfecha_name" type="text" name="nombre_fecha"
                    placeholder="Nombre de la fecha"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre_fecha') }">
                  <has-error :form="form" field="nombre_fecha"></has-error>
                </div>
                <div class="form-group col-md-6">
                  <VueCtkDateTimePicker 
                  v-model="xfecha"
                  class="DatePicker"
                  label="Seleccione fecha"
                  format="DD-MM-YYYY"
                  noLabel
                  input-size="sm"
                  formatted= "ll"
                  only-date
                  buttonNowTranslation="Hoy"
                  ></VueCtkDateTimePicker>
                  <has-error :form="form" field="xfecha"></has-error>                             
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-success col-mb-1" @click="add"><i class="fas fa-plus"></i></button>                  
                </div>

              </div>
            </div>

            
          </div>

          <table v-if="form.fechas.length > 0" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>
                  Nombre
                </th>
                <th>
                  Fecha 
                </th>
                <th>
                  <i class="fas fa-tasks"></i>
                </th>
              </tr>
            </thead>
             <tbody>
                <tr v-for="(fecha, index) in form.fechas" :key="index">
                <td>{{fecha.name}}</td>
                <td>{{fecha.fecha | formatDate}}</td>
                <td>
                  <button v-if="form.fechas.length > 0" @click="remove(index)" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                </td>
                </tr>
            </tbody>
          </table>

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
    name: 'ModalCreateGestion',
    props: {
      idxDeligencia:{
        Object,
      },
      ModalCreateGestionVisible:{
        Boolean,
      },
    },
    data(){
      return{
        xfecha_name: '',
        xfecha: '',
        form: new Form({
          encargo: '',
          cuaderno: '',
          folio: '',
          deuda: '',
          f_estampado: '',
          f_notificacion: '',
          deligencia_id: '',
          fechas: [],
        }),
      }
    },
    methods: {
      add() {
        this.form.fechas.push({name: this.xfecha_name, fecha: this.xfecha});
        this.xfecha_name = '';
        this.xfecha = '';
      },
      remove(index) {
        this.form.fechas.splice(index,1);
      },
      gestionCreateClean(){
        this.form.encargo = '';
        this.form.cuaderno = '';
        this.form.f_estampado = '';
        this.form.f_notificacion = '';
        this.form.deligencia_id = '';
        this.form.fechas = [];
      },
      gestionCreateFill(){
        if(this.ModalCreateGestionVisible){
          if(typeof this.idxDeligencia != "undefined"){

            this.form.deligencia_id = this.idxDeligencia.id;
            
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
      createGestion(){
            this.$Progress.start();
              this.$store.dispatch('gestiones/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  this.form.reset();
                  $('#ModalCreateGestion').modal('hide');
                  this.getDiligencia();
                  this.close();
                  
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
            encargos: state     => state.paramDeligencias.encargos,
            tipoCuadernos: state   => state.paramDeligencias.tipoCuadernos,
          }),
    },
    watch:{
      ModalCreateGestionVisible: function(newtext){
            this.gestionCreateClean();
            this.gestionCreateFill();
      },
    }
  };
</script>

