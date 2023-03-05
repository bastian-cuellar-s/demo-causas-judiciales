<template>
  <div class="modal hide fade" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form @submit.stop.prevent="sendEmail">
          <div class="modal-body">

            <div class="form-group">
                <input v-model="form.asunto" type="text" name="asunto"
                  placeholder="Asunto del correo"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('asunto') }" required>
                <has-error :form="form" field="asunto"></has-error>
            </div>

            <div class="form-group">
                <textarea v-model="form.msg" type="text" name="msg"
                  placeholder="Mensaje del correo"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('msg') }" required></textarea>
                <has-error :form="form" field="msg"></has-error>
            </div>

            <div class="form-group">
            <v-select 
              v-model="form.email" 
              :options="personasDiligencia" 
              :reduce="personasDiligencia => personasDiligencia.email"
              @option:selected="onSelected"
              @option:deselected="offSelected"
              label="email" 
              placeholder="Seleccione Destinatario" >
              <template v-slot:option="option">
                   <em>{{option.email}}</em> - [{{option.rut}}] ~ <strong>{{ option.name }}</strong>
              </template>
            </v-select>
            </div>

            <div class="form-group">
            <v-select
              multiple 
              v-model="form.emailPersonas"
              v-if="!isSelect"
              disabled 
              :options="personasDiligencia" 
              :reduce="personasDiligencia => personasDiligencia.email"
              :selectable="(option) => !option.email.includes(form.email)"
              label="email" 
              placeholder="Seleccione Destinatario con copia CC" >
              <template v-slot:option="option">
                   <em>{{option.email}}</em> - [{{option.rut}}] ~ <strong>{{ option.name }}</strong>
              </template>
            </v-select>
            <v-select
              multiple 
              v-model="form.emailPersonas"
              v-else
              :options="personasDiligencia" 
              :reduce="personasDiligencia => personasDiligencia.email"
              :selectable="(option) => !option.email.includes(form.email)"
              label="email" 
              placeholder="Seleccione Destinatario con copia CC" >
              <template v-slot:option="option">
                   <em>{{option.email}}</em> - [{{option.rut}}] ~ <strong>{{ option.name }}</strong>
              </template>
            </v-select>
            </div>

            <div class="form-row" v-if="form.email">
              <div class="form-group col-md-11">
                <input v-model="emailPush" type="text" name="emailPlus"
                    placeholder="Agregar Email"
                class="form-control col-mb-11" :class="{ 'is-invalid': form.errors.has('emailPlus') }">
              </div>
              <div class="form-group col-md-1">
                <button type="button" class="btn btn-success col-mb-1" @click="add"><i class="fas fa-plus"></i></button>
              </div>
            </div>

            <table v-if="form.emailPersonas.length > 0" class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>
                  Correo
                </th>
                <th>
                  Eliminar 
                </th>
              </tr>
            </thead>
             <tbody>
                <tr v-for="(emailPersona, index) in form.emailPersonas" :key="index">
                <td>{{emailPersona}}</td>
                <td>
                  <button v-if="form.emailPersonas.length > 0" @click="remove(index)" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></button>
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
            <button type="submit" @click="formDeligencia();getTodayDate()" class="btn btn-primary">Enviar Correo</button>          

          </div>
            
            
            
            </div>
        </form>

      </div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'SendEmailModal',
    props: {
      ModalEmailVisible:{
        Boolean,
      },
      idxGestion:{
        Object,
      },
    },
    data(){
      return{
        emailPush: '',
        isSelect: false,
        personasDiligencia: [],
        form: new Form({
          asunto: '',
          rol: '',
          encargo: '',
          caratulado: '',
          tribunal: '',
          date: '',
          msg: '',
          email: '',
          emailPersonas: [],
        }),
      }
    },
    methods: {
      
      add() {
        this.form.emailPersonas.push(this.emailPush);
        this.emailPush = '';
      },
      remove(index) {
        this.form.emailPersonas.splice(index,1);
      },
      onSelected(e){
        this.isSelect = true;
      },
      offSelected(e){
        this.isSelect = false;
      },
      getTodayDate(){
          var dd = new Date();
          const days = ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"];
          const Months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", 
                          "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];

          var y = dd.getFullYear();
          var m = Months[dd.getMonth()];
          var d = dd.getDate();
          var dn = days[dd.getDay()];

          var day = dn + " " + d + " de " + m + " del " + y;
          this.form.date = day;
      },
      formDeligencia(){
        if(typeof this.idxGestion != "undefined"){
            this.form.rol = this.idxGestion.deligencia.rol;
            this.form.encargo = this.idxGestion.encargo;
            this.form.caratulado = this.idxGestion.deligencia.caratulado;
            this.form.tribunal = this.idxGestion.deligencia.tribunal;
        }
        else{
          Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
                  });
        }         
      },
      sendEmail(){
            this.$Progress.start();
              this.$store.dispatch('deligencias/sendEmail', this.form)
              .then((response)=>{
                if(response.data.success){
                  this.editCorreo();
                  this.form.reset();
                  this.getGestion();
                  this.close();
                  $('#modalEmail').modal('hide');

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
      customFormatter(date) {
              return moment(date).format('L');
      },
      editCorreo(){
        this.$store.dispatch('gestiones/editCorreo',this.idxGestion.id);
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
      sendEmailClean(){
          this.form.reset();
          this.emailPush= '';
          this.isSelect= false;
          this.personasDiligencia= [];
      },
      sendEmailFill(){
        if(typeof this.idxGestion != "undefined"){
          this.deligencia_id = this.idxGestion.deligencia.id;
          this.personasDiligencia.push(this.idxGestion.deligencia.cliente);
          this.personasDiligencia.push(this.idxGestion.deligencia.abogado);
          this.idxGestion.deligencia.demandados.forEach(demandado => {
            this.personasDiligencia.push(demandado);
          });
        }
      },
      close() {
        this.form.reset();
        $('#modalEmail').modal('hide');
        this.$emit('close');
      },  
    },
    watch:{
        ModalEmailVisible: function(newtext){
              this.sendEmailClean();
              this.sendEmailFill();
        },

    }, 
  };
</script>

