<template>
    <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-4">Add New Content</h2>

            <form @submit.prevent="submitContent" class="space-y-4">
                <div>
                    <label class="block text-gray-700">Title</label>
                    <input v-model="title" type="text"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" />
                    <p v-if="errors.title" class="text-red-500 text-sm">
                        {{ errors.title }}
                    </p>
                </div>

                <div>
                    <label class="block text-gray-700">Content</label>
                    <textarea v-model="content"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                    <p v-if="errors.content" class="text-red-500 text-sm">
                        {{ errors.content }}
                    </p>
                </div>

                <div>
                    <label class="block text-gray-700">Status</label>
                    <select v-model="status"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="draft">Draft</option>
                        <option value="scheduled">Scheduled</option>
                        <!-- <option value="published">Published</option> -->
                    </select>
                </div>
                <label class="block mt-3 mb-2 text-gray-700">Select Platforms</label>
                <vue-multiselect v-model="platform" :options="platformOptions" :multiple="false" :close-on-select="true"
                    placeholder="Select platforms" label="name" track-by="id" class="w-full"></vue-multiselect>


                <div v-if="status.trim() === 'scheduled'">
                    <label class="block text-gray-700">Scheduled Time</label>
                    <input v-model="scheduled_time" type="datetime-local"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500" />

                </div>
                <div v-if="platform && status.trim() === 'scheduled'">
                    <button type="button" @click="fetchSuggestedTime" class="bg-green-500 text-white px-3 py-2 rounded">
                        Suggest Time
                    </button>
                </div>
                <div>
                    <label class="block text-gray-700">Upload Image</label>
                    <input type="file" @change="handleImageUpload" accept="image/*"
                        class="w-full p-2 border border-gray-300 rounded-lg" />
                    <p v-if="errors.image" class="text-red-500 text-sm">
                        {{ errors.image }}
                    </p>

                    <div v-if="imagePreview" class="mt-2">
                        <img :src="imagePreview" class="h-32 w-full object-cover rounded-lg" />
                    </div>
                </div>

                <div class="flex justify-end space-x-4 mt-4">
                    <button @click="closeModal" type="button"
                        class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                        Cancel
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, defineProps, defineEmits } from "vue";
import VueMultiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.css";
import axios from "../axios";
import { useToast } from "vue-toastification";
const toast = useToast();
const props = defineProps({ isOpen: Boolean });
const emit = defineEmits(["close", "contentAdded"]);

const title = ref("");
const content = ref("");
const status = ref("draft");
const scheduled_time = ref(null);
const image = ref(null);
const imagePreview = ref(null);
const errors = ref({});
const platform = ref("");
const platformOptions = [
    { id: 1, name: "Twitter" },
    { id: 2, name: "Instagram" },
    { id: 3, name: "LinkedIn" }
];

const closeModal = () => {
    title.value = "";
    content.value = "";
    status.value = "draft";
    scheduled_time.value = "";
    image.value = null;
    imagePreview.value = null;
    platform.value = "";
    emit("close");
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        image.value = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const fetchSuggestedTime = async () => {
    const response = await axios.get(`/suggested-time/${platform.value.id}`);

    const dateObj = new Date(response.data.suggested_time);
    const formattedDate = dateObj.toISOString().slice(0, 16);
    scheduled_time.value = formattedDate;
};
const submitContent = async () => {
    errors.value = {};

    if (!title.value) errors.value.title = "Title is required";
    if (!content.value) errors.value.content = "Content is required";
    if (status.value === "scheduled" && !scheduled_time.value)
        errors.value.scheduled_time = "Scheduled time is required";
    if (image.value && !image.value.type.startsWith("image/"))
        errors.value.image = "Invalid image format";
    if (!platform.value) errors.value.platform = "Platform is required";

    if (Object.keys(errors.value).length > 0) return;

    const formData = new FormData();
    formData.append("title", title.value);
    formData.append("content", content.value);
    formData.append("status", status.value);
    formData.append("platform[]", platform.value.id);

    if (status.value === "scheduled") {
        formData.append("scheduled_time", scheduled_time.value);
    }
    if (image.value) {
        formData.append("image_url", image.value);
    }

    try {
        await axios.post("/posts", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        }).then(() => {
            toast.success("Content added successfully!");
            emit("contentAdded");

            title.value = "";
            content.value = "";
            status.value = "draft";
            scheduled_time.value = "";
            image.value = null;
            imagePreview.value = null;
            platform.value = "";
            closeModal();
        });
    } catch (error) {
        if (error.response && error.response.data.errors) {
            Object.values(error.response.data.errors).forEach((messages) => {
                messages.forEach((message) => {
                    toast.error(message);
                });
            });
        } else {
            toast.error("An unexpected error occurred!");
        }
    }

};
</script>
