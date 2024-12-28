<template>
  <div
    v-if="isVisible"
    class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-15 py-2 px-2 w-full h-full bottom-border border-b border-gray-200 text-sm"
    :class="endDayCountdown, (!isEditMode ? 'items-center' : 'items-end')"
  >
    <!-- Name -->
    <div class="lg:col-span-2 flex flex-row items-center">
      <a v-if="!hideArrow && !isEditMode" @click="toogleUserHistoryData()">
        <svg
          class="w-2.5 h-2.5 m-2 invert"
          :class="{ 'transform scale-y-[-1]': openUserHistoryRecords }"
          aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 10 6"
        >
          <path
            stroke="black"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="m1 1 4 4 4-4"
          />
        </svg>
      </a>
      <h2 v-if="!isEditMode" class="pl-2">{{ editableName }}</h2>
      <input
        v-else
        type="text"
        v-model="editableName"
        class="bg-transparent bg-gray-800 text-white py-3 pl-2 outline-none bottom-border border-b border-gray-200"
      />
    </div>
    <div class="lg:col-span-1">
      <!-- Phone Number -->
      <h2 v-if="!isEditMode">{{ editablePhoneNumber }}</h2>
      <input
        v-else
        type="text"
        v-model="editablePhoneNumber"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
    </div>
    <!-- Email -->
    <div class="lg:col-span-3 ml-12">
      <h2 v-if="!isEditMode">{{ editableEmail }}</h2>
      <input
        v-else
        type="email"
        v-model="editableEmail"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
    </div>
    <!-- Tips -->
    <div class="lg:col-span-2">
      <h2 v-if="!isEditMode">{{ editableType }}</h2>
      <select
        v-else
        id="options"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
        v-model="editableType"
      >
        <option value="RX">RX</option>
        <option value="FF">FF</option>
        <option value="1 nedēļa">1 nedēļa</option>
        <option value="Teens">Teens</option>
        <option value="10x abonaments">10x abonaments</option>
      </select>
    </div>
    <!-- Date -->
    <div class="lg:col-span-2">
      <h2 v-if="!isEditMode">{{ formattedEditableStartDate }}</h2>
      <input
        v-else-if="editMode"
        type="date"
        v-model="newUserStartDate"
        value="newUserStartDate"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
      <input
        v-else
        type="date"
        v-model="editableStartDate"
        value="editableStartDate"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
    </div>
    <div class="lg:col-span-2">
      <h2 v-if="!isEditMode">{{ formattedEditableEndDate }}</h2>
      <input
        v-else-if="editableType === '10x abonaments' && editMode"
        type="text"
        v-model="newUserEndDate"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
      <input
        v-else-if="editMode"
        type="date"
        v-model="newUserEndDate"
        value="newUserEndDate"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />

      <input
        v-else-if="editableType === '10x abonaments'"
        type="text"
        v-model="editableEndDate"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
      <input
        v-else
        type="date"
        v-model="editableEndDate"
        value="editableEndDate"
        class="bg-transparent bg-gray-800 text-white py-3 outline-none bottom-border border-b border-gray-200"
      />
    </div>
    <!-- Active status -->
    <h2 class="lg:col-span-1" :class="{ 'pb-3': isEditMode }">{{ isActive }}</h2>

    <!-- Edit and Add new user buttons -->
    <div v-if="!isEditMode && !hideArrow && !isTempUser" class="lg:col-span-2 flex flex-row gap-4">
      <a @click="toggleEditMode()">
        <img class="ml-3 h-5 invert" src="../assets/edit-icon.png" />
      </a>
      <a @click="addNewUser()">
        <img class="ml-3 h-5 invert" src="../assets/circle-plus-icon.png" />
      </a>
    </div>

    <div v-if="isEditMode && !editMode" class="lg:col-span-2 flex flex-col">
      <div class="flex items-center gap-2 justify-center">
        <button
          type="button"
          class="relative inline-flex items-center justify-center p-0.5 h-1/2 text-xxs overflow-hidden font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-green-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
          @click="saveEditedUser()"
        >
          <span
            class="w-full relative px-1 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
          >
            Saglabāt
          </span>
        </button>
        <button
          type="button"
          class="relative inline-flex items-center justify-center p-0.5 h-3/4 overflow-hidden text-xxs font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-orange-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
          @click="cancelEdit()"
        >
          <span
            class="w-full relative px-1 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
          >
            Atcelt
          </span>
        </button>
        <button
          type="button"
          class="relative inline-flex items-center justify-center p-0.5 h-3/4 overflow-hidden text-xxs font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-red-600 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
          @click="deleteRecord()"
        >
          <span
            class="w-full relative px-1 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
          >
            Dzēst
          </span>
        </button>
      </div>
      <p class="error">
        {{ errorMessage }}
      </p>
    </div>
    <div v-else-if="editMode" class="lg:col-span-2 flex items-center justify-center gap-4">
      <button
        type="button"
        class="relative inline-flex items-center justify-center p-0.5 h-1/2 text-xxs overflow-hidden font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-green-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
        @click="saveDuplicatedUser()"
      >
        <span
          class="w-full relative px-3 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
        >
          Pievienot
        </span>
      </button>
      <button
        type="button"
        class="relative inline-flex items-center justify-center p-0.5 h-3/4 overflow-hidden text-xxs font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-orange-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
        @click="cancelNewUser()"
      >
        <span
          class="w-full relative px-1 py-2 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
        >
          Atcelt
        </span>
      </button>
    </div>
  </div>
