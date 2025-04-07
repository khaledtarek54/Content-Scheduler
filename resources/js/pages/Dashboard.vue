

<template>
  <div class="flex flex-col min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-800">Dashboard!!</h1>

    </nav>

    <div class="container mx-auto p-6">
      <!-- Action Buttons -->
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-semibold text-gray-700">Your Posts</h2>
        <button @click="isModalOpen = true"
          class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
          + Add Content
        </button>
      </div>

      <!-- Filters -->
      <div class="flex space-x-4 mb-4">
        <input type="date" v-model="filters.date" class="border p-2 rounded w-1/3 focus:ring-2 focus:ring-blue-400">
        <select v-model="filters.status" class="border p-2 rounded w-1/3 focus:ring-2 focus:ring-blue-400">
          <option value="">All</option>
          <option value="scheduled">Scheduled</option>
          <option value="published">Published</option>
        </select>
        <button @click="fetchPosts"
          class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">Filter</button>
      </div>

      <!-- Posts Table -->
      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="w-full border-collapse border">
          <thead>
            <tr class="bg-gray-100">
              <th class="border p-3 text-center">Title</th>
              <th class="border p-3 text-center">Status</th>
              <th class="border p-2 text-center">Platform</th>
              <th class="border p-3 text-center">Scheduled Time</th>
              <th class="border p-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="post in posts" :key="post.id" class="hover:bg-gray-50">
              <td class="border p-3 text-center">{{ post.title }}</td>
              <td class="border p-3 text-center">
                <span class="px-2 py-1 rounded text-white text-sm"
                  :class="post.status === 'scheduled' ? 'bg-yellow-500' : 'bg-green-500'">
                  {{ post.status }}
                </span>
              </td>
              <td class="border p-2 text-center">
                <span v-for="platform in post.platforms" :key="platform.id"
                  class="px-2 py-1 bg-gray-200 text-gray-700 rounded mr-1 inline-block">
                  {{ platform.name }}
                </span>
              </td>
              <td class="border p-3 text-center">{{ post.scheduled_time }}</td>
              <td class="border p-3 text-center">
                <!-- <button class="text-blue-500 hover:underline mr-2" @click="editPost(post)">Edit</button> -->
                <button class="text-red-500 hover:underline" @click="deletePost(post.id)">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <AddContentModal :isOpen="isModalOpen" @close="isModalOpen = false" @contentAdded="fetchPosts" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../store/auth'
import axios from '../axios'
import AddContentModal from '@/components/AddContentModal.vue'
import { useToast } from "vue-toastification";
import ConfirmToast from "@/components/ConfirmToast.vue";

const toast = useToast();
const router = useRouter()
const auth = useAuthStore()
const posts = ref([])
const filters = ref({ status: '', date: '' })
const isModalOpen = ref(false)

const fetchPosts = async () => {
  try {
    const response = await axios.get('/posts', { params: filters.value })
    posts.value = response.data
  } catch (error) {
    console.error('Error fetching posts:', error)
  }
}

const logout = async () => {
  await auth.logout()
  router.push('/login')
}

const deletePost = (postId) => {
  toast.info({
    component: ConfirmToast,
    props: {
      message: "Are you sure you want to delete this post?",
      onConfirm: async () => {
        await axios.delete(`/posts/${postId}`);
        toast.success("Post deleted successfully!");
        fetchPosts();
      },
    },
  });
}

onMounted(fetchPosts)
</script>
