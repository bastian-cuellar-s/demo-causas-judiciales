<template>
  <div class="modal hide fade" id="modalArancel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;" @click.self="close">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <slot name="header">
            This is the default tile!
          </slot>
        </div>
        <section
          class="modal-body"
          id="modalDescription"
        >
          <slot name="body">
            This is the default body!
          </slot>
        </section>
      </div>
    </div>
  </div>
</template>

<script>

  export default {
    name: 'MissData',
    props: {
      ModalMissDataVisible:{
        Boolean,
      },
    },
    data(){
      return{
        
      }
    },
    methods: {
      arancelPersonaClean(){
        this.form.reset();
        this.searchQuery= null;
        this.sort_direction = 'desc';
        this.sort_field= 'updated_at';
        this.paginate = 15;
        this.fun= null;
      },
      arancelPersonaFill(){
        if(this.ModalArancelVisible){
          this.$store.dispatch('personas/searchPersona', {
                searchQuery: this.searchQuery,
                sort_direction: this.sort_direction,
                sort_field: this.sort_field,
                paginate: this.paginate,
                fun: this.fun,
          });

          this.$store.dispatch('paramAranceles/loadAllTipoArancel');

          if(this.idxPersona){
            this.form.persona_id = this.idxPersona; 
          }
        }

      },
      close() {
        this.$emit('close');
      },    
    },
    computed:
    {
    },
    watch:{
      ModalArancelVisible: function(newtext){
            this.arancelPersonaClean();
            this.arancelPersonaFill();
      },
    }
  };
</script>

