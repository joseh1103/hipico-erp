<template>
<div>
 <v-select :disabled="disabledComponen" label="user" :value="userModel.user" 
 class="style-search"
 placeholder="Seleccionar Usuario"
 @input="setUserForm" 
:options="usersList.data">
    <template slot="no-options">
        Buscar Usuario 
    </template>
  </v-select>
</div>
</template>

<script>
export default {
    props: {
      selectedUser: Function,
      userModel: Object,
      usersList: Object,
      id_update: Number,
      disabledComponen: Boolean
    },
    data () {
      return {
      }
    },
    watch: {
    },
    methods: {
      setUserForm(item) {
        this.selectedUser(item, this.id_update)
      }
    },
  }
</script>
<style>
  .style-search .vs__search::placeholder,
  .style-search .vs__dropdown-toggle,
  .style-search .vs__dropdown-menu {
    background: #FFFFFF;
    color: #EB7D25;
  }

  .style-search .vs__clear,
  .style-search .vs__open-indicator {
    fill: #EB7D25;
  }
  .style-search {
    width: 100% !important;
  }

  .vs__search, .vs__search:focus {
    line-height: 2.0 !important;
}
</style>
