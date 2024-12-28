<script setup>
import RecordRow from '../components/RecordRow.vue'
</script>
<template>
  <div class="p-0.5 text-white justify-center items-center rounded-lg">
    <div
      class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-15 p-3 w-full h-full bg-gray-200 rounded-md text-black font-bold text-base sticky top-0 z-10 items-center"
    >
      <div class="col-span-2 flex flex-row gap-2">
        <h2>Vārds Uzvārds</h2>
        <button @click="sortByName()">
          <img class="h-6 w-5" src="../assets/sort-icon-md.png" />
        </button>
      </div>
      <div class="col-span-1">
        <h2>Telefons</h2>
      </div>
      <div class="col-span-3 ml-12">
        <h2>E-pasts</h2>
      </div>
      <div class="col-span-2 flex flex-row gap-2">
        <h2>Abonaments</h2>
        <button @click="toggleSubscriptionMenu()">
          <svg
            class="w-2.5 h-2.5 m-2"
            :class="{ 'transform scale-y-[-1]': subscriptionMenuOpen }"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 10 6"
          >
            <path
              stroke="black"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="3"
              d="m1 1 4 4 4-4"
            />
          </svg>
        </button>
      </div>
      <div class="col-span-2 flex flex-row gap-2">
        <div>Sākuma datums</div>
      </div>
      <div class="col-span-2 flex flex-row gap-2">
        <div>
          Beigu datums
          <p>/apmeklējumu skaits</p>
        </div>

        <button @click="sortByEndDate()">
          <img class="h-6 w-5" src="../assets/sort-icon-md.png" />
        </button>
      </div>
      <div class="col-span-1 flex flex-row gap-2">
        <h2>Status</h2>
        <button @click="toggleStatusMenu()">
          <svg
            class="w-2.5 h-2.5 m-2"
            :class="{ 'transform scale-y-[-1]': statusMenuOpen }"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 10 6"
          >
            <path
              stroke="black"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="3"
              d="m1 1 4 4 4-4"
            />
          </svg>
        </button>
      </div>
      <div class="col-span-2 flex flex-row gap-2">
        <h2>Rediģēt</h2>
      </div>
    </div>
    <!-- Dropdown menu -->
    <div
      v-if="subscriptionMenuOpen"
      id="dropDownMenu"
      class="absolute -mt-1 w-48 divide-y divide-gray-100 rounded-lg shadow bg-custom-dark-grey"
    >
      <ul
        class="p-3 space-y-3 text-sm text-gray-700 text-gray-200 border border-t-0 border-gray-200 rounded"
      >
        <li v-for="type in subriptionTypes">
          <div class="flex items-center">
            <input
              type="checkbox"
              v-model="checkedItems"
              :value="type"
              class="w-4 h-4 text-blue-600 bg-custom-dark-grey border-gray-300 rounded focus:ring-blue-500"
            />
            <label class="ms-2 text-sm font-medium text-gray-300">
              {{ type }}
            </label>
          </div>
        </li>
      </ul>
    </div>
    <!-- Dropdown menu -->
    <div
      v-if="statusMenuOpen"
      id="statusDropDownMenu"
      class="absolute -mt-1 w-48 divide-y divide-gray-100 rounded-lg shadow bg-custom-dark-grey"
    >
      <ul
        class="p-3 space-y-3 text-sm text-gray-700 text-gray-200 border border-t-0 border-gray-200 rounded"
      >
        <li v-for="type in statusTypes">
          <div class="flex items-center">
            <input
              type="checkbox"
              v-model="checkedStatusItems"
              :value="type"
              class="w-4 h-4 text-blue-600 bg-custom-dark-grey border-gray-300 rounded focus:ring-blue-500"
            />
            <label class="ms-2 text-sm font-medium text-gray-300">
              {{ type }}
            </label>
          </div>
        </li>
      </ul>
    </div>
    <!-- Rows of newly added users -->
    <div v-if="tempNewlyAddedUsers" v-for="(tempUser, index) in tempNewlyAddedUsers" :key="index">
      <RecordRow
        :id="tempUser.Id || ''"
        :name="tempUser.FirstName + ' ' + (tempUser.LastName || '')"
        :phoneNumber="tempUser.PhoneNumber"
        :email="tempUser.Email"
        :type="tempUser.SubscriptionType"
        :startDate="tempUser.StartDate"
        :endDate="tempUser.EndDate"
        :isActive="tempUser.Status"
        :daysTillEndOfSub="tempUser.DaysTillEndOfSub"
        :hideArrow="false"
        :editMode="false"
        :isTempUser="false"
        @userHistoryOpened="openUserHistory"
        @editNewUserOpenIds="editNewUserOpenIds"
      />
      <RecordRow
        v-if="
          checkedItems.includes(tempUser.SubscriptionType) &&
          checkedStatusItems.includes(tempUser.Status) &&
          userIdAddNewUserOpened.includes(tempUser.Id)
        "
        :id="tempUser.Id"
        :name="tempUser.FirstName + ' ' + (tempUser.LastName || '')"
        :phoneNumber="tempUser.PhoneNumber"
        :email="tempUser.Email"
        :type="tempUser.SubscriptionType"
        :startDate="tempUser.StartDate"
        :endDate="tempUser.EndDate"
        :isActive="tempUser.Status"
        :daysTillEndOfSub="tempUser.DaysTillEndOfSub"
        :hideArrow="true"
        :editMode="true"
        @editNewUserOpenIds="editNewUserOpenIds"
      />
      <RecordRow
        v-if="userIdHistoryOpened.includes(tempUser.Id)"
        v-for="(userHistoryItem, index2) in userHistoryItems[tempUser.Id]"
        :key="index2"
        class="bg-slate-500"
        :id="userHistoryItem.Id"
        :name="userHistoryItem.FirstName + ' ' + userHistoryItem.LastName"
        :phoneNumber="userHistoryItem.PhoneNumber"
        :email="userHistoryItem.Email"
        :type="userHistoryItem.SubscriptionType"
        :startDate="userHistoryItem.StartDate"
        :endDate="userHistoryItem.EndDate"
        :isActive="userHistoryItem.Status"
        :daysTillEndOfSub="userHistoryItem.DaysTillEndOfSub"
        :hideArrow="true"
      />
    </div>

    <div v-if="allUsers.length" v-for="(user, index) in allUsers" :key="index">
      <RecordRow
        v-if="
          checkedItems.includes(user.SubscriptionType) && checkedStatusItems.includes(user.Status)
        "
        :id="user.Id || ''"
        :name="user.FirstName + ' ' + (user.LastName || '')"
        :phoneNumber="user.PhoneNumber"
        :email="user.Email"
        :type="user.SubscriptionType"
        :startDate="user.StartDate"
        :endDate="user.EndDate"
        :isActive="user.Status"
        :daysTillEndOfSub="user.DaysTillEndOfSub"
        :hideArrow="false"
        :editMode="false"
        @userHistoryOpened="openUserHistory"
        @editNewUserOpenIds="editNewUserOpenIds"
      />
      <RecordRow
        v-if="
          checkedItems.includes(user.SubscriptionType) &&
          checkedStatusItems.includes(user.Status) &&
          userIdAddNewUserOpened.includes(user.Id)
        "
        :id="user.Id"
        :name="user.FirstName + ' ' + (user.LastName || '')"
        :phoneNumber="user.PhoneNumber"
        :email="user.Email"
        :type="user.SubscriptionType"
        :startDate="user.StartDate"
        :endDate="user.EndDate"
        :isActive="user.Status"
        :daysTillEndOfSub="user.DaysTillEndOfSub"
        :hideArrow="true"
        :editMode="true"
        @editNewUserOpenIds="editNewUserOpenIds"
      />
      <RecordRow
        v-if="userIdHistoryOpened.includes(user.Id)"
        v-for="(userHistoryItem, index2) in userHistoryItems[user.Id]"
        :key="index2"
        class="bg-slate-500"
        :id="userHistoryItem.Id"
        :name="userHistoryItem.FirstName + ' ' + userHistoryItem.LastName"
        :phoneNumber="userHistoryItem.PhoneNumber"
        :email="userHistoryItem.Email"
        :type="userHistoryItem.SubscriptionType"
        :startDate="userHistoryItem.StartDate"
        :endDate="userHistoryItem.EndDate"
        :isActive="userHistoryItem.Status"
        :daysTillEndOfSub="userHistoryItem.DaysTillEndOfSub"
        :hideArrow="true"
      />
    </div>
    <div v-else class="flex mt-10 justify-center">
      <h2>Lietotāji nav reģistrēti!</h2>
    </div>
  </div>
