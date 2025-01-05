import { defineStore } from "pinia";

export const useUserStore = defineStore("userStore", {
    state: () => ({
        users: [],
    }),
    getters: {
        allUsers: (state) => state.users,
    },
    actions: {
        setAllUsers(users) {
            this.users = users;
        },
        addNewUser(user) {
            this.users.push(user);
        },
    },
});
