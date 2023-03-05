<template>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="form-group row">
                <h3 class="card-title col-sm-2">Reportes</h3>

                <div class="col-sm-10">
                  <input type="text" v-model="searchQuery" class="form-control" placeholder="Buscar..."
                    aria-label="Buscar" aria-describedby="basic-addon1">
                </div>

              </div>

              <div class="form-row">
                <v-select 
                v-model="cliente_id" 
                :options="personas" 
                :reduce="personas => personas.id" 
                :filterable="false"
                @option:selecting="onSelectingCliente" 
                @close="onDeselectedCliente" 
                @search="onSearchPersona"
                label="name" placeholder="Seleccione Cliente" class="col-md-3">
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

                <v-select 
                v-model="abogado_id" 
                :options="abogados" 
                :reduce="abogados => abogados.id" 
                :filterable="false"
                @option:selecting="onSelectingAbogado" 
                @close="onDeselectedAbogado" 
                @search="onSearchPersona"
                  label="name" placeholder="Seleccione Abogado" class="col-md-3">
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

                <VueCtkDateTimePicker v-model="dates" class="RangeDatePicker col-md-3" format="DD-MM-YYYY" noLabel
                  input-size="sm" formatted="ll" only-date range :custom-shortcuts="atajos"
                  label="Seleccione fecha de inicio" buttonNowTranslation="Hoy"></VueCtkDateTimePicker>

                <div>
                  <div class="dropdown ml-3">
                    <button v-if="checked.length > 0" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                      @click.prevent="excelExport(checked)">
                      Cantidad de registros ({{ checked.length }})
                    </button>
                  </div>
                </div>


                <button class="btn btn-outline-secondary col-md-2"
                  @click="getGestionClienteAbogado(cliente_id, abogado_id , dates)">Buscar Gestiones<b> </b><i
                    class="fa-solid fa-calendar-range"></i></button>

              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <div class="col-md-10 mb-2" v-if="selectPage">
                <div v-if="selectAll">
                  Ya has seleccionado todos los registros
                  <strong>{{ checked.length }}</strong> items.
                </div>
                <div v-else>
                  Has seleccionado <strong>{{ checked.length }}</strong> registros, Te gustaría
                  Seleccionarlos todos <strong>{{ this.pagination.total }}</strong>?
                  <a @click.prevent="selectAllRecords" href="#" class="ml-2">Select All</a>
                </div>
              </div>
              <table class="table table-hover text-nowrap">
                <thead>
                  <tr>
                    <th><input type="checkbox" v-model="selectPage" /></th>
                    <th>ROL</th>
                    <th>Tribunal</th>
                    <th>Encargo</th>
                    <th>Fechas</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="gestion in gestiones" :key="gestion.id"
                    :class="isChecked(gestion.id) ? 'table-primary' : ''">

                    <td>
                      <input type="checkbox" :value="gestion.id" v-model="checked" />
                    </td>

                    <td>{{gestion.deligencia.rol}}</td>
                    <td>{{gestion.deligencia.tribunal}}</td>
                    <td>{{gestion.encargo}}</td>
                    <td>
                      <v-select :options="gestion.fechas" label="name" placeholder="Fechas de la gestión">
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
                  </tr>
                </tbody>
              </table>
              <div class="card-footer text-muted">
                <nav aria-label="Page navigation example">
                  <ul class="pagination">
                    <li class="page-item" v-if="this.pagination.current_page > 1">
                      <a class="page-link" href="#" @click.prevent="changePage(decrementPagination())">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>

                    <li class="page-item" v-for="page in pagesNumber" :key="page"
                      v-bind:class="[ page == isActived ? 'active' : '']">
                      <a class="page-link" href="#" @click.prevent="changePage(page)">
                        {{ page }}
                      </a>
                    </li>

                    <li class="page-item" v-if="this.pagination.current_page < this.pagination.last_page">
                      <a class="page-link" href="#" @click.prevent="changePage(incrementPagination())">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- Modal -->

      </div>
    </div>
  </section>
</template>

<script>

import { mapState } from 'vuex';

