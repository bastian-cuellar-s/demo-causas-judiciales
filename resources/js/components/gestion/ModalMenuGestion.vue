<template>
  <div class="modal hide fade" id="ModalMenuGestion" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content" v-if="idxDeligencia">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>
          <div class="modal-body">
            <section class="content">
            <div class="container-fluid">
            <div class="invoice p-3 mb-3">
              <div class="row">
                <div class="col-12">
                <h4>
                Diligencia N° {{idxDeligencia.id}}
                <small class="float-right">{{idxDeligencia.created_at | formatDate}}</small>
                </h4>
                </div>

                </div>

                <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                <address>
                  <strong>ROL: </strong>{{idxDeligencia.rol}}<br>
                  <strong>Tribunal: </strong>{{idxDeligencia.tribunal}}<br>
                  <strong>Materia: </strong>{{idxDeligencia.materia}}<br>
                  <strong>Caratulado: </strong>{{idxDeligencia.caratulado}}
                </address>
                </div>

                <div class="col-sm-6 invoice-col">
                <address v-if="ModalMenuGestionVisible">
                  <div v-if="idxDeligencia.cliente.tipo_persona=='natural'">
                    <strong>Cliente: </strong>{{idxDeligencia.cliente.name}} {{idxDeligencia.cliente.APaterno}} {{idxDeligencia.cliente.AMaterno}}<br>
                  </div>
                  <div v-else>
                    <strong>Cliente: </strong>{{idxDeligencia.cliente.name}}<br>
                    Representante: {{idxDeligencia.cliente.representante}}<br>
                  </div>
                  
                  <strong>Abogado: </strong>{{idxDeligencia.abogado.name}} {{idxDeligencia.abogado.APaterno}} {{idxDeligencia.abogado.AMaterno}}<br>
                  
                  <div v-for="demandado in idxDeligencia.demandados" :key="demandado.id">
                    <div v-if="demandado.tipo_persona=='natural'">
                      <strong>Demandado({{demandado.id}}): </strong>{{demandado.name}} {{demandado.APaterno}} {{demandado.AMaterno}}<br>
                    </div>
                    <div v-else>
                      <strong>Demandado({{demandado.id}}): </strong>{{demandado.name}}<br>
                      Representante({{demandado.id}}): {{demandado.representante}}<br>
                    </div>
                  </div>
                </address>
                </div>

              </div>
      
            </div>
            </div>
            </section>
          </div>

          <div>
            <ReciboModal
                  v-show="ModalReciboVisible"
                  @close="closeModalRecibo"
                  :idxGestion="gestionProp"
                  :ModalReciboVisible="ModalReciboVisible"
                >
                  <template v-slot:header>
                    Recibo
                  </template>
                  <template v-slot:body>
                    This is a new modal body.
                  </template>
                  <template v-slot:footer>
                  </template>
            </ReciboModal>
          </div>
          <div>
            <SendEmailModal
                  v-show="ModalEmailVisible"
                  @close="closeModalEmail"
                  :ModalEmailVisible="ModalEmailVisible"
                  :idxGestion="gestionProp"
                >
                  <template v-slot:header>
                    Enviar Email
                  </template>

                  <template v-slot:body>
                    This is a new modal body.
                  </template>

                  <template v-slot:footer>
                  </template>
            </SendEmailModal>
          </div>
          <!--Modal para enviar correos sobre las deligencias-->
          <div>
            <PrintCedulaModal
                  v-show="ModalCedulaVisible"
                  @close="closeModalCedula"
                  :idxGestion="gestionProp"
                  :ModalCedulaVisible="ModalCedulaVisible"
                >
                  <template v-slot:header>
                    Descargar Cédula
                  </template>

                  <template v-slot:body>
                    This is a new modal body.
                  </template>

                  <template v-slot:footer>
                  </template>
            </PrintCedulaModal>
          </div>
          <div>
            <EstampadoModal
                  v-show="ModalEstampadoVisible"
                  @close="closeModalEstampado"
                  :idxGestion="gestionProp"                  
                  :ModalEstampadoVisible="ModalEstampadoVisible"
            >
            
              <template v-slot:header>
                Datos Estampado
              </template>
            </EstampadoModal>
          </div>
          <div>
            <ModalEditGestion
                  v-show="ModalEditGestionVisible"
                  @close="closeModalEditGestion"
                  :idxGestion="gestionProp"
                  :ModalEditGestionVisible="ModalEditGestionVisible"
            >
            
              <template v-slot:header>
                Editar Gestión
              </template>
            </ModalEditGestion>
          </div>

          <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>
                        <a href="#" @click.prevent="change_sort('encargo')">Tipo encargo</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'encargo'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'encargo'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('cuaderno')">Tipo Cuaderno</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'cuaderno'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'cuaderno'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('f_estampado')">F.Estampado</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'f_estampado'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'f_estampado'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('f_resolucion')">F.Resolucion</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'f_resolucion'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'f_resolucion'">&darr;</span>
                      </th>
                      <th>                          
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="gestion in gestiones" :key="gestion.id">
                    <td>{{gestion.encargo}}</td>
                    <td>{{gestion.cuaderno}}</td>
                    <td>{{gestion.f_estampado  | formatDate  }}</td>
                    <td>
                      <v-select  
                        :options="gestion.fechas" 
                        label="name" 
                        placeholder="Fechas de la gestión" >
                        <template #selected-option="{ name, fecha }">
                          <div style="display: flex; align-items: baseline;">
                          <strong>{{ name }}</strong>&nbsp;
                          <em style="margin-left: .5rem;"> - [{{ fecha }}]</em>
                          </div>
                        </template>
                        <template v-slot:option="option">
                            <strong>{{ option.name }}</strong>&nbsp;-&nbsp;{{ option.fecha }}
                        </template>
                        </v-select>
                    </td>
                    <!--<td class="dropdown">
                      <form action="" name="FILTER">
                          <select class="form-control">
                              <option>F.Resolución: {{deligencia.f_resolucion  | formatDate  }}</option>
                              <option>F.Estampado:  {{deligencia.f_estampado   | formatDate  }}</option>
                          </select>
                      </form>
                    </td>-->
                    <td>
                      <ul class="list-inline m-0">
                          <li class="list-inline-item">
                            <button v-if="listaDiligencia(gestion)==0"
                            class="btn btn-danger" 
                            type="button" 
                            id="dropdownMenu2" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-list-ol"></i>
                            </button>
                            <button v-if="listaDiligencia(gestion)==1"
                            class="btn btn-warning" 
                            type="button" 
                            id="dropdownMenu2" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-list-ol"></i>
                            </button>
                            <button v-if="listaDiligencia(gestion)==2"
                            class="btn btn-info" 
                            type="button" 
                            id="dropdownMenu2" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-list-ol"></i>
                            </button>
                            <button v-if="listaDiligencia(gestion)==3"
                            class="btn btn-success" 
                            type="button" 
                            id="dropdownMenu2" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-list-ol"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                              <button 
                               class="btn btn-primary btn-sm rounded-1 dropdown-item"
                               data-toggle="modal" 
                               data-target="#modalCedula"
                               title="Cedula"
                               @click="showModalCedula(gestion)"
                                >                               
                               <i class="fas fa-address-card"> Cedula</i>
                              </button>

                              <button 
                              class="btn btn-dark btn-sm rounded-1 dropdown-item" 
                              data-toggle="modal" 
                               data-target="#modalEstampado"
                               title="Estampado" 
                              @click="showModalEstampado(gestion)" 
                              >
                              <i class="fas fa-file-invoice"> </i>
                              <i v-if="!gestion.estampe" class="fas fa-times"> Estampado</i>
                              <i v-else class="fas fa-check"> Estampado</i>
                              </button>

                              <button
                               class="btn btn-dark btn-sm rounded-1 dropdown-item"
                               data-toggle="modal" 
                               data-target="#modalEmail"
                               title="Email"
                               @click="showModalEmail(gestion)"
                                >                               
                               <i class="fas fa-mail-bulk "></i>
                               <i v-if="!gestion.correo" class="fas fa-times"> Correo</i>
                              <i v-else class="fas fa-check"> Correo</i>
                              </button>

                              <button 
                               class="btn btn-warning btn-sm rounded-1 dropdown-item"
                               data-toggle="modal" 
                               data-target="#modalRecibo"
                               title="Recibo"
                               @click="showModalRecibo(gestion)">                               
                               <i class="fas fa-receipt"></i>
                               <i v-if="!gestion.recibo" class="fas fa-times"> Recibo</i>
                                <i v-else class="fas fa-check"> Recibo</i>
                              </button>

                            </div>
                          </li>
                          <li class="list-inline-item">
                            <button v-if="!gestion.pagado && gestion.cobrado"
                            class="btn btn-warning" 
                            type="button" 
                            id="dropdownMenu3" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-dollar-sign"></i>
                            </button>
                            <button v-if="!gestion.cobrado"
                            class="btn btn-danger" 
                            type="button" 
                            id="dropdownMenu3" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-dollar-sign"></i>
                            </button>
                            <button v-if="gestion.cobrado && gestion.pagado"
                            class="btn btn-success" 
                            type="button" 
                            id="dropdownMenu3" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" 
                            aria-expanded="false">
                                  <i class="fas fa-dollar-sign"></i>
                            </button>
                            
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu3">
                              <button v-if="!gestion.cobrado"
                              class="btn btn-dark btn-sm rounded-1 dropdown-item" 
                              data-placement="top"
                              title="Cobrado"
                               @click="editCobrado(gestion.id)">                               
                               <i class="fas fa-file-invoice-dollar"></i>
                               <i v-if="!gestion.cobrado" class="fas fa-times"> Cobrar</i>
                            </button>
                              <button v-else 
                              class="btn btn-dark btn-sm rounded-1 dropdown-item" 
                              data-placement="top"
                              title="Cobrado"
                               @click="editCobradoF(gestion.id)">                               
                               <i class="fas fa-file-invoice-dollar"></i>
                              <i class="fas fa-check"> Cobrado</i>
                            </button>

                              <button v-if="!gestion.pagado"
                               class="btn btn-dark btn-sm rounded-1 dropdown-item" 
                              data-placement="top"
                              title="Pagado"
                               @click="editPagado(gestion.id)"
                                >                               
                               <i class="fas fa-hand-holding-usd"></i>
                               <i v-if="!gestion.pagado" class="fas fa-times"> No Pago</i>
                            </button>

                              <button v-else
                               class="btn btn-dark btn-sm rounded-1 dropdown-item" 
                              data-placement="top"
                              title="Pagado"
                               @click="editPagadoF(gestion.id)"
                                >                               
                               <i class="fas fa-hand-holding-usd"></i>
                              <i class="fas fa-check"> Pagado</i>
                            </button>
                            </div>
                          </li>
                          <li class="list-inline-item">
                            <button class="btn btn-secondary" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-tools"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                              <button class="btn btn-success btn-sm rounded-1 dropdown-item"
                              data-toggle="modal" 
                              data-target="#ModalEditGestion"
                              title="editGestion"
                              @click="showModalEditGestion(gestion)" 
                              ><i class="fa fa-edit"> Editar</i>
                              </button>

                              <button class="btn btn-danger btn-sm rounded-1 dropdown-item" 
                              data-placement="top" 
                              @click="deleteGestion(gestion)" 
                              title="Delete"><i class="fa fa-trash "> Eliminar</i>
                              </button>
                            </div>
                          </li>
                          <li class="list-inline-item">
                            <button class="btn btn-light" type="button" id="dropdownMenu4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-caret-square-down text-secondary"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenu4">
                              <button 
                              class="btn btn-dark btn-sm rounded-1 dropdown-item" 
                              data-placement="top" 
                              @click="editEstampadoF(gestion.id)" 
                              title="Estampado">
                                <i class="fas fa-file-invoice"> </i>
                                <i class="fas fa-times"> Estampado</i>
                              </button>

                              <button
                               class="btn btn-dark btn-sm rounded-1 dropdown-item"
                               data-placement="top"
                               title="Email"
                               @click="editCorreoF(gestion.id)"
                                >                               
                                <i class="fas fa-mail-bulk "></i>
                                <i class="fas fa-times"> Correo</i>
                              </button>

                            </div>
                          </li>
                      </ul>
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

          </div>
      </div>
    </div>
  </div>
