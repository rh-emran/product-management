<template>
    <nav class="bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="text-white text-2xl font-bold">
                <router-link to="/" class="hover:text-gray-400">
                    <svg class="w-6 h-6 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2 7-7 7 7 2 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7z" />
                    </svg>
                    Product Management
                </router-link>
            </div>

            <div class="flex gap-6">
                <!-- Products Dropdown -->
                <div class="relative group py-2">
                    <button @click="toggleDropdown('products')"
                        class="text-white hover:text-gray-400 focus:outline-none flex items-center">
                        Products
                        <svg class="w-6 h-6 inline-block ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div v-if="productsDropdownVisible"
                        class="absolute z-50 flex flex-col right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg transition-opacity duration-300">
                        <router-link @click="hideDropdowns" to="/products"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                            All Products
                        </router-link>
                        <router-link @click="hideDropdowns" to="/products/create"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Product
                        </router-link>
                    </div>
                </div>

                <!-- Categories Dropdown -->
                <div class="relative group py-2">
                    <button @click="toggleDropdown('categories')"
                        class="text-white hover:text-gray-400 focus:outline-none flex items-center">
                        Categories
                        <svg class="w-6 h-6 inline-block ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M12.53 16.28a.75.75 0 0 1-1.06 0l-7.5-7.5a.75.75 0 0 1 1.06-1.06L12 14.69l6.97-6.97a.75.75 0 1 1 1.06 1.06l-7.5 7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div v-if="categoriesDropdownVisible"
                        class="absolute z-50 flex flex-col right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg transition-opacity duration-300">
                        <router-link @click="hideDropdowns" to="/categories"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7" />
                            </svg>
                            All Categories
                        </router-link>
                        <router-link @click="hideDropdowns" to="/categories/create"
                            class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                            <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Create Category
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const productsDropdownVisible = ref(false);
const categoriesDropdownVisible = ref(false);

function toggleDropdown(menu) {
    if (menu === 'products') {
        productsDropdownVisible.value = !productsDropdownVisible.value;
        categoriesDropdownVisible.value = false;
    } else if (menu === 'categories') {
        categoriesDropdownVisible.value = !categoriesDropdownVisible.value;
        productsDropdownVisible.value = false;
    }
}

function hideDropdowns() {
    productsDropdownVisible.value = false;
    categoriesDropdownVisible.value = false;
}

function handleClickOutside(event) {
    const dropdowns = document.querySelectorAll('.group');
    let clickedOutside = true;

    dropdowns.forEach((dropdown) => {
        if (dropdown.contains(event.target)) {
            clickedOutside = false;
        }
    });

    if (clickedOutside) {
        hideDropdowns();
    }
}

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<style scoped>
.group:hover .group-hover\:visible {
    visibility: visible;
    opacity: 1;
}

.group-hover\:visible {
    visibility: hidden;
    opacity: 0;
}
</style>
