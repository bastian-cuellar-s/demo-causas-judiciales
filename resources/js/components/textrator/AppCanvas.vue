<template>
  <div>
    <canvas
      id="cv"
      :height="height"
      :width="width"
    >
    </canvas>
    <div hidden>
      {{ backgroundColor }}
      {{ foregroundColor }}
      {{ rol }}
      {{ tribunal }}
      {{ domicilio }}
      {{ text }}
      {{ size }}
      {{ font }}
      {{ baseline }}
      {{ isTransparent }}
      {{ angle }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'AppCanvas',
  props: {
    height: Number,
    width: Number,
    foregroundColor: String,
    backgroundColor: String,
    text: String,
    rol: String,
    tribunal: String,
    demandado: String,
    representante: String,
    domicilio: String,
    size: Number,
    font: String,
    baseline: String,
    angle: Number,
    isTransparent: Boolean
  },
  mounted () {
    this.draw()
    this.emitDataURL()
  },
  methods: {
    draw: function () {
      const cv = document.getElementById('cv')
      const ctx = cv.getContext('2d')
      ctx.clearRect(0, 0, this.width, this.height)
      ctx.font = this.size + 'px' + ' ' + this.font
      if (this.isTransparent) {
        ctx.clearRect(0, 0, this.width, this.height)
      } else {
        ctx.fillStyle = this.backgroundColor
        ctx.fillRect(0, 0, this.width, this.height)
      }
      ctx.fillStyle = this.foregroundColor
      ctx.textAlign = 'left'
      ctx.textBaseline = this.baseline
      ctx.save()
      ctx.translate(this.width / 2, this.height / 2)
      ctx.rotate(this.angle * Math.PI / 180)
      if(this.representante){
        ctx.fillText(this.rol, -230, -100)
        ctx.fillText(this.tribunal, -230, -80)  
        ctx.fillText(this.demandado, -230, -60)
        ctx.fillText(this.representante, -230, -40)  
        ctx.fillText(this.domicilio, -230, -20)  
        ctx.fillText(this.text, -230, 0)
      }
      else{
        ctx.fillText(this.rol, -230, -80)
        ctx.fillText(this.tribunal, -230, -60)  
        ctx.fillText(this.demandado, -230, -40)
        ctx.fillText(this.domicilio, -230, -20)  
        ctx.fillText(this.text, -230, 0)
      }  
      ctx.restore()
    },
    emitDataURL: function () {
      const dataURL = document.getElementById('cv').toDataURL('image/png')
      this.$emit('updated', dataURL)
    }
  },
  updated () {
    this.draw()
    this.emitDataURL()
  }
}
</script>

<style scoped>
canvas {
  margin-top: 10px;
  border: 1px dotted;
}
</style>
