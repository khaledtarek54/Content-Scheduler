<script setup>
import { useRoute } from "vue-router";
import Sidebar from "./components/Sidebar.vue";

const route = useRoute();
const hideSidebarRoutes = ["/login", "/register"];
</script>

<template>
  <div class="flex">
    <Sidebar v-if="!hideSidebarRoutes.includes(route.path)" />
    <div class="flex-1 p-6">
      <router-view />
    </div>
  </div>
</template>
