<template>
    <div class="container mx-auto p-6 max-w-4xl">
        <h1 class="text-xl font-bold text-gray-800 mb-4">All Categories</h1>
        <div class="flex justify-between mb-4">
            <input v-model="search" type="text" placeholder="Search categories..." class="border rounded p-2" />
            <router-link to="/categories/create" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Add Category
            </router-link>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        name
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="category in filteredCategories" :key="category.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ category.id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ category.name }} ({{ category.products_count }})
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <router-link :to="`/categories/${category.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
                            Edit
                        </router-link>
                        <button @click="deleteCategories(category.id)" class="text-red-600 hover:text-red-900 ml-4">
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="categories.length === 0" class="mt-4 text-center text-gray-500">
            No category found.
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const categories = ref([]);
const search = ref('');

const fetchCategories = async () => {
    try {
        const response = await axios.get('/api/categories');
        categories.value = response.data;
    } catch (error) {
        console.error('Failed to fetch products:', error);
    }
};

const deleteCategories = async (id) => {
    if (confirm('Are you sure you want to delete this category?')) {
        try {
            await axios.delete(`/api/categories/${id}`);
            categories.value = categories.value.filter(category => category.id !== id);
        } catch (error) {
            console.error('Failed to delete category:', error);
        }
    }
};

const filteredCategories = computed(() => {
    return categories.value.filter(category => {
        return category.name.toLowerCase().includes(search.value.toLowerCase());
    });
});

onMounted(() => {
    fetchCategories();
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
