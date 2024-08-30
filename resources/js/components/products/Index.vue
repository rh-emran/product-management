<template>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-xl font-bold text-gray-800 mb-4">All Products</h1>
        <div class="flex justify-between mb-4">
            <input v-model="search" type="text" placeholder="Search products..." class="border rounded p-2" />
            <router-link to="/products/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Product
            </router-link>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Image
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Categories
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Features
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="product in filteredProducts" :key="product.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ product.id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ product.title }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <img :src="getImageUrl(product.image)" alt="Product Image" class="w-24 h-24 object-cover" />
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <ul>
                            <li v-for="category in product.categories" :key="category.id">
                                {{ category.name }}
                            </li>
                        </ul>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <ul>
                            <li v-for="feature in product.features" :key="feature.id">
                                {{ feature.description }}
                            </li>
                        </ul>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <router-link :to="`/products/${product.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </router-link>
                        <button @click="deleteProduct(product.id)" class="text-red-600 hover:text-red-900 ml-4">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="products.length === 0" class="mt-4 text-center text-gray-500">
            No products found.
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const products = ref([]);
const search = ref('');

const fetchProducts = async () => {
    try {
        const response = await axios.get('/api/products');
        products.value = response.data;
    } catch (error) {
        console.error('Failed to fetch products:', error);
    }
};

const deleteProduct = async (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        try {
            await axios.delete(`/api/products/${id}`);
            products.value = products.value.filter(product => product.id !== id);
        } catch (error) {
            console.error('Failed to delete product:', error);
        }
    }
};

const filteredProducts = computed(() => {
    return products.value.filter(product => {
        return product.title.toLowerCase().includes(search.value.toLowerCase());
    });
});

const getImageUrl = (imagePath) => {
    const baseUrl = window.location.origin + '/storage/';
    return `${baseUrl}${imagePath}`;
};

onMounted(() => {
    fetchProducts();
});
</script>

<style scoped>
table {
    border-collapse: collapse;
    width: 100%;
}

th,
td {
    border: 1px solid #e5e7eb;
}

th {
    background-color: #f9fafb;
}

img {
    border-radius: 0.5rem;
}
</style>