</template>

<script>

  import { mapState } from 'vuex';
  import ReciboModal from '../../components/recibo/ReciboModal.vue';
  import SendEmailModal from '../../components/deligencia/SendEmailModal.vue';
  import PrintCedulaModal from '../../components/deligencia/PrintCedulaModal.vue';
  import EstampadoModal from '../../components/deligencia/EstampadoSelectModal.vue';
  import ModalEditGestion from '../../components/gestion/ModalEditGestion.vue';

  export default {
    components:{
      ReciboModal,
      SendEmailModal,
      PrintCedulaModal,
      EstampadoModal,
      ModalEditGestion,
    },
    name: 'ModalMenuGestion',
    props: {
      idxDeligencia:{
        Object,
      }, 
      ModalMenuGestionVisible:{
        Boolean,
      },
    },
    data(){
      return{
        editmodeGestion: false,
        ModalReciboVisible: false,
        ModalEmailVisible: false,
        ModalCedulaVisible: false,
        ModalEstampadoVisible: false,
        ModalEditGestionVisible: false,
        searchQuery: null,
        sort_direction : 'desc',
        sort_field: 'updated_at',
        paginate: 15,
        fun: null,
        xfecha_name: '',
        xfecha: '',
        form: new Form({
          encargo: '',
          cuaderno: '',
          persona_id: '',
          fechas: [],
        }),
        deligenciaProp: [],
        gestionProp: [],
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
      listaDiligencia(gestion){
            let sumEstampado = 0;
            let sumCorreo = 0;
            let sumRecibo = 0;
            let sumLista = 0;

            if(gestion.estampe){
              sumEstampado = 1;
            }
            if(gestion.correo){
              sumCorreo = 1;
            }
            if(gestion.recibo){
              sumRecibo = 1;
            }
          
          sumLista = sumEstampado + sumCorreo + sumRecibo;

          return sumLista;
            
      },
      //Metodos para mostrar el component modal para crear la cedula
      showModalCedula(gestion) {
        this.gestionProp = gestion;
        this.ModalCedulaVisible = true;            
      },
      closeModalCedula() {
        this.ModalCedulaVisible = false;
      },
      //Metodos para mostrar el component modal para crear estampado
      showModalEstampado(gestion) {
        this.gestionProp = gestion;
        this.ModalEstampadoVisible = true;            
      },
      closeModalEstampado() {
        this.ModalEstampadoVisible = false;
      },
      //Metodos para mostrar el component modal de los Email
      showModalEmail(gestion) {
        this.gestionProp = gestion;
        this.ModalEmailVisible = true;
      },
      closeModalEmail() {
        this.ModalEmailVisible = false;
      },
      //Componenete Modal usado para poder agregar los Recibo a la respectiva persona
      showModalRecibo(gestion) {
        this.gestionProp = gestion;
        this.ModalReciboVisible = true;
      },
      closeModalRecibo() {
        this.ModalReciboVisible = false;
      },
      editEstampadoF(deligencia_id){
        this.$store.dispatch('gestiones/editEstampeF', deligencia_id);
      },
      editCorreoF(deligencia_id){
        this.$store.dispatch('gestiones/editCorreoF', deligencia_id);
      },
      editCobrado(deligencia_id){
        this.$store.dispatch('gestiones/editCobrado', deligencia_id);
      },
      editCobradoF(deligencia_id){
        this.$store.dispatch('gestiones/editCobradoF', deligencia_id);
      },
      editPagado(deligencia_id){
        this.$store.dispatch('gestiones/editPagado', deligencia_id);
      },
      editPagadoF(deligencia_id){
        this.$store.dispatch('gestiones/editPagadoF', deligencia_id);
      },
      //Metodo para mostrar el component modal para crear una gestión
      showModalEditGestion(gestion) {
        this.gestionProp = gestion;
        this.ModalEditGestionVisible = true;
      },
      closeModalEditGestion() {
        this.ModalEditGestionVisible = false;
      },
      gestionMenuClean(){
        this.form.reset();
        /*this.searchQuery= null;
        this.sort_direction = 'desc';
        this.sort_field= 'updated_at';
        this.paginate = 15;
        this.fun= null;*/
        this.editmodeGestion = false;
        this.form.encargo = '';
        this.form.cuaderno = '';
        this.form.persona_id = '';
        this.form.fechas = [];
      },
      gestionMenuFill(){
        if(this.idxDeligencia){
          this.getGestion();
          this.deligenciaProp = this.idxDeligencia;
        }
      },
      getGestion(){
        let sort_direction = 'desc';
        let sort_field= 'updated_at';
        let paginate= 15;

        this.$store.dispatch('gestiones/searchGestion', {
              searchQuery: this.searchQuery,
              sort_direction: sort_direction,
              sort_field: sort_field,
              paginate: paginate,
              deligencia_id: this.idxDeligencia.id
        });
      },
      updateGestion(){
              this.$Progress.start();
              this.$store.dispatch('deligencias/edit', this.form)
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
      deleteGestion(gestion){
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás recuperar está infor mación!",
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, borrar!'
                    }).then((result) => {
                        // Send request to the server
                         if (result.value) {
                                this.$store.dispatch('gestiones/delete', gestion).then(()=>{
                                        Swal.fire(
                                        'Borrado!',
                                        'La gestion fue borrada',
                                        'success'
                                        )
                                }).catch((e)=> {
                                    Swal.fire("Failed!", "There was something wronge.", "warning");
                                    console.log(e);
                                });
                         }
                    })
          },
      close() {
        this.$emit('close');
      },    
    },
    computed:
    {
       ...mapState({
            gestiones: state        => state.gestiones.gestiones,
            tipoAranceles: state    => state.paramAranceles.tipoAranceles,
            tipoCuadernos: state    => state.paramDeligencias.tipoCuadernos,
          }),
    },
    watch:{
      searchQuery: function (val){
              this.getGestion();
      },
      ModalMenuGestionVisible: function(newtext){
            this.gestionMenuClean();
            this.gestionMenuFill();
      },
    }
  };
</script>

