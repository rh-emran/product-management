import { createRouter, createWebHistory } from 'vue-router';

// import CategoryManagement from '@/components/CategoryManagement.vue'; // Create this component
// import FeatureManagement from '@/components/FeatureManagement.vue'; // Create this component

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('@/components/products/Index.vue'),
    },
    {
        path: '/products',
        name: 'products.index',
        component: () => import('@/components/products/Index.vue'),
    },
    {
        path: '/products/create',
        name: 'products.create',
        component: () => import('@/components/products/Create.vue'),
    },
    {
        path: '/products/:id/edit',
        name: 'products.edit',
        component: () => import('@/components/products/Edit.vue'),
    },
    {
        path: '/categories',
        name: 'categories.index',
        component: () => import('@/components/categories/Index.vue'),
    },
    {
        path: '/categories/create',
        name: 'categories.create',
        component: () => import('@/components/categories/Create.vue'),
    },
    {
        path: '/categories/:id/edit',
        name: 'categories.edit',
        component: () => import('@/components/categories/Edit.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;
