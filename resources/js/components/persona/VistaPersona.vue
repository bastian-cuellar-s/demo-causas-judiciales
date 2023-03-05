<template>
<section class="content" v-if="persona">
    <div class="container-fluid">
    <div class="row">
    <div class="col-12">
    <div class="customer-view">
        <div class="user-info">        
            <div class="card-body box-profile col-11">
                <div class="text-center user-img">
                  <img src="https://www.scottsdaleazestateplanning.com/wp-content/uploads/2018/01/user.png" alt="">
                </div>

                <h3 class="profile-username text-center">{{persona.name}}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>ID</b> <a class="float-right">{{persona.id}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Nombre</b> <a class="float-right">{{persona.name}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Rut</b> <a class="float-right">{{persona.rut}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right">{{persona.email}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Telefono</b> <a class="float-right">{{persona.telefono}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Comentarios</b> <a class="float-right">{{persona.obs}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Tipo de persona</b> <a class="float-right">{{persona.tipo_persona | upText }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Fecha de creación</b> <a class="float-right">{{persona.created_at   | formatDate }}</a>
                  </li>
                </ul>
              </div>
            
            <router-link to="/personas">Regresar</router-link>
        </div>
      </div>
    </div>
    </div>
  </div>
</section>
<section v-else>
    <not-found></not-found>
</section>
</template>

<script>

import { mapState } from 'vuex';

    export default {
        created() {
            if (this.personas.length) {
                this.persona = this.personas.find((persona) => persona.id == this.$route.params.id);
            } else {
                axios.get(`/api/personas/${this.$route.params.id}`)
                    .then((response) => {
                        this.persona = response.data.data.data
                    });
            }
        },
        data() {
            return {
                persona: [],
            };
        },
        computed: {
            ...mapState({
              personas: state => state.personas.personas,
            }),
        },
        mounted() {
            console.log('Componente VistaPersona montado.')
        },
    }
</script>

<style scoped>
.user-img {
    flex: 1;
}
.user-img img {
    max-width: 160px;
}
.user-info {
    flex: 3;
    overflow-x: scroll;
}
</style>