export default {
  data() {
    return {
      cliente_id: '',
      abogado_id: '',
      cliente: [],
      abogado: [],
      dates: {},
      searchQuery: null,
      searchQueryPersona: null,
      offset: 3,
      initial: 1,
      sort_direction: 'desc',
      sort_field: 'updated_at',
      paginate: 15,
      url: '',
      checked: [],
      selectPage: false,
      selectAll: false,
      atajos: [
        { key: 'thisWeek', label: 'Esta semana', value: 'isoWeek' },
        { key: 'lastWeek', label: 'Última sem', value: '-isoWeek' },
        { key: 'last7Days', label: 'Últimos 7D', value: 7 },
        { key: 'last30Days', label: 'Últimos 30D', value: 30 },
        { key: 'thisMonth', label: 'Este mes', value: 'month' },
        { key: 'lastMonth', label: 'Último mes', value: '-month' },
        { key: 'thisYear', label: 'Este año', value: 'year' },
        { key: 'lastYear', label: 'Último año', value: '-year' }
      ],
    }
  },
  methods: {
    excelExport(gestion) {

      axios.get('/api/gestiones/export/' + this.checked,
        { responseType: 'arraybuffer' })
        .then(response => {
          var fileURL = window.URL.createObjectURL(new Blob([response.data]));
          var fileLink = document.createElement('a');
          fileLink.href = fileURL;
          /*if (this.cliente && this.abogado) {
            fileLink.setAttribute('download', 'reporte-' + this.cliente['name'] + "-" + this.abogado.name + '.xlsx');
          }
          if (!this.cliente && this.abogado) {
            fileLink.setAttribute('download', 'reporte-' + this.abogado.name + '.xlsx');
          }
          if (this.cliente && !this.abogado) {
            fileLink.setAttribute('download', 'reporte-' + this.cliente.name + '.xlsx');
          }
          if (!this.cliente && !this.abogado) {
            fileLink.setAttribute('download', 'reporte.xlsx');
          }*/
          fileLink.setAttribute('download', 'reporte.xlsx');
          document.body.appendChild(fileLink);
          fileLink.click();
        })


    },
    selectAllRecords() {
      axios.get('/api/gestiones/all')
        .then(response => {
          this.checked = response.data;
          this.selectAll = true;
        });
    },
    isChecked(id) {
      return this.checked.includes(id);
    },
    getGestionClienteAbogado(cliente_id, abogado_id, dates) {
      this.$store.dispatch('gestiones/getGestionClienteAbogado', {
        cliente_id: cliente_id,
        abogado_id: abogado_id,
        dates: dates,
      });
    },
    //Metodos para paginacion
    changePage: function (page) {
      this.$store.dispatch('gestiones/pagination', page);
      this.$store.dispatch('gestiones/searchGestion', {
        searchQuery: this.searchQuery,
        page: page,
      });
    },
    //Metodos para paginacion
    incrementPagination() {
      this.$store.dispatch('gestiones/incrementPagination');
      return this.pagination.current_page;
    },
    //Metodos para paginacion
    decrementPagination() {
      this.$store.dispatch('gestiones/decrementPagination');
      return this.pagination.current_page;
    },
    //metodo para v-select
    getStoreName(props) {
      return this.clientes.find(i => i.id === props.option).name
    },
    //metodo para v-select
    getStoreRut(props) {
      return this.clientes.find(i => i.id === props.option).rut
    },
    //Metodo para tener el horario y fechas en formato latinoamericano
    customFormatter(date) {
      return moment(date).format('L');
    },
    getdiligencia() {
      this.$store.dispatch('gestiones/searchGestion', {
        searchQuery: this.searchQuery,
        page: page,
      });
    },
    getPersonas() {
      this.$store.dispatch('personas/searchPersona', {
        searchQuery: this.searchQueryPersona,
        sort_direction: this.sort_direction,
        sort_field: this.sort_field,
        paginate: this.paginate,
        fun: this.fun,
      });
    },
    getAbogado() {
      let fun = 'abogado'

      this.$store.dispatch('personas/loadAllAbogados', {
        searchQuery: this.searchQueryPersona,
        sort_direction: this.sort_direction,
        sort_field: this.sort_field,
        paginate: this.paginate,
        fun: fun,
      });
    },
    onSearchPersona(query) {
      if (!this.selecting) {
        this.$store.dispatch('personas/searchPersona', {
          searchQuery: query,
          sort_direction: this.sort_direction,
          sort_field: this.sort_field,
          paginate: this.paginate,
          fun: this.fun,
        });
      } else {
        this.$store.dispatch('personas/searchPersona', {
          searchQuery: this.searchQueryPersona,
          sort_direction: this.sort_direction,
          sort_field: this.sort_field,
          paginate: this.paginate,
          fun: this.fun,
        });
      }
    },
    onSelectingCliente(e) {
      this.selecting = true;
      this.cliente = e;
    },
    onDeselectedCliente() {
      this.selecting = false;
      this.cliente = [];
    },
    onSelectingAbogado(e) {
      this.selecting = true;
      this.abogado = e;
    },
    onDeselectedAbogado() {
      this.selecting = false;
      this.abogado = [];
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
    this.getPersonas();
    this.getAbogado();
  },
  watch: {
    searchQuery: function (val) {
      this.getdiligencia();
    },
    selectPage: function (value) {
      this.checked = [];
      if (value) {
        this.gestiones.forEach(gestion => {
          this.checked.push(gestion.id);
        });
      } else {
        this.checked = [];
        this.selectAll = false;
      }
    },
  },
  computed: {
    ...mapState({
      personas: state => state.personas.personas,
      abogados: state => state.personas.abogados,
      gestiones: state => state.gestiones.reporte_gestiones,
      pagination: state => state.gestiones.reporte_pagination,
    }),
    isActived: function () {
      return this.pagination.current_page;
    },
    pagesNumber: function () {
      if (!this.pagination.to) {
        return [];
      }

      var from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      var to = from + (this.offset * 2);
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      var pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }
      return pagesArray;
    }

  },
}
</script>