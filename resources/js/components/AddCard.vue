<template>
  <modal name="add-card-modal" transition="pop-out" :width="modalWidth" :focus-trap="true" :height="250">
    <div class="modal">
      <div class="modal__part">
        <div class="partition">
          <div class="partition__title">Add New Card</div>
          <div class="partition__form">
            <form autocomplete="false">
              <input id="title" type="text" placeholder="Title" v-model="title">
              <textarea id="description" placeholder="Description" v-model="description"></textarea>
              <button type="button" @click="addCard">Add Card</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </modal>
</template>
<script>
export default {
  name: 'AddCardModal',
  props: {
    column: {
      type: Number
    }
  },
  data() {
    return {
      modalWidth: 300,
      title: '',
      description: ''
    }
  },
  methods: {
    addCard() {
      if (this.title && this.description) {

        const data = {
          title: this.title,
          description: this.description,
          column_id: this.column,
        };
        this.$emit('addedCard', data);
        this.title = '';
        this.description = '';
      }
    }
  }
}
</script>