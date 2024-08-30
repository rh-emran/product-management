<template>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-xl font-bold text-gray-800 pl-8">Add New Category</h1>
        <form @submit.prevent="submitForm"
            class="bg-white shadow-lg rounded-lg p-8 space-y-4">

            <!-- Category Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
                <input type="text" id="name" v-model="form.name"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" :class="{ 'border-red-500': errors.name }">
                    <p v-if="errors.name" class="text-red-500 text-sm">{{ errors.name }}</p>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save Category</button>
        </form>
    </div>
</template>

<script setup>
    import { ref, reactive, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';

    const form = reactive({
        name: ''
    });

    const errors = ref({});
    const router = useRouter();

    const submitForm = async () => {
        const formData = new FormData();
        formData.append('name', form.name);

        try {
            const response = await axios.post('/api/categories', formData);
            router.push('/categories');
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error('Failed to create category:', error);
            }
        }
    };
</script>
