<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
      <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Register</h2>

      <form @submit.prevent="validateAndRegister" class="space-y-4">
        <div>
          <label for="name" class="block text-gray-700 font-medium mb-1">Name</label>
          <input v-model="name" type="text" id="name" placeholder="Enter your name"
            class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2"
            :class="errors.name ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500'" />
          <p v-if="errors.name" class="text-red-500 text-sm mt-1">{{ errors.name }}</p>
        </div>

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

        <div>
          <label for="password_confirmation" class="block text-gray-700 font-medium mb-1">Confirm Password</label>
          <input v-model="password_confirmation" type="password" id="password_confirmation"
            placeholder="Confirm your password" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2"
            :class="errors.password_confirmation ? 'border-red-500 focus:ring-red-500' : 'border-gray-300 focus:ring-blue-500'" />
          <p v-if="errors.password_confirmation" class="text-red-500 text-sm mt-1">{{ errors.password_confirmation }}
          </p>
        </div>

        <button type="submit"
          class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-300">
          Register
        </button>
      </form>

      <p class="text-center text-gray-600 mt-4">
        Already have an account?
        <router-link to="/login" class="text-blue-500 hover:underline">Login</router-link>
      </p>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../store/auth'
import { useRouter } from 'vue-router'
import { useToast } from "vue-toastification";

const auth = useAuthStore()
const router = useRouter()
const Toast = useToast();
const name = ref('')
const email = ref('')
const password = ref('')
const password_confirmation = ref('')
const errors = ref({})

const validateAndRegister = async () => {
  errors.value = {}

  if (!name.value) {
    errors.value.name = "Name is required";
  }

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

  if (!password_confirmation.value) {
    errors.value.password_confirmation = "Please confirm your password";
  } else if (password.value !== password_confirmation.value) {
    errors.value.password_confirmation = "Passwords do not match";
  }

  if (Object.keys(errors.value).length === 0) {
    try {
      await auth.register({
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value
      });
      Toast.success("Registration successful!");
      router.push("/dashboard");
    } catch (error) {
      if (error.response && error.response.data.errors) {
        Object.values(error.response.data.errors).forEach((messages) => {
          messages.forEach((message) => {
            Toast.error(message);
          });
        });
      } else {
        Toast.error("Registration failed. Please try again.");
      }
    }
  }
};
</script>
