<template>
    <div class="p-6 bg-white rounded-lg shadow">
      <h2 class="text-2xl font-bold mb-4">Post Analytics</h2>
  
      <div class="grid grid-cols-2 gap-4">
        <div class="bg-gray-100 p-4 rounded-lg">
          <h3 class="text-lg font-semibold">Scheduled Posts</h3>
          <p class="text-xl font-bold">{{ analytics.total_scheduled }}</p>
        </div>
  
        <div class="bg-gray-100 p-4 rounded-lg">
          <h3 class="text-lg font-semibold">Published Posts</h3>
          <p class="text-xl font-bold">{{ analytics.total_published }}</p>
        </div>
      </div>
  
      <div class="mt-4">
        <h3 class="text-lg font-semibold">Publishing Success Rate</h3>
        <p class="text-2xl font-bold">{{ analytics.success_rate }}%</p>
      </div>
  
      <div class="mt-4">
        <h3 class="text-lg font-semibold">Posts Per Platform</h3>
        <ul class="list-disc ml-5">
          <li v-for="(count, platform) in analytics.posts_per_platform" :key="platform">
            {{ platform }}: {{ count }}
          </li>
        </ul>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from "vue";
  import axios from "../axios";
  
  const analytics = ref({
    total_scheduled: 0,
    total_published: 0,
    success_rate: 0,
    posts_per_platform: {},
  });
  
  const fetchAnalytics = async () => {
    try {
      const response = await axios.get("/analytics");
      analytics.value = response.data;
    } catch (error) {
      console.error("Failed to load analytics", error);
    }
  };
  
  onMounted(fetchAnalytics);
  </script>
  