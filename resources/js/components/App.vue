<template>
  <div>
    <div><button type="button" class="btn btn-primary" @click="generateDump">Generate Dump</button></div>
    <div class="columns">
        <div class="column" v-for="(column, index) in columns" :key="index">
            <div class="column__header">
                <h3>{{column.title}}</h3>
                <div class="column__header__action">
                    <span @click="showAddCardModal(column.id, $modal)">
                        <i class="fa fa-plus" aria-hidden="true"></i>
                    </span>
                    <span @click="removeColumn(column.id)">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </span>
                    
                </div>
            </div>
            <draggable class="cards" tag="ul" v-model="column.cards" v-bind="dragOptions"  @start="isDragging=true" @remove="onRemove(column.id)" @add="onAdd(column.id)">
                <transition-group type="transition" :name="'flip-list'">
                    <li class="card" v-for="(element, cardIndex) in column.cards" :key="`key-${cardIndex}`">
                        {{element.title}}
                    </li>
                </transition-group>
            </draggable>
        </div>

        <div class="column">
            <h3>Add New Column</h3>
            <form @submit.prevent="addColumn">
                <div>
                    <input type="text" placeholder="Title" v-model="title">
                </div>
                <button type="submit" class="btn btn-primary">Add Column</button>
            </form>
        </div>
    </div>
    <AddCardModal v-bind:column="column"  @addedCard="onAddedCard"/>
  </div>
</template>

<script>
import draggable from "vuedraggable";
import AddCardModal from './AddCard.vue'

export default {
    name: "Bemo",
    components: {
        draggable,
        AddCardModal
    },
    created() {
        this.axios
            .get(`${process.env.MIX_API_URL}/api/columns`) 
            .then(response => {
                this.columns = response.data;
            });
    },  
    data() {
        return {
            editable: true,
            isDragging: false,
            delayedDragging: false,
            title: '',
            column: 0,
            columns: []
        };
    },
    methods: {
        generateDump: function () {
            this.axios
                .get(`${process.env.MIX_API_URL}/api/dump`) 
                .then(response => {
            }); 
        },
        updateColumn: function (columnId) {
            const foundIndex = this.columns.findIndex(column => column.id == columnId);
            const data = {
                column: this.columns[foundIndex]
            };

            this.axios
                .post(`${process.env.MIX_API_URL}/api/column`, data) 
                .then(response => {
            });           
        },
        onRemove: function (column) {
            this.updateColumn(column);
        }, 
        onAdd: function (column) {
            this.updateColumn(column);
        },    
        addColumn() {
            if (this.title) {
                let that = this;
                const data = {
                    title: this.title
                };
                this.axios
                    .post(`${process.env.MIX_API_URL}/api/column/add`, data)
                    .then(response => {
                        that.columns.unshift({
                            title: that.title,
                            cards: [],
                            id: response.data.id
                        });
                        that.title = ''
                    })
                    .catch(error => console.log(error))
                    .finally(() => this.loading = false)

            }
        },
        removeColumn(id) {

            this.axios
                .delete(`${process.env.MIX_API_URL}/api/column/${id}`) 
                .then(response => {
                    const newColumns = this.columns.filter(object => {
                        return object.id !== id;
                    });

                    this.columns = newColumns;

                });

        },
        showAddCardModal(column, $modal) {
            this.column = column;
            $modal.show('add-card-modal');
        },
        onAddedCard(card) {
            const foundIndex = this.columns.findIndex(column => column.id == card.column_id);
            this.columns[foundIndex].cards.unshift(card);

            const data = {
                column: this.columns[foundIndex]
            };

            this.axios
                .post(`${process.env.MIX_API_URL}/api/column`, data) 
                .then(response => {
            });
        }
    },
    computed: {
        dragOptions() {
            return {
                animation: 0,
                group: "description",
                disabled: !this.editable,
                ghostClass: "ghost"
            };
        }
    },
    watch: {
        isDragging(newValue) {
            if (newValue) {
                this.delayedDragging = true;
                return;
            }
            this.$nextTick(() => {
                this.delayedDragging = false;
            });
        }
    }
};
</script>

