<template>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-xl font-bold text-gray-800 pl-8">Edit Category</h1>
        <form @submit.prevent="updateCategory" class="bg-white shadow-lg rounded-lg p-8 space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input v-model="form.name" id="name" type="text" class="border rounded p-2 mt-1 w-full"
                    :class="{ 'border-red-500': errors.name }" />
                <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Update Category
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

const form = ref({
  name: ''
});

const errors = ref({});
const router = useRouter();
const route = useRoute();
const categoryId = route.params.id;

const fetchCategory = async () => {
    try {
        const response = await axios.get(`/api/categories/${categoryId}`);
        form.value.name = response.data.name;
    } catch (error) {
        console.error('Failed to fetch category:', error);
    }
};

const updateCategory = async () => {
    errors.value = {};
    try {
        const formData = new FormData();
        formData.append('name', form.value.name);
        const response = await axios.post(`/api/categories/update/${categoryId}`, formData);

        router.push('/categories');
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to update category:', error);
        }
    }
};

onMounted( async () => {
    await fetchCategory();
});
</script>
