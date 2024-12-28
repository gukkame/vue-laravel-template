<template>
  <nav class="w-full z-10 bg-gray-200 border-gray-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a
        href="https://www.sportfactory.lv/"
        target="_blank"
        class="flex items-center space-x-5 rtl:space-x-reverse"
      >
        <img
          src="https://www.sportfactory.lv/images/factory_logo_white.png"
          class="h-10 invert"
          alt="Sport Factory"
        />
        <span class="self-center text-2xl font-semibold whitespace-nowrap">Sport Factory</span>
      </a>
      <div
        v-if="userStats"
        class="relative inline-flex items-center justify-center py-2 px-6 overflow-hidden text-sm font-medium text-white rounded-lg bg-custom-dark-grey"
      >
        <div class="flex flex-col">
          <h3>
            Klienti kopā: &ensp; <b> {{ userStats.TotalUniqUserCount }}</b>
          </h3>
          <h3>
            Aktīvie klienti: &ensp; <b> {{ userStats.ActiveUniqUserCount }}</b>
          </h3>
          <h3>
            Neatktīvie klienti: &ensp; <b> {{ userStats.NonActiveUniqUserCount }}</b>
          </h3>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import mobileHelper from '../helpers/mobileHelper.js'
import axios from 'axios'

export default {
  mixins: [mobileHelper],
  data() {
    return {
      showMenu: true,
      userStats: null
    }
  },
  mounted() {
    this.fetchUserStatistics()
    if (this.isMobile()) {
      this.showMenu = false
    }
  },
  methods: {
    toggleMenu() {
      this.showMenu = !this.showMenu
    },
    fetchUserStatistics() {
      axios
        .get(import.meta.env.VITE_SERVER_URL + '/getStatistics')
        .then((res) => {
          this.userStats = res.data
        })
        .catch((error) => {
          console.error('Error at statistics data fetching: ' + error)
        })
    },
  }
}
</script>
