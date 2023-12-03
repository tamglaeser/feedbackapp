<template>
    <div class="top-band d-flex justify-content-between align-items-center">
        <router-link v-if="showHomeLink" to="/" class="btn btn-link">Home</router-link>
        <router-link v-if="showRegisterLink" to="/register" class="btn btn-link">Register</router-link>
        <router-link v-if="showLogoutLink" to="/" class="btn btn-link">Logout</router-link>
    </div>
</template>

<script>

export default {
    computed: {
        showHomeLink() {
            return this.$route.path !== '/' && this.$route.path !== '/manualimport'; // Show Home link when not on the Home page and not already logged in
        },
        showLogoutLink() {
            return this.$route.path === '/manualimport'; // Show Login link when not on the Login page
        },
        showRegisterLink() {
            return this.$route.path !== '/register' && this.$route.path !== '/manualimport'; // Show Register link when not on the Register page and not already logged in
        },
    },
};
</script>

<style scoped>
/* Styles for the top band */
.top-band {
    background-color: #f0f0f0;
    padding: 10px;
}

.top-band .btn {
    margin-left: 10px; /* Add spacing between buttons */
}
</style>
