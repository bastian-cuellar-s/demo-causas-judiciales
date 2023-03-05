<template>
    <div class="modal hide fade" id="ModalMenuAranceles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
      <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
          <div class="modal-content">
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
                  Grupo Arancel N° {{grupoArancelProp.id}}
                  <small class="float-right">{{grupoArancelProp.created_at | formatDate}}</small>
                  </h4>
                  </div>
  
                  </div>
  
                  <div class="row invoice-info">
                  <div class="col-sm-6 invoice-col">
                  <address>
                    <strong>Nombre: </strong>{{grupoArancelProp.name}}<br>
                  </address>
                  </div>
  
                  <div class="col-sm-6 invoice-col">
                  <address v-if="ModalMenuArancelesVisible">
                    <strong>Observaciones: </strong>{{grupoArancelProp.obs}}<br>
                  </address>
                  </div>
  
                </div>
        
              </div>
              </div>
              </section>
            </div>

            <div class="card-header">

            <div class="card-tools">
            
            <button class="btn btn-success" @click="newExcelModal">Agregar Excel<b> </b><i class="fas fa-file-excel"></i></button>
            
            <div class="btn">
                <div class="input-group">                                  
                <label for="paginate" class="text-nowrap mr-2 mb-0"
                    >Por Pagina</label
                >
                <select
                    v-model="paginate"
                    class="form-control-sm"
                >
                    <option value="15">15</option>
                    <option value="30">30</option>
                    <option value="50">50</option>
                </select>                              
                </div>
                </div>
                <button class="btn btn-success" @click="newModal">Agregar<b> </b><i class="fas fa-user-plus fa-fw"></i></button>
            </div>

            </div>
  
            <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>
                        <a href="#" @click.prevent="change_sort('name')">Nombre</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'name'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'name'">&darr;</span>
                      </th>
                      <th>
                        <a href="#" @click.prevent="change_sort('valor')">Valor</a>
                        <span v-if="sort_direction == 'desc' && sort_field == 'valor'">&uarr;</span>
                        <span v-if="sort_direction == 'asc' && sort_field == 'valor'">&darr;</span>
                      </th>
                      <th>                          
                            <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..." aria-label="Buscar" aria-describedby="basic-addon1">                       
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="arancel in aranceles" :key="arancel.id">
                    
                    <td>{{arancel.name}}</td>
                    <td>{{arancel.valor}}</td>
                    <td>
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-success btn-sm rounded-1" data-placement="top" @click="editModal(arancel)" title="edit"><i class="fa fa-edit"></i></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-1" data-placement="top" @click="deleteArancel(arancel.id)" title="Delete"><i class="fa fa-trash"></i></button>
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
                data-dismiss="modal" 
                class="btn btn-secondary" 
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
  
    export default {
      name: 'ModalMenuAranceles',
      props: {
        grupoArancelProp:{
          Object,
        }, 
        ModalMenuArancelesVisible:{
          Boolean,
        },
      },
      data(){
          return{
            editmode: false,
            region_id: '',
            offset: 3,
            initial: 1,
            searchQuery: null,
            sort_direction : 'desc',
            sort_field: 'updated_at',
            paginate: 15,
            file: '',
            form: new Form({
                id: '',
                name: '',
                valor: '',
                g_arancel_id: this.g_arancel_id,
            }),
          }
        },
        methods: {
          onChange(e){
            this.file = e.target.files[0];
          },
          //metodo para ordenar los datos por campo
          change_sort(field){
            if(this.sort_field == field){
                this.sort_direction = this.sort_direction == "asc" ? "desc" : "asc";
            }else{
                this.sort_field = field;
            }
            this.getAranceles();
          }, 
          //Metodo para interactuar con el modal donde se edita un arancel
          editModal(arancel){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(arancel);
          },
          //Metodo para interactuar con el modal donde se crea un arancel
          newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
          },
          newExcelModal(){
                $('#addExcel').modal('show');
          },
          //Metodos para paginacion
          changePage: function(page) {
            this.$store.dispatch('aranceles/pagination', page);
            this.$store.dispatch('aranceles/searchArancel', {
            p_id:this.p_id,
            searchQuery: this.searchQuery,
            page:page,
            });
          },
          //Metodo para la paginacion
          incrementPagination(){
              this.$store.dispatch('aranceles/incrementPagination');
              return this.pagination.current_page;
          },
          //Metodo para la paginacion
          decrementPagination(){
              this.$store.dispatch('aranceles/decrementPagination');
              return this.pagination.current_page;
          },
          //Llamada al store para obtener los registros del componente
          getAranceles(){
            this.$store.dispatch('aranceles/searchArancel', {
                searchQuery: this.searchQuery,
                g_arancel_id:this.g_arancel_id,
                page:this.initial,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                });
          },
          createArancelExcel(e){
            this.$Progress.start();
            //e.preventDefault();
            //let existingObj = this;
            console.log
            const config = {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
            }
            let data = new FormData();
            data.append('file', this.file);
            data.append('persona_id', this.p_id);

              this.$store.dispatch('aranceles/createExcel', data, config)
              .then((response)=>{
                if(response.data.success){
                  $('#addExcel').modal('hide');

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
          //CRUD (crear)
          createArancel(){
            this.$Progress.start();

              this.$store.dispatch('aranceles/create', this.form)
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
          //CRUD (editar)
          updateArancel(){
              this.$Progress.start();
              this.$store.dispatch('aranceles/edit', this.form)
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
          //CRUD (eliminar)
          deleteArancel(arancel){
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
                                this.$store.dispatch('aranceles/delete', arancel).then(()=>{
                                        Swal.fire(
                                        'Borrado!',
                                        'El Arancel fue borrado',
                                        'success'
                                        )
                                }).catch((e)=> {
                                    Swal.fire("Failed!", "There was something wronge.", "warning");
                                    console.log(e);
                                });
                         }
                    })
          },
          menuArancelesClean(){

            this.editmode = false;
            this.region_id= '';
            this.offset= 3;
            this.initial= 1;
            this.searchQuery= null;
            this.sort_direction = 'desc';
            this.sort_field= 'updated_at';
            this.paginate= 15;
            this.file= '';
            this.form.id= '';
            this.form.name= '';
            this.form.valor= '';
            this.form.g_arancel_id= this.grupoArancelProp.g_arancel_id;

          },
          menuArancelesFill(){
            if(this.ModalMenuArancelesVisible){
                this.getAranceles();
                this.form.g_arancel_id= this.grupoArancelProp.id;
            }
          },
          close() {;
                //$('#modalCedula').modal('hide');
                this.$emit('close');
            },
        },
        created() {
            this.$Progress.start();

            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        mounted() {
            this.$store.dispatch('paramAranceles/loadAllTipoArancel');
        },
        watch:{
            ModalMenuAranceles: function(newtext){
                this.menuArancelesClean();
                this.menuArancelesFill();
            },
          searchQuery: function (val){
              this.getAranceles();
          },
          paginate: function(val) {
            this.getAranceles();
          },
        },
        computed:{
           
          ...mapState({
            aranceles: state => state.aranceles.aranceles,
            pagination: state => state.aranceles.pagination,
            tipoAranceles: state => state.paramAranceles.tipoAranceles,
          }),
          isActived: function() {
            return this.pagination.current_page;
          },
          pagesNumber: function() {
            if(!this.pagination.to){
              return [];
            }

            var from = this.pagination.current_page - this.offset; 
            if(from < 1){
              from = 1;
            }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){
              to = this.pagination.last_page;
            }

            var pagesArray = [];
            while(from <= to){
              pagesArray.push(from);
              from++;
            }
            return pagesArray;
          }
         
          },
        }
</script>