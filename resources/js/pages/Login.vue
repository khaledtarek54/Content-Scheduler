<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

      <form @submit.prevent="validateAndLogin" class="space-y-4">
        <div>
          <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
          <input v-model="email" type="email" id="email" placeholder="Enter your email"
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2"
            :class="errors.email ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500'" />
          <p v-if="errors.email" class="text-red-500 text-sm mt-1">{{ errors.email }}</p>
        </div>

        <div>
          <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
          <input v-model="password" type="password" id="password" placeholder="Enter your password"
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2"
            :class="errors.password ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500'" />
          <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>
        </div>

        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-300">
          Login
        </button>
      </form>

      <p class="text-center text-gray-600 mt-4">
        Don't have an account?
        <router-link to="/register" class="text-blue-500 hover:underline">Sign up</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { useAuthStore } from "../store/auth";
import { useRouter } from "vue-router";
import { useToast } from "vue-toastification";
const auth = useAuthStore();
const router = useRouter();
const Toast = useToast();
const email = ref("");
const password = ref("");
const errors = ref({});

const validateAndLogin = async () => {
  errors.value = {};

  if (!email.value) {
    errors.value.email = "Email is required";
  } else if (!/\S+@\S+\.\S+/.test(email.value)) {
    errors.value.email = "Invalid email format";
  }

  if (!password.value) {
    errors.value.password = "Password is required";
  } else if (password.value.length < 8) {
    errors.value.password = "Password must be at least 8 characters";
  }

  if (Object.keys(errors.value).length === 0) {
    try {
      await auth.login({ email: email.value, password: password.value });
      router.push("/dashboard");
    } catch (error) {
      Toast.error("Invalid credentials");
    }
  }
};
</script>
