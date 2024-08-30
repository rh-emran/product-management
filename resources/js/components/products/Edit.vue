<template>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-xl font-bold text-gray-800 pl-8">Edit Product</h1>
        <form @submit.prevent="updateProduct" class="bg-white shadow-lg rounded-lg p-8 space-y-4">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                <input v-model="form.title" id="title" type="text" class="border rounded p-2 mt-1 w-full"
                    :class="{ 'border-red-500': errors.title }" />
                <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title }}</p>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                <input id="image" type="file" @change="handleImageUpload" class="border rounded p-2 mt-1 w-full" />
                <img v-if="imageUrl" :src="imageUrl" alt="Image Preview" class="mt-2 w-24 h-24 object-cover" />
            </div>

            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Update Product
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter, useRoute } from 'vue-router';

const form = ref({
  title: '',
  image: null
});

const imageUrl = ref(null);
const errors = ref({});
const router = useRouter();
const route = useRoute();
const productId = route.params.id;

const fetchProduct = async () => {
    try {
        const response = await axios.get(`/api/products/${productId}`);
        form.value.title = response.data.title;

        if (response.data.image) {
            imageUrl.value = getImageUrl(response.data.image);
        }
    } catch (error) {
        console.error('Failed to fetch product:', error);
    }
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.value.image = file;
        imageUrl.value = URL.createObjectURL(file);
    }
};

const updateProduct = async () => {
    errors.value = {};
    try {
        const formData = new FormData();
        formData.append('title', form.value.title);
        if (form.value.image) {
            formData.append('image', form.value.image);
        }

        const response = await axios.post(`/api/products/update/${productId}`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        router.push('/products');
    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors;
        } else {
            console.error('Failed to update product:', error);
        }
    }
};

const getImageUrl = (imagePath) => {
    const baseUrl = window.location.origin + '/storage/';
    return `${baseUrl}${imagePath}`;
};

onMounted( async () => {
    await fetchProduct();
});
</script>