</template>
<script>
import { useUserStore } from '@/stores/dataStore'
import axios from 'axios'

export default {
  props: {
    id: String,
    name: String,
    phoneNumber: String,
    email: String,
    type: String,
    startDate: String,
    endDate: String,
    isActive: String,
    daysTillEndOfSub: Number,
    hideArrow: Boolean,
    editMode: Boolean,
    isTempUser: Boolean,
  },
  data() {
    return {
      isEditMode: false,
      isEditModeDate: false,
      editableName: '',
      editablePhoneNumber: '',
      editableEmail: '',
      editableType: '',
      editableStartDate: '',
      editableEndDate: '',
      newUserStartDate: '',
      newUserEndDate: '',
      editableIsActive: '',
      lastSavedData: {},
      isVisible: true,
      errorMessage: '',
      openUserHistoryRecords: false
    }
  },
  emits: ['userHistoryOpened', 'editNewUserOpenIds'],
  computed: {
    is10xSubscription() {
      return this.editableType === '10x abonaments'
    },
    formattedEditableEndDate() {
      return this.formatDateDayMonthYear(this.editableEndDate)
    },
    formattedEditableStartDate() {
      return this.formatDateDayMonthYear(this.editableStartDate)
    },
    endDayCountdown() {
      if (this.hideArrow) {
        return
      }
      if (
        (this.daysTillEndOfSub == 0 && this.type != '10x abonaments') ||
        (this.type == '10x abonaments' && this.editableEndDate == '0')
      ) {
        return 'bg-red-950'
      }
      if (this.daysTillEndOfSub <= 2 && this.type != '10x abonaments') {
        return 'bg-yellow-600/75'
      }
    }
  },
  mounted() {
    this.userStore = useUserStore()
    this.editableName = this.name
    this.editablePhoneNumber = this.phoneNumber
    this.editableEmail = this.email || '-'
    this.editableType = this.type
    this.editableEndDate = this.formatDateYearMonthDay(this.endDate)
    this.editableStartDate = this.formatDateYearMonthDay(this.startDate)

    if (this.editMode) {
      this.isEditMode = true
    }

    this.lastSavedData = {
      name: this.editableName,
      phoneNumber: this.editablePhoneNumber,
      email: this.editableEmail,
      type: this.editableType,
      startDate: this.editableStartDate,
      endDate: this.editableEndDate
    }
  },
  methods: {
    cancelNewUser() {
      this.$emit('editNewUserOpenIds', this.id, false)
    },
    addNewUser() {
      this.$emit('editNewUserOpenIds', this.id, true)
    },
    toogleUserHistoryData() {
      this.openUserHistoryRecords = !this.openUserHistoryRecords
      this.$emit('userHistoryOpened', this.editablePhoneNumber, this.id)
    },
    // Needed for input date, it changes order of date
    formatDateYearMonthDay(givenDate) {
      // For x time subscription type
      if (!givenDate.includes('-')) {
        return givenDate
      }
      const [day, month, year] = givenDate.split('-')
      const date = new Date(+year, +month - 1, +day)
      const yearFormatted = date.getFullYear()
      let monthFormatted = date.getMonth() + 1
      let dayFormatted = date.getDate()
      monthFormatted = monthFormatted.toString().padStart(2, '0')
      dayFormatted = dayFormatted.toString().padStart(2, '0')

      return `${yearFormatted}-${monthFormatted}-${dayFormatted}`
    },
    // Needed for input date, it changes order of date
    formatDateDayMonthYear(givenDate) {
      // For x time subscription type
      if (!givenDate.includes('-')) {      
        return givenDate
      }
      const [year, month, day] = givenDate.split('-')
      const date = new Date(+year, +month - 1, +day)
      const dayFormatted = String(date.getDate()).padStart(2, '0')
      const monthFormatted = String(date.getMonth() + 1).padStart(2, '0')
      const yearFormatted = String(date.getFullYear())

      return `${dayFormatted}-${monthFormatted}-${yearFormatted}`
    },
    toggleEditMode() {
      if (!this.endDate.includes('-')) {
        this.isEditModeDate = !this.isEditModeDate
      }

      this.isEditMode = !this.isEditMode
    },
    saveDuplicatedUser() {
      let lastName = this.editableName.split(' ')
      if (lastName[1]) {
        lastName = ' '
      }
      const formData = {
        firstName: this.editableName,
        lastName: lastName,
        email: this.editableEmail || '-',
        phoneNumber: this.editablePhoneNumber,
        subscriptionType: this.editableType,
        startDate: this.formatDateDayMonthYear(this.newUserStartDate),
        endDate: this.formatDateDayMonthYear(this.newUserEndDate)
      }
      axios
        .post(import.meta.env.VITE_SERVER_URL + '/addNewUser', formData)
        .then((res) => {
          this.userStore.addNewUser(res.data)
        })
        .catch((error) => {
          console.error('Error at adding new user: ' + error)
        })
      this.$emit('editNewUserOpenIds', this.id, false)
    },
    saveEditedUser() {
      if (!this.validateEmailAndSubscriptionType()) {
        return
      }
      this.lastSavedData = {
        name: this.editableName,
        phoneNumber: this.editablePhoneNumber,
        email: this.editableEmail || '-',
        type: this.editableType,
        startDate: this.editableStartDate,
        endDate: this.editableEndDate
      }
      const formData = {
        id: this.id,
        firstName: this.editableName,
        email: this.editableEmail || '-',
        phoneNumber: this.editablePhoneNumber,
        startDate: this.formatDateDayMonthYear(this.editableStartDate),
        endDate: this.formatDateDayMonthYear(this.editableEndDate),
        subscriptionType: this.editableType,
        Status: this.isActive
      }
      axios
        .post(import.meta.env.VITE_SERVER_URL + '/editUser', formData)
        .then((res) => {      
          this.editableEndDate = this.formatDateYearMonthDay(res.data.EndDate)
          this.editableStartDate = this.formatDateYearMonthDay(res.data.StartDate)
          this.userStore.editUserById(this.id, res.data)
        })
        .catch((error) => {
          console.error('Error at editing user: ' + error)
        })

      this.toggleEditMode()
    },
    cancelEdit() {
      this.editableName = this.lastSavedData.name
      this.editablePhoneNumber = this.lastSavedData.phoneNumber
      this.editableEmail = this.lastSavedData.email
      this.editableStartDate = this.lastSavedData.startDate
      this.editableEndDate = this.lastSavedData.endDate
      this.editableType = this.lastSavedData.type
      this.toggleEditMode()
    },

    deleteRecord() {
      axios
        .post(import.meta.env.VITE_SERVER_URL + '/deleteUser', { Id: this.id })
        .then((res) => {
          console.log(res.data.message)
        })
        .catch((error) => {
          console.error('Error at deleting user: ' + error)
        })

      this.isVisible = false
      this.toggleEditMode()
    },
    validateEmailAndSubscriptionType() {
      if (!this.editableName.trim() || !this.editablePhoneNumber.trim()) {
        this.errorMessage = 'Lūdzu pievienojiet visu nepieciešamo informāciju'
        return false
      }

      this.errorMessage = ''
      return true
    }
  }
}
</script>
<style>
input[type='date']::-webkit-calendar-picker-indicator {
  filter: invert(1);
}

select option {
  margin: 40px;
  background-color: #1b1b1b;
  color: #fff;
  text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
}

.text-xxs {
  font-size: 0.7rem;
}
</style>
