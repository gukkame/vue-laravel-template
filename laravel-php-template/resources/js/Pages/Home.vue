<template>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Home Page</h2>
        <router-link to="/test" class="text-blue-500 hover:underline"
            >Take me to Test page</router-link
        >
        <br />
        <button
            @click.prevent="tiggerEndpoint"
            class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-700"
        >
            GET: Greeting
        </button>
        <br />
        <button
            @click.prevent="tiggerEndpointApi"
            class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700"
        >
            GET: Greeting API
        </button>
        <br />
        <button
            @click.prevent="saveUserAPI"
            class="mt-4 px-4 py-2 bg-yellow-500 text-white rounded hover:bg-red-700"
        >
            POST: Save User API
        </button>
        <br />
        <button
            @click.prevent="getAllUsers"
            class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-700"
        >
            GET: Get All Users from DB
        </button>
        <br />
        <p v-if="response" class="mt-4 p-4 bg-gray-100 rounded">
            {{ response.data }}
        </p>
        <p v-if="users" class="mt-4 p-4 bg-gray-100 rounded">
            Users: {{ users }}
        </p>
    </div>
</template>

<script>
import axios from "axios";
import { useUserStore } from "@/stores/dataStore";
import { mapState } from "pinia";

export default {
    data() {
        return {
            response: null,
        };
    },
    mounted() {
        this.userStore = useUserStore();
    },
    computed: {
        ...mapState(useUserStore, ["users"]),
    },
    methods: {
        async tiggerEndpoint() {
            axios
                .get("/greeting")
                .then((res) => {
                    console.log(res);
                    this.response = res;
                })
                .catch((error) => {
                    console.error("Error at fetching all users: " + error);
                });
        },
        async tiggerEndpointApi() {
            axios
                .get("/api/greeting")
                .then((res) => {
                    console.log(res);
                    this.response = res;
                })
                .catch((error) => {
                    console.error("Error at fetching all users: " + error);
                });
        },
        async saveUserAPI() {
            axios
                .post("/api/saveUser", {
                    name: "John Doe",
                })
                .then((res) => {
                    console.log(res);
                    this.response = res;
                })
                .catch((error) => {
                    console.error("Error at fetching all users: " + error);
                });
        },
        async getAllUsers() {
            axios
                .get("/api/getAllUsers")
                .then((res) => {
                    console.log(res);
                    this.response = res;
                })
                .catch((error) => {
                    console.error("Error at fetching all users: " + error);
                });
        },
    },
};
</script>
