<script setup>
import ContentTable from '../components/ContentTable.vue'
import AddNewUserField from '../components/AddNewUserField.vue'
import SearchField from '../components/SearchField.vue'
</script>

<template>
  <div class="bg-grey-700 flex justify-center flex-col rounded-lg">
    <div class="flex flex-col justify-around">
      <h2 class="text-3xl text-white">Lietotāju reģistrēšana</h2>
      <!-- <h3 class="text-xl text-white">Welcome to template page!</h3> -->
    </div>
    <div class="flex flex-row flex-wrap my-4 justify-between">
      <SearchField @errorMessage="errorMessage = $event"/>
      <button
        type="button"
        class="relative inline-flex items-center justify-center p-0.5 mb-3 overflow-hidden text-sm font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-custom-yellow group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
        @click="addNewUser()"
      >
        <span
          class="w-full relative px-3 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
        >
          Pievienot jaunu klientu
        </span>
      </button>
      <p v-if="errorMessage" class="mt-4 error w-full">
        {{ errorMessage }}
      </p>
    </div>

    <AddNewUserField v-if="showAddNewUserField" @submit="addNewUser($event)" />
    <ContentTable class="rounded-lg" :users="allUsers" />
  </div>
</template>

<script>
import axios from 'axios'
import { useUserStore } from '@/stores/dataStore'

export default {
  data() {
    return {
      username: 'Gunta',
      showAddNewUserField: false,
      userStore: null,
      allUsers: [],
      errorMessage: ''
    }
  },
  mounted() {
    this.userStore = useUserStore()
    this.fetchAllUsers()
  },
  methods: {
    addNewUser(value = true) {
      this.showAddNewUserField = value
    },
    fetchAllUsers() {
      axios
        .get(import.meta.env.VITE_SERVER_URL + '/getAllUsers')
        .then((res) => {
          console.log(res.data);
          
          this.userStore.setAllUsers(res.data)
          this.allUsers = res.data
        })
        .catch((error) => {
          console.error('Error at all user data fetching: ' + error)
        })
    }
  }
}
</script>
