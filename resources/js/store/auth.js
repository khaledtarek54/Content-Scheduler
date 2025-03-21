import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("auth", {
    state: () => ({
        user: null,
        token: localStorage.getItem("token") || null,
    }),
    actions: {
        async login(credentials) {
            const response = await axios.post("/login", credentials);
            this.token = response.data.token;
            this.user = response.data.user;
            localStorage.setItem("token", this.token);
            axios.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;
        },

        async register(userData) {
            const response = await axios.post("/register", userData);
            this.token = response.data.token;
            this.user = response.data.user;
            localStorage.setItem("token", this.token);
            axios.defaults.headers.common[
                "Authorization"
            ] = `Bearer ${this.token}`;
        },

        async logout() {
            try {
                await axios.post('/logout', {}, {
                    headers: { Authorization: `Bearer ${this.token}` }
                })
            } catch (error) {
                console.error('Logout failed:', error)
            }

            this.user = null
            this.token = null
            localStorage.removeItem('token')
            delete axios.defaults.headers.common['Authorization']
        },

        async fetchUser() {
            if (!this.token) return;
            try {
                const response = await axios.get("/profile");
                this.user = response.data;
            } catch {
                this.logout();
            }
        },
    },
});
