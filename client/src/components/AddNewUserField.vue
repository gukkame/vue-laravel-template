<template>
  <div class="flex flex-row">
    <form
      class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 py-4 px-2 text-white items-end gap-2 text-sm"
    >
      <input
        type="text"
        placeholder="Vārds"
        class="bg-transparent bg-gray-800 text-white p-3 outline-none bottom-border border-b border-gray-200"
        v-model="firstName"
      />
      <input
        type="text"
        placeholder="Uzvārds"
        class="bg-transparent bg-gray-800 text-white p-3 outline-none bottom-border border-b border-gray-200"
        v-model="lastName"
      />
      <input
        type="email"
        placeholder="E-pasts"
        class="bg-transparent bg-gray-800 text-white p-3 outline-none bottom-border border-b border-gray-200"
        v-model="email"
      />
      <input
        type="tel"
        placeholder="Telefona nr."
        class="bg-transparent bg-gray-800 text-white p-3 outline-none bottom-border border-b border-gray-200"
        v-model="phoneNumber"
      />

      <select
        id="options"
        class="bg-custom-dark-grey p-3 outline-none bottom-border border-b border-gray-200 w-full"
        v-model="subscriptionType"
        :class="{ 'text-gray-400': subscriptionType === '-' }"
      >
        <option selected value="-">Abonaments:</option>
        <option value="RX">RX</option>
        <option value="FF">FF</option>
        <option value="1 nedēļa">1 nedēļa</option>
        <option value="Teens">Teens</option>
        <option value="10x abonaments">10x abonaments</option>
      </select>
      <div class="flex flex-row items-center gap-2">
        No:
        <input
          type="date"
          v-model="startDate"
          value="start"
          placeholder="start"
          class="bg-transparent bg-gray-800 py-3 outline-none bottom-border border-b border-gray-200"
          :class="{ 'text-gray-400': startDate === null }"
        />
      </div>
      <div v-if="subscriptionType !== '10x abonaments'" class="flex flex-row items-center gap-2">
        Līdz:
        <input
          type="date"
          v-model="endDate"
          value="endDate"
          class="bg-transparent bg-gray-800 p-3 outline-none bottom-border border-b border-gray-200"
          :class="{ 'text-gray-400': endDate === null }"
        />
      </div>
      <p class="col-span-2 error">
        {{ errorMessage }}
      </p>
    </form>
    <div class="flex items-center gap-2">
      <button
        type="button"
        class="relative inline-flex items-center justify-center p-0.5 mb-1 h-1/2 overflow-hidden text-sm font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-green-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
        @click="submit()"
      >
        <span
          class="w-full relative px-3 py-2.5 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
        >
          Pievienot
        </span>
      </button>
      <button
        type="button"
        class="relative inline-flex items-center justify-center p-0.5 mb-1 h-1/2 overflow-hidden text-sm font-medium text-white rounded-lg group bg-gradient-to-br from-custom-grey to-red-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-black"
        @click="cancel()"
      >
        <span
          class="w-full relative px-3 py-2.5 transition-all ease-in duration-75 bg-gray-900 rounded-md group-hover:bg-opacity-0"
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
  data() {
    return {
      firstName: '',
      lastName: '',
      email: '',
      phoneNumber: '+371',
      subscriptionType: '-',
      startDate: null,
      endDate: null,
      submitting: false,
      errorMessage: null
    }
  },
  emits: ['submit'],
  mounted() {
    this.userStore = useUserStore()
  },
  methods: {
    submit() {
      if (this.validateEmailAndSubscriptionType()) {
        this.addNewUser()
        this.$emit('submit', false)
      }
    },
    cancel() {
      this.$emit('submit', false)
    },
    formatDateDayMonthYear(givenDate){
      if (!givenDate) {
        return
      }
      if (!givenDate.includes('-')) {
        return givenDate
      }
      const [year, month, day] = givenDate.split('-');
      const date = new Date(+year, +month - 1, +day);
      const dayFormatted = String(date.getDate()).padStart(2, '0');
      const monthFormatted = String(date.getMonth() + 1).padStart(2, '0');
      const yearFormatted = String(date.getFullYear());
            
      return `${dayFormatted}-${monthFormatted}-${yearFormatted}`;
    },
    addNewUser() {    
      const formData = {
        firstName: this.firstName,
        lastName: this.lastName,
        email: this.email || '-',
        phoneNumber: this.phoneNumber,
        subscriptionType: this.subscriptionType,
        startDate: this.formatDateDayMonthYear(this.startDate),
        endDate: this.formatDateDayMonthYear(this.endDate),
      }
      axios
        .post(import.meta.env.VITE_SERVER_URL + '/addNewUser', formData, {
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')}
          }
        )
        .then((res) => {
          this.userStore.addNewUser(res.data)
        })
        .catch((error) => {
          console.error('Error at adding new user: ' + error)
        })
    },
    validateEmailAndSubscriptionType() {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/

      if (!this.firstName.trim() || !this.lastName.trim() || !this.phoneNumber.trim()) {
        this.errorMessage = 'Lūdzu pievienojiet visu nepieciešamo informāciju'
        return false
      } else if (this.subscriptionType == '-') {
        this.errorMessage = 'Abonaments nav izvēlēts'
        return false
      }
      this.errorMessage = ''
      return true
    }
  }
}
</script>
