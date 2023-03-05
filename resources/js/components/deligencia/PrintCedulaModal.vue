<template>
  <div class="modal hide fade" id="modalCedula" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div v-if="this.idxGestion" class="modal-content">
        <div class="modal-header">
          <slot name="header">
          </slot>
          <button type="button" class="close" aria-label="Close"  @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Demandado</label>
          <v-select v-if="ModalCedulaVisible"
            v-model="xdemandadoModel"
            :options="idxGestion.deligencia.demandados"
            label="name" 
            placeholder="Seleccione el Cliente" 
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

        <div v-if="this.arrayDomicilio.length>0" id="ImageCedula">

        <div class="form-group">
            <input v-model="nota" type="text" name="nota"
              placeholder="Comentario"
              class="form-control"
              @input="onNota"
              >
        </div>

        <div class="form-group">

           <v-select v-if="this.arrayDomicilio.length>0"
              v-model="xdomicilio" 
              :options="arrayDomicilio" 
              label="direccion"
              placeholder="Seleccione el Domicilio" 
              @option:selected="onSelected"
              required>
            <template v-slot:option="option">
                {{ option.direccion }} {{ option.numero }}, {{ option.comuna }}, {{option.region}}
            </template>
            </v-select>
        </div>
        <div class="row">
        <div class="col-md-1">
          <button type="button" class="btn btn-primary btn-sm" @click="isHidden = !isHidden"><i class="fas fa-caret-square-down"></i></button>
        </div>
        <div class="col-md-1">
          <button type="button" class="btn btn-success btn-sm" @click="AnguloBase"><i class="fas fa-sync"></i></button>
        </div>
        <div class="col-md-1">
          <div v-if="!isTransparent">
            <button type="button" class="btn btn-secondary btn-sm" @click="isTransparent = !isTransparent"><i class="fas fa-eye-slash"></i></button>
          </div>
          <div v-else>
            <button type="button" class="btn btn-light btn-sm" @click="isTransparent = !isTransparent"><i class="fas fa-eye-slash"></i></button>
          </div>
          
        </div>
      </div>
        
        
        <div v-if="isHidden">
          <div class="form-row"> 
          <div class="form-group col-md-6">
            <label for="font">Fuente</label>
                <v-select 
                  v-model="font" 
                  :options="fonts" 
                  label="name" 
                  placeholder="Seleccione la fuente" >
                  </v-select>   
          </div>
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="imageSize"
              inputType="number"
              labelName="Tamaño"
              :value="size"
              @input="size = $event"
            />
          </div>
          </div>
          <div class="form-row"> 
          <div class="form-group col-md-6">
            <SelectLabeled
              selectId="baseline"
              labelName="Ubicación"
              :optionList = "baselineList"
              @select="updateBaseline($event)"
            />
          </div>
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="foregroundColor"
              inputType="color"
              labelName="Color de Letra"
              :value="foregroundColor"
              @input="foregroundColor = $event"
            />
          </div>
          </div>
          <div class="form-row"> 
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="backgroundColor"
              inputType="color"
              labelName="Color de fondo"
              :value="backgroundColor"
              @input="backgroundColor = $event"
            />
          </div>
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="height"
              inputType="number"
              labelName="Altura"
              :value="height"
              @input="height = $event"
            />
          </div>
          </div>
          <div class="form-row"> 
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="width"
              inputType="number"
              labelName="Ancho"
              :value="width"
              @input="width = $event"
            />
          </div>
          <div class="form-group col-md-6">
            <SelectLabeled
              selectId="sizePresets"
              labelName="Tamaños personalizados"
              :optionList="sizeList"
              @select="updateSize($event)"
            />
          </div>
          </div>
          <div class="form-row"> 
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="angle"
              inputType="number"
              labelName="Angulo"
              :value="angle"
              @input="angle = $event"
            />
          </div>
          <div class="form-group col-md-6">
            <InputLabeled
              inputId="transparent"
              inputType="checkbox"
              labelName="Transparente"
              :value="isTransparent"
              @input="isTransparent = $event"
            />
          </div>
          </div>
          </div>
          <div class="form-group">
            <AppAnchor
              :href="dataURL"
              download="image.png"
              text="Descargar imagen"
            /> 
          </div>
          <div class="form-group">
            <AppCanvas
              :height="parseInt(height)"
              :width="parseInt(width)"
              :foregroundColor="foregroundColor"
              :backgroundColor="backgroundColor"
              :rol="rol"
              :tribunal="tribunal"
              :demandado="demandado"
              :representante="representante"
              :domicilio="domicilio"
              :text="text"
              :size="parseInt(size)"
              :font="font"
              :baseline="baseline"
              :angle="parseInt(angle)"
              :isTransparent="JSON.parse(isTransparent)"
              v-on:updated="updateDataURL($event)"
            />
          </div>
        </div>
        <div v-else>
          <div class="alert alert-danger" role="alert">
            Falta por lo menos un domicilio para el Demandado!
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
          </div>
        </div>
      </div>
      <div v-else class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">ALERTA!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"  @click="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="alert alert-danger" role="alert">
            Falta por lo menos un domicilio para el Demandado!
          </div>
        </div>
        <div class="modal-footer">
            <button
              type="button" 
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
import AppAnchor from '../../components/textrator/AppAnchor'
import AppButton from '../../components/textrator/AppButton'
import AppCanvas from '../../components/textrator/AppCanvas'
import AppDatalist from '../../components/textrator/AppDatalist'
import AppHeader from '../../components/textrator/AppHeader'
import AppInput from '../../components/textrator/AppInput'
import FormCentered from '../../components/textrator/FormCentered'
import InputLabeled from '../../components/textrator/InputLabeled'
import SelectLabeled from '../../components/textrator/SelectLabeled'

