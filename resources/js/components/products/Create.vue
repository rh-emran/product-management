<template>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-xl font-bold text-gray-800 pl-8">Add New Product</h1>
        <form @submit.prevent="submitForm" enctype="multipart/form-data"
            class="bg-white shadow-lg rounded-lg p-8 space-y-4">

            <!-- Product Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Product Title</label>
                <input type="text" id="title" v-model="form.title"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" :class="{ 'border-red-500': errors.title }">
                    <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</p>
            </div>

            <!-- Product Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                <input type="file" id="image" @change="handleImageUpload"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" :class="{ 'border-red-500': errors.image }">
                <img v-if="form.imagePreview" :src="form.imagePreview" alt="Image Preview"
                    class="mt-4 w-32 h-32 object-cover rounded-md">
                <p v-if="errors.image" class="text-red-500 text-sm">{{ errors.image }}</p>
            </div>

            <!-- Categories -->
            <div>
                <label for="categories" class="block text-sm font-medium text-gray-700">Categories</label>
                <select multiple id="categories" v-model="form.categories"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2" :class="{ 'border-red-500': errors.categories }">
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}
                    </option>
                </select>
                <p v-if="errors.categories" class="text-red-500 text-sm">{{ errors.categories }}</p>
            </div>

            <!-- Features -->
            <div>
                <label for="features" class="block text-sm font-medium text-gray-700">Features</label>
                <div v-for="(feature, index) in form.features" :key="index" class="flex items-center space-x-2 mb-4">
                    <input type="text" v-model="form.features[index]"
                        class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm p-2"
                        placeholder="Feature description">
                    <button type="button" @click="removeFeature(index)"
                        class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">Remove</button>
                </div>
                <button type="button" @click="addFeature"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Add
                    More Features</button>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">Save Product</button>
        </form>
    </div>
</template>

<script setup>
    import { ref, reactive, onMounted } from 'vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';

    const form = reactive({
        title: '',
        image: null,
        imagePreview: null,
        categories: [],
        features: ['']
    });

    const categories = ref([]);
    const errors = ref({});
    const router = useRouter();

    const fetchCategories = async () => {
        try {
            const response = await axios.get('/api/categories');
            categories.value = response.data;
        } catch (error) {
            console.error('Failed to fetch categories:', error.response.data);
        }
    };

    const handleImageUpload = (e) => {
        const file = e.target.files[0];
        form.image = file;
        form.imagePreview = URL.createObjectURL(file);
    };

    const addFeature = () => {
        form.features.push('');
    };

    const removeFeature = (index) => {
        form.features.splice(index, 1);
    };

    const submitForm = async () => {
        const formData = new FormData();
        formData.append('title', form.title);
        formData.append('image', form.image);

        form.categories.forEach(category => {
            formData.append('categories[]', category);
        });

        form.features.forEach((feature, index) => {
            formData.append(`features[${index}]`, feature);
        });

        try {
            const response = await axios.post('/api/products', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            });
            router.push('/');
        } catch (error) {
            if (error.response && error.response.status === 422) {
                errors.value = error.response.data.errors;
            } else {
                console.error('Failed to create product:', error);
            }
        }
    };

    onMounted( async () => {
        await fetchCategories();
    });
</script>
