<template>
  <div>
    <input
      type="text"
      v-model="lastName"
      placeholder="Meklēt pēc uzvārda"
      class="bg-transparent bg-gray-800 text-white p-3 outline-none bottom-border border-b border-gray-200"
      @keyup.enter="searchUser()"
    />
    <button
      type="button"
      class="relative inline-flex items-center justify-center p-0.5 ml-4 overflow-hidden text-sm font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-custom-yellow group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
      @click="searchUser()"
    >
      <span
        class="w-full relative px-3 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
      >
        Meklēt
      </span>
    </button>
    <button
      type="button"
      class="relative inline-flex items-center justify-center p-0.5 ml-4 overflow-hidden text-sm font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-red-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
      @click="cancel()"
    >
      <span
        class="w-full relative px-3 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
      >
        Atcelt
      </span>
    </button>
  </div>
</template>

<script>
import axios from 'axios'
import { useUserStore } from '@/stores/dataStore'
import { mapState } from 'pinia'

export default {
  data() {
    return {
      lastName: ''
    }
  },
  emits: ['errorMessage'],
  mounted() {
    this.userStore = useUserStore()
  },
  computed: {
    ...mapState(useUserStore, ['users'])
  },
  methods: {
    searchUser() {
      if (this.lastName === '') {
        return
      }
      const filteredArray = this.users.filter((obj) => obj.LastName === this.lastName)
      if (filteredArray.length) {
        this.$emit('errorMessage', '')
        this.userStore.setSearchedUsers(filteredArray)
        return
      }
      this.$emit('errorMessage', 'Lietotājs netika atrasts')
      this.userStore.setSearchedUsers([])
      return
      axios
        .post(import.meta.env.VITE_SERVER_URL + '/api/searchUser', { lastName: this.lastName })
        .then((response) => {
          console.log(response.data)
          // this.userStore.setSearchedUsers(response.data || [])
          //Add user to searchedUsers Array, when pagination is implemented
        })
        .catch((error) => {
          console.error(error)
        })
    },
    cancel() {
      this.lastName = ''
      this.$emit('errorMessage', '')
      this.userStore.setSearchedUsers([])
    }
  }
}
</script>
