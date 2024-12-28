import { defineStore } from 'pinia'

export const useUserStore = defineStore('userStore', {
  state: () => ({
    users: [],
    tempNewlyAddedUsers: [],
    searchedUsers: [],
  }),
  getters: {
    allUsers: (state) => state.users,
  },
  actions: {
    getUserHistory(targetPhoneNumber, id){
      return this.users.filter(obj => obj.PhoneNumber.toLowerCase() === targetPhoneNumber.toLowerCase() && obj.Id !== id);
    },
    setAllUsers(users) {
      this.users = users
    },
    setSearchedUsers(users) {
      this.searchedUsers = users
    },
    addNewUser(user) {      
      if (!user.Id) {
        user.Id = this.generateRandomFiveDigitString()
      }
        this.tempNewlyAddedUsers.push((user))
    },

    editUserById(id, newUserData) {     
      const userIndex = this.users.findIndex((user) => user.Id === id)
      let tempUserIndex = -1
      if (this.tempNewlyAddedUsers.length) {     
        tempUserIndex = (this.tempNewlyAddedUsers).findIndex((user) => user.Id === id)
      }

      if (userIndex !== -1) {       
        this.users[userIndex] = { ...this.users[userIndex], ...newUserData }
      } else if (tempUserIndex !== -1) {
        this.tempNewlyAddedUsers[tempUserIndex] = { ...this.tempNewlyAddedUsers[tempUserIndex], ...newUserData }
      } else {
        console.warn(`User with id ${id} not found.`)
      }
    },
    sortByStartDay(allUsers, ascending = true) {
      const sortedUsers = allUsers.sort((a, b) => {
        if (!a.toString().includes('-') && parseInt(a) < 11 ) {
          return 1
        }
        const dateA = new Date(a.StartDate.split('-').reverse().join('-'));
        const dateB = new Date(b.StartDate.split('-').reverse().join('-'));
        return ascending ? dateA - dateB : dateB - dateA;
      });

      this.setAllUsers(sortedUsers)
    },
    sortUsersByFirstName(allUsers, ascending = true) {
      const sortedUsers = allUsers.sort((a, b) => {
        const nameA = a.FirstName.toLowerCase()
        const nameB = b.FirstName.toLowerCase()
        if (nameA < nameB) return ascending ? -1 : 1
        if (nameA > nameB) return ascending ? 1 : -1
        return 0
      })

      this.setAllUsers(sortedUsers)
    },
    sortUsersByEndDate(allUsers, ascending = true) {
      const sortedUsers =  allUsers.sort((a, b) => {
        if (!a.toString().includes('-') && parseInt(a) < 11 ) {
          return 1
        }
        const dateA = new Date(a.EndDate.split('-').reverse().join('-'));
        const dateB = new Date(b.EndDate.split('-').reverse().join('-'));
        return ascending ? dateA - dateB : dateB - dateA;
      });

      this.setAllUsers(sortedUsers)
    },
    generateRandomFiveDigitString() {
      const digits = '0123456789';
      let result = '';
    
      for (let i = 0; i < 5; i++) {
        result += digits[Math.floor(Math.random() * 10)];
      }
    
      return result;
    }
  }
})
