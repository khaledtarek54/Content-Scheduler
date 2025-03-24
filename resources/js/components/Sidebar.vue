<script setup>
import { useRouter } from "vue-router";

const router = useRouter();

const logout = () => {
    localStorage.removeItem("token");
    router.push("/login");
};
</script>

<template>
    <div class="h-screen w-64 bg-gray-800 text-white flex flex-col">
        <h2 class="text-xl font-bold p-4 border-b border-gray-700">Content Scheduler</h2>

        <nav class="flex-grow">
            <ul>

                <li>
                    <router-link to="/dashboard" class="block p-4 hover:bg-gray-700">
                        Dashboard
                    </router-link>
                </li>
                <li>
                    <router-link to="/analytics" class="block p-4 hover:bg-gray-700">
                        Analytics
                    </router-link>
                </li>
            </ul>
        </nav>
        <button @click="logout" class="bg-red-500 hover:bg-red-600 text-white p-4 w-full">
            Logout
        </button>
    </div>
</template>

<style scoped>
.router-link-active {
    background-color: #4a5568;
}
</style>
