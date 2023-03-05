<template>
  <div class="modal hide fade" id="modalRecibo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" aria-label="Close" @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.prevent="createRecibo()">
          <div class="modal-body">


            <div class="form-group">
              <label>Cliente</label>
              <v-select v-if="personasDiligencia.length > 0"
                v-model="form.persona_id" 
                :options="personasDiligencia"
                :reduce="personasDiligencia => personasDiligencia.id" 
                label="name" 
                placeholder="Seleccione el Cliente" 
                @option:selected="onSelectedArancel"
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


            <div class="form-group" v-if="(arrayArancel.length > 0) || !(this.form.arancel_id='')" >
              <label>Arancel del Cliente</label>
              <v-select v-if="(arrayArancel.length > 0) || !(this.form.arancel_id='')" 
                v-model="form.arancel_id" 
                :options="arrayArancel"
                :reduce="arrayArancel => arrayArancel.id"
                @option:selected="onSelectedArancelExtra" 
                @input="offDelectedArancelExtra"
                label="name" 
                placeholder="Seleccione el Arancel del Cliente"
                required>
                <template #selected-option="{ name, valor }">
                  <div style="display: flex; align-items: baseline;">
                  <strong>{{ name }}</strong>&nbsp;
                  <em style="margin-left: .5rem;"> - [{{ valor }}]</em>
                  </div>
                </template>
                <template v-slot:option="option">
                    <strong>{{ option.name }}</strong>&nbsp; - [{{option.valor}}]
                </template>
              </v-select>
            </div>

            <div class="form-group">
                <input v-model="form.boleta" type="numeric" name="boleta"
                  placeholder="Número de la Boleta"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('boleta') }">
                <has-error :form="form" field="boleta"></has-error>
              </div>

            <div class="form-group">
                <textarea v-model="form.obs" name="Comentarios" id="obs"
                placeholder="Descripción del recibo"
                class="form-control" :class="{ 'is-invalid': form.errors.has('obs') }"></textarea>
                <has-error :form="form" field="obs"></has-error>
            </div>

            
            <div class="container col-12" v-if="extraVisible">
              <label>Gasto Extra</label>
              <div class="form-row"> 
                <div class="form-group col-md-7">
                    <input v-model="xextra_name" type="text" name="nombre_extra"
                    placeholder="Nombre del gasto extra"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('nombre_extra') }">
                  <has-error :form="form" field="nombre_extra"></has-error>
                </div>
                <div class="form-group col-md-4">
                    <input v-model="xextra_valor" type="number" name="valor_extra" 
                    placeholder="Valor" 
                    pattern="[0-9]" 
                    class="form-control" :class="{ 'is-invalid': form.errors.has('extra') }">
                    <has-error :form="form" field="total"></has-error>
                </div>
                <div class="form-group col-md-1">
                    <button type="button" class="btn btn-success col-mb-1" @click="add"><i class="fas fa-plus"></i></button>                  
                </div>

              </div>

              <div class="form-row">
                <div class="form-group col-md-12">
                  <textarea v-model="xextra_obs" name="Comentarios" id="obs"
                  placeholder="Descripción del gasto extra"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('obs') }"></textarea>
                  <has-error :form="form" field="obs"></has-error>
                </div>
              </div>
            </div>


            <div class="form-row">
                <div class="form-group">
                  <p style="font-size:30px" class="col-md-6">Total:</p>
                </div> 
                <div class="form-group">
                  <p style="font-size:30px" class="col-md-6">{{form.total}}</p>
                </div>
            </div>

          </div>

          <table v-if="form.extras.length > 0" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>
                  Nombre del gasto
                </th>
                <th>
                  Valor 
                </th>
                <th>
                  Descripción 
                </th>
                <th>
                  <i class="fas fa-tasks"></i>
                </th>
              </tr>
            </thead>
             <tbody>
                <tr v-for="(extra, index) in form.extras" :key="index">
                <td>{{extra.name}}</td>
                <td>{{extra.valor}}</td>
                <td>{{extra.obs}}</td>
                <td>
                  <div v-if="extra.id">
                      <button v-if="form.extras.length > 0" @click="remove(index, extra.id)" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                  </div>
                  <div v-else>
                      <button v-if="form.extras.length > 0" @click="remove(index)" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
                  </div>
                </td>
                </tr>
            </tbody>
          </table>

          <div class="modal-footer justify-content-between">
              <button 
                 v-if="this.idxGestion.recibo"
                 class="btn btn-danger"
                 title="imprimirRecibo"
                 @click="imprimirRecibo(idxGestion)">                               
                 <i class="fas fa-file-pdf"> Imprimir Recibo</i>
              </button>

              <div>
                <button
                type="button" 
                class="btn btn-secondary" 
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

  import jsPDFInvoiceTemplate from "jspdf-invoice-template-nodejs";

  export default {
    name: 'ReciboModal',
    props: {
      idxGestion:{
        Object,
      }, 
      ModalReciboVisible:{
        Boolean,
      },  
    },
    data(){
      return{
        
        form: new Form({
          total: 0,
          boleta: '',
          obs: '',
          extras: [],
          arancel_id: '',
          gestion_id: '',
          persona_id: '',
        }),
        xextra_name: '',
        xextra_valor: 0,
        xextra_obs: '',
        selected_valor: 0,
        extraVisible: false,
        arrayArancel: [],
        personasDiligencia: [],
        ArrayExtras: [],
        
      }
    },
    methods: {
      customFormatter(date) {
              return moment(date).format('L');
      },
      createRecibo(){
            this.$Progress.start();
              this.$store.dispatch('recibos/create', this.form)
              .then((response)=>{
                if(response.data.success){
                  this.form.reset();
                  $('#modalRecibo').modal('hide');
                  this.getGestion();
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
        let deligencia_id= this.idxGestion.deligencia.id;

        this.$store.dispatch('gestiones/searchGestion', {
              searchQuery: searchQuery,
              sort_direction: sort_direction,
              sort_field: sort_field,
              paginate: paginate,
              deligencia_id: deligencia_id,
        });

      },
      add() {
        this.form.extras.push({name: this.xextra_name, valor: this.xextra_valor, obs: this.xextra_obs});
        this.form.total+=parseFloat(this.xextra_valor,10);
        if(this.idxGestion.recibo){
            this.ArrayExtras.push({name: this.xextra_name, valor: this.xextra_valor, obs: this.xextra_obs, recibo_id: this.idxGestion.recibo.id});
            this.$store.dispatch('paramGestiones/createReciboExtra', this.ArrayExtras);
            this.ArrayExtras = [];
        }
        this.xextra_name = '';
        this.xextra_valor = 0;
        this.xextra_obs = '';
      },
      remove(index, extra_id) {
        this.form.total-=parseFloat(this.form.extras[index].valor,10);
        if(this.idxGestion.recibo){
            this.$store.dispatch('paramGestiones/deleteReciboExtra', extra_id);
        }
        this.form.extras.splice(index,1);
      },
      onSelectedArancel(e){
        if(e.grupo_arancel.arancel){
          this.arrayArancel = e.grupo_arancel.arancel;
        }else{
          console.log('El cliente no tiene Aranceles');
        }
      },
      offSelectedArancel(e){
        if(!e){
          this.arrayArancel = [];
        }
      },
      onSelectedArancelExtra(e){
        this.form.total=+ parseFloat(e.valor,10);
        this.selected_valor = parseFloat(e.valor,10);
        this.extraVisible = true;
      },
      offDelectedArancelExtra(e){    
        if(e){
          this.form.total-= parseFloat(this.selected_valor,10);
          this.form.total=+ parseFloat(e.valor,10);
          this.selected_valor = e.valor;
        }
        else{
          this.form.total-= parseFloat(this.selected_valor,10);
          this.extraVisible = false;
        }
      },
      deligenciaFill(){
        if(typeof this.idxGestion != "undefined"){
          this.form.gestion_id = this.idxGestion.id;
          this.personasDiligencia.push(this.idxGestion.deligencia.cliente);
          this.personasDiligencia.push(this.idxGestion.deligencia.abogado);
          this.idxGestion.deligencia.demandados.forEach(demandado => {
            this.personasDiligencia.push(demandado);
          });

            if(this.idxGestion.recibo){
              this.form.total= this.idxGestion.recibo.total;
              this.form.boleta= this.idxGestion.recibo.boleta;
              this.form.obs= this.idxGestion.recibo.obs;
              this.form.arancel_id= this.idxGestion.recibo.arancel_id;
              this.form.gestion_id= this.idxGestion.recibo.gestion_id;
              this.form.persona_id= this.idxGestion.recibo.persona_id;
  
              if(this.idxGestion.recibo.persona_id){
                let persona_idx = this.idxGestion.recibo.persona_id;

                if(this.idxGestion.deligencia.abogado.id == persona_idx){
                  this.arrayArancel = this.idxGestion.deligencia.abogado.grupo_arancel.arancel;
                  this.extraVisible = true;
                }
                if(this.idxGestion.deligencia.cliente.id == persona_idx){
                  this.arrayArancel = this.idxGestion.deligencia.cliente.grupo_arancel.arancel;
                  this.extraVisible = true;
                }
                
              }

              this.extraVisible = true;

              if(this.idxGestion.recibo.extras_recibo.length > 0){
                this.idxGestion.recibo.extras_recibo.forEach(extra => {
                  this.form.extras.push({id: extra.id, name: extra.name, valor: extra.valor, obs: extra.obs})
                });
              }
          }
        }
        
      },
      deligenciaClean(){
        if(typeof this.idxGestion != "undefined"){
          this.form.reset();
          this.xPersonaRecibo = '';
          this.xextra_name = '';
          this.xextra_valor = '';
          this.extraVisible = false;
          this.selected_valor = 0;
          this.arrayArancel = [];
          this.personasDiligencia = [];
        }
      },
      imprimirRecibo(gestion){
              
              if(gestion.recibo){

                let propArray = [];
                
                propArray.push(gestion.recibo.arancel);

                if(gestion.recibo.extras_recibo.length > 0){

                  gestion.recibo.extras_recibo.forEach(extra => {
                    propArray.push(extra);
                  });

                }

                let propArrayLenght = propArray.length;

                let totalString = String(gestion.recibo.total);

                let props = {
                    outputType: "save",
                    returnJsPDFDocObject: true,
                    fileName: "Recibo-"+gestion.deligencia.rol,
                    orientationLandscape: false,
                    compress: true,
                    logo: {
                        src: "/images/recibo/logo_recibo.png",
                        width: 38.33, //aspect ratio = width/height
                        height: 30.66,
                        margin: {
                            top: 0, //negative or positive num, from the current position
                            left: 0 //negative or positive num, from the current position
                        }
                    },
                    business: {
                        name:     "Receptora Judicial - Cuellar Zamora, Sara",
                        address:  "Colón 1086 depto. B",
                        phone:    "41 2558159",
                        email:  "+56 9 98855660",
                        email_1:    "saracuellarzamora@gmail.com",                  },
                    contact: {
                        label: "Recibo hecho para:",
                        name: gestion.deligencia.cliente.name,
                        address: gestion.deligencia.cliente.telefono,
                        phone: gestion.deligencia.cliente.email,
                    },
                    invoice: {
                        label: "Recibo:",
                        invGenDate: "Fecha del recibo: "+gestion.recibo.created_at,
                        headerBorder: true,
                        tableBodyBorder: true,
                        header: [
                        {
                            title: "#", 
                            style: { 
                            width: 10 
                            } 
                        }, 
                        { 
                            title: "Nombre",
                            style: {
                            width: 30
                            } 
                        }, 
                        { title: "Valor"},
                        { 
                            title: "Descripción",
                            style: {
                            width: 80
                            } 
                        }
                        ],
                        table: Array.from(Array(propArrayLenght), (item, index)=>([
                            index + 1,
                            propArray[index].name,
                            propArray[index].valor,
                            propArray[index].obs,

                        ])),
                        invTotalLabel: "Total:",
                        invTotal: totalString,
                    },
                    footer: {
                        text: "Este recibo fue creado digitalmente y no tiene validez sin un estampé o firma.",
                    },
                    pageEnable: true,
                    pageLabel: "Pagina ",
                };

                jsPDFInvoiceTemplate(props);
              }
            
      },
      close() {
        $('#modalRecibo').modal('hide');
        this.$emit('close');
      },
        
    },
    
    created() {
      
    },
    mounted() {

    },
    watch:{
      ModalReciboVisible: function(newtext){
            this.deligenciaClean();
            this.deligenciaFill();  
      },

    },
  };
</script>

