<template>
    <div class="flex flex-col min-h-screen m-12">
        <header class="bg-gray-100 p-5">
            <h1 class="text-2xl font-bold">Welcome to the Registration System</h1>
        </header>
        <main class="p-5">
            <router-view></router-view>
        </main>
        <footer class="bg-gray-100 p-5 text-center">
            <p>&copy; 2023 Registration System</p>
        </footer>
    </div>
</template>

<script>
export default {
    name: 'App',
};
</script>
