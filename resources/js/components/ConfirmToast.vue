<template>
    <div class="flex items-center gap-4">
        <span>{{ message }}</span>
        <button @click="confirm" class="px-3 py-1 bg-red-500 text-white rounded">
            Yes
        </button>
        <button @click="closeToast" class="px-3 py-1 bg-gray-400 text-white rounded">
            No
        </button>
    </div>
</template>

<script setup>
import { useToast } from "vue-toastification";

const toast = useToast();
const props = defineProps(["message", "onConfirm"]);

const confirm = () => {
    if (props.onConfirm) {
        props.onConfirm();
    }
    toast.clear();
};

const closeToast = () => {
    toast.clear();
};
</script>
