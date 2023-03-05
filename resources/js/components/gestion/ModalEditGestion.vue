<template>
    <div class="modal hide fade" id="ModalEditGestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
      <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
          <div class="modal-header">
            <slot name="header">
            </slot>
          </div>
          <form @submit.prevent="updateGestion()">
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
                <has-error :form="form" field="obs"></has-error>
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
                    <button v-if="form.fechas.length > 0" @click="remove(index,fecha.id)" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
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
                @click="close">
                
                Cerrar
                
                </button>
              <button type="submit" class="btn btn-primary">Editar</button>
  
            </div>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  
    import { mapState } from 'vuex';
  
    export default {
      name: 'ModalEditGestion',
      props: {
        idxGestion:{
          Object,
        },
        ModalEditGestionVisible:{
          Boolean,
        },
      },
      data(){
        return{
          xfecha_name: '',
          xfecha: '',
          ArrayFecha: [],
          form: new Form({
            encargo: '',
            cuaderno: '',
            folio: '',
            deuda: '',
            f_estampado: '',
            f_notificacion: '',
            resultado: '',
            deligencia_id: '',
            fechas: [],
          }),
        }
      },
      methods: {
        add() {
          this.form.fechas.push({name: this.xfecha_name, fecha: this.xfecha});
          this.ArrayFecha.push({name: this.xfecha_name, fecha: this.xfecha, gestion_id: this.idxGestion.id});
          this.$store.dispatch('paramGestiones/createGestionFecha', this.ArrayFecha);
          this.xfecha_name = '';
          this.xfecha = '';
          this.ArrayFecha = [];
        },
        remove(index,fecha_id) {
          this.form.fechas.splice(index,1);
          this.$store.dispatch('paramGestiones/deleteGestionFecha', fecha_id);
        },
        editModalGestion(gestion){
          this.form.id =gestion.id;
          this.form.encargo =gestion.encargo;
          this.form.cuaderno =gestion.cuaderno;
          this.form.folio = gestion.folio;
          this.form.deuda = gestion.deuda;
          this.form.f_estampado = gestion.f_estampado;
          this.form.f_notificacion = gestion.f_notificacion;
          this.form.resultado = gestion.resultado;
          this.form.deligencia_id =gestion.deligencia.id;
          gestion.fechas.forEach(fecha => {
            this.form.fechas.push(fecha);
          });
        },
        gestionCreateClean(){
          this.form.encargo = '';
          this.form.cuaderno = '';
          this.form.deligencia_id = '';
          this.form.fechas = [];
        },
        gestionCreateFill(){
          if(this.ModalEditGestionVisible){
              if(typeof this.idxGestion != "undefined"){
                this.editModalGestion(this.idxGestion);
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
        getGestion(){
            let searchQuery= null;
            let sort_direction = 'desc';
            let sort_field= 'updated_at';
            let paginate= 15;
        
            this.$store.dispatch('gestiones/searchGestion', {
                searchQuery: searchQuery,
                sort_direction: sort_direction,
                sort_field: sort_field,
                paginate: paginate,
                deligencia_id: this.idxGestion.deligencia.id
            });
        },
        updateGestion(){
              this.$Progress.start();
              this.$store.dispatch('gestiones/edit', this.form)
              .then((response) => {
                  $('#ModalEditGestion').modal('hide');
                  this.getDiligencia();
                  this.getGestion();
                  this.close();
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
        close() {
            $('#ModalEditGestion').modal('hide');
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
        ModalEditGestionVisible: function(newtext){
              this.gestionCreateClean();
              this.gestionCreateFill();
        },
      }
    };
  </script>
  
  