</template>

<script>
import { useUserStore } from '@/stores/dataStore'
import { mapState } from 'pinia'

export default {
  data() {
    return {
      subscriptionMenuOpen: false,
      statusMenuOpen: false,
      subriptionTypes: ['RX', 'FF', '1 nedēļa', 'Teens', '10x abonaments'],
      checkedItems: ['RX', 'FF', '1 nedēļa', 'Teens', '10x abonaments'],
      statusTypes: ['Aktīvs', 'Neaktīvs'],
      checkedStatusItems: ['Aktīvs', 'Neaktīvs'],
      userStore: {},
      sortFirstNameAscending: false,
      sortEndDateAscending: true,
      userIdAddNewUserOpened: [],
      userIdHistoryOpened: [],
      userHistoryItems: {},
      allUsers: [],
    }
  },
  computed: {
    ...mapState(useUserStore, ['users', 'tempNewlyAddedUsers', 'searchedUsers']),
  },
  watch: {
    searchedUsers: {
      handler(newValue) {
        if (newValue.length) {
          this.allUsers = []
          this.$nextTick(() => this.allUsers = this.searchedUsers)
        } else {
          this.allUsers = this.users
        }
      },
      deep: true
    },
    users: {
      handler() {
        this.allUsers = this.users
      },
      immediate: true,
      deep: true
    }
  },  
  mounted() {
    this.userStore = useUserStore()
  },
  methods: {
    editNewUserOpenIds(id, isOpened) {
      if (isOpened && !this.userIdAddNewUserOpened.includes(id)) {
        this.userIdAddNewUserOpened.push(id)
      } else {
        let index = this.userIdAddNewUserOpened.indexOf(id)
        if (index !== -1) {
          this.userIdAddNewUserOpened.splice(index, 1)
        }
      }
    },
    openUserHistory(phoneNumber, id) {
      if (
        this.userIdHistoryOpened.includes(id) &&
        Object.keys(this.userHistoryItems).includes(id)
      ) {
        delete this.userHistoryItems[id]
        this.userIdHistoryOpened = this.userIdHistoryOpened.filter((userId) => userId !== id)
        return
      }
      this.userIdHistoryOpened.push(id)
      const newItem = {
        ...this.userHistoryItems,
        [id]: this.userStore.getUserHistory(phoneNumber, id)
      }
      this.userHistoryItems = newItem
    },
    toggleSubscriptionMenu() {
      this.subscriptionMenuOpen = !this.subscriptionMenuOpen
    },
    toggleStatusMenu() {
      this.statusMenuOpen = !this.statusMenuOpen
    },
    toggleFirstNameSort() {
      this.sortFirstNameAscending = !this.sortFirstNameAscending
    },
    toggleEndDateSort() {
      this.sortEndDateAscending = !this.sortEndDateAscending
    },
    sortByName() {
      this.toggleFirstNameSort()
      let allUsers = this.allUsers
      this.userStore.setAllUsers([])
      this.$nextTick(() =>
        this.userStore.sortUsersByFirstName(allUsers, this.sortFirstNameAscending)
      )
    },
    sortByEndDate() {
      this.toggleEndDateSort()
      let allUsers = this.allUsers
      this.userStore.setAllUsers([])
      this.$nextTick(() => this.userStore.sortUsersByEndDate(allUsers, this.sortEndDateAscending))
    }
  }
}
</script>
<style>
#dropDownMenu {
  left: 39.5%;
}
#statusDropDownMenu {
  right: 16%;
  z-index: 1;
}
p {
  font-size: 0.75rem;
}
</style>