export default {
  name: 'PrintCedulaModal',
  props: {
      ModalCedulaVisible:{
        Boolean,
      },
      idxGestion:{
        Object,
      },
      
  },
  components: {
    AppAnchor,
    AppButton,
    AppCanvas,
    AppDatalist,
    AppHeader,
    AppInput,
    FormCentered,
    InputLabeled,
    SelectLabeled,
  },
  data () {
    return {
      text: '',
      size: 15,
      font: 'sans-serif',
      baseline: 'middle',
      foregroundColor: '#000000',
      backgroundColor: '#ffffff',
      height: 256,
      width: 475,
      angle: 0,
      fonts: FONTS,
      isTransparent: true,
      dataURL: '',
      selectedSizeId: null,
      sizeList: SIZE_PRESETS,
      baselineList: BASELINES,
      isHidden: false,
      rol: '',
      tribunal: '',
      demandado: '',
      representante: '',
      domicilio: '',
      nota: '',
      xdemandadoModel: [],
      xdomicilio: [],
      arrayDomicilio: [],
    }
  },
  methods: {
    updateDataURL: function (dataURL) {
      this.dataURL = dataURL
    },
    updateSize: function (sizeId) {
      if (0 < sizeId) {
        let size = this.sizeList.find(x => x.id === parseInt(sizeId))
        this.width = size.width
        this.height = size.height
      }
    },
    updateBaseline: function (id) {
      if (0 < id) {
        this.baseline = this.baselineList.find(x => x.id === parseInt(id)).name
      }
    },
    onSelectedDomicilio(e){
        if(e.domicilio){
          this.arrayDomicilio = e.domicilio;
          this.demandadoFill(e);
        }else{
          console.log('El cliente no tiene Domicilio');
        }
    },
    offSelectedArancel(e){
        if(!e){
          this.arrayDomicilio = [];
        }
    },
    demandadoFill(demandado){
      //let xdemandado ='';
      //let xrepresentante= '';

      if(demandado.tipo_persona == "natural"){
          let xdemandado = 'Demandado: '+demandado.name+' Rut: '+demandado.rut;
          
          this.demandado = xdemandado;
      }else{
          let xdemandado = 'Demandado: '+demandado.name+' Rut: '+demandado.rut;
          let xrepresentante = 'Representante: '+demandado.representante;

          this.demandado = xdemandado;
          this.representante = xrepresentante;
      }

      
    },
    deligenciaFill(){
      if(this.idxGestion){
      
      let xydomicilio = '';

      let xrol = 'Rol: '+ this.idxGestion.deligencia.rol;
      let xtribunal = 'Tribunal: '+this.idxGestion.deligencia.tribunal;
      
      if(this.arrayDomicilio.length>0){
        let xydomicilio = 'Domicilio: Por favor selecciona un domicilio';
      }else{
        let xydomicilio = 'Domicilio: El demandado no cuenta con domicilios, por favor agregar por lo menos uno!';
      }    

      this.rol = xrol;
      this.tribunal = xtribunal;
      this.domicilio = xydomicilio;
      }
    },
    deligenciaClean(){
          this.text= '';
          this.size= 15;
          this.font= 'sans-serif';
          this.baseline= 'middle';
          this.foregroundColor= '#000000';
          this.backgroundColor= '#ffffff';
          this.height= 256;
          this.width= 475;
          this.angle= 0;
          this.fonts= FONTS;
          this.isTransparent= true;
          this.dataURL= '';
          this.selectedSizeId= null;
          this.sizeList= SIZE_PRESETS;
          this.baselineList= BASELINES;
          this.isHidden= false;
          this.rol= '';
          this.tribunal= '';
          this.demandado= '';
          this.representante= '';
          this.domicilio= '';
          this.nota= '';
          this.xdemandadoModel = [];
          this.xdomicilio= [];
          this.arrayDomicilio= [];
    },
    onSelected(){
      if(typeof this.xdomicilio != "undefined"){
        let xydomicilio = 'Domicilio: '+this.xdomicilio.direccion+' '+this.xdomicilio.numero+','+this.xdomicilio.comuna+','+this.xdomicilio.region;
        this.domicilio = xydomicilio;
      }

    },
    onNota(){
      if(this.nota!=''){
          this.text = 'Comentario: '+this.nota;
      }
    },
    AnguloBase(){
      if(this.angle == 0){
          this.angle = 270;
          this.height = 475;
          this.width = 250
        }else{
          this.angle = 0;
          this.height = 250;
          this.width = 475;
        }
    },
    close() {;
        $('#modalCedula').modal('hide');
        this.$emit('close');
    },
  },
  watch: {
        ModalCedulaVisible: function(newtext){
            this.deligenciaClean();
            this.deligenciaFill();
        },
  },
  mounted() {
    console.log('Componente imprimir cedula montado.')
  }
}

const FONTS = [
  'arial',
  'verdana',
  'tahoma',
  'georgia',
  'times new roman',
  'courier new',
  'andale mono'
]

const BASELINES = [
  {
    id: 1,
    name: 'top'
  },
  {
    id: 2,
    name: 'hanging'
  },
  {
    id: 3,
    name: 'middle'
  },
  {
    id: 4,
    name: 'alphabetic'
  },
  {
    id: 5,
    name: 'ideographic'
  },
  {
    id: 6,
    name: 'bottom'
  }
]

const SIZE_PRESETS = [
  {
    id: 1,
    name: 'favicon (32 x 32)',
    height: 32,
    width: 32
  },
  {
    id: 2,
    name: '128 x 128',
    height: 128,
    width: 128
  },
  {
    id: 3,
    name: '256 x 256',
    height: 256,
    width: 256
  }
]
</script>

<style>
body {
  margin: 0;
}
#app {
  text-align: center;
}
.container {
  display: flex;
  flex-direction: column;
}
</style>

