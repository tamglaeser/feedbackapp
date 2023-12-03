<template>
    <div class="top-band d-flex justify-content-between align-items-center">
        <router-link v-if="showHomeLink" to="/" class="btn btn-link">Home</router-link>
        <router-link v-if="showRegisterLink" to="/register" class="btn btn-link">Register</router-link>
        <router-link v-if="showLogoutLink" to="/" class="btn btn-link">Logout</router-link>
        <button v-if="showDeleteAccount" type="submit" @click="deleteUser" class="btn btn-danger">Delete Account</button>
    </div>
</template>

<script>

import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

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
        showDeleteAccount() {
            return this.$route.path === '/manualimport'; // Show Delete Account possibility when logged in
        },
    },
    setup() {
        const errors = ref()
        const router = useRouter();
        const deleteUser = async () => {
            try {
                const result = await axios.delete(`/api/users/${localStorage.getItem('APP_DEMO_USER_ID')}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('APP_DEMO_USER_TOKEN')}`
                    }
                });
                if (result.status === 200) {
                    await router.push('/')
                }
            } catch (e) {
                if(e && e.response.data && e.response.data.errors) {
                    errors.value = Object.values(e.response.data.errors)
                } else {
                    errors.value = e.response.data.message || ""
                }
            }
        }

        return {
            errors,
            deleteUser,
        }
    }

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
