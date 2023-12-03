<template>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h2 class="mb-4"> Login </h2>
            <form method="post" @submit.prevent="handleLogin">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" class="form-control" id="email" v-model="form.email" required/>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" v-model="form.password" required/>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                    <router-link to="/register" class="btn btn-secondary">Sign Up</router-link>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";
import axios from "axios";

export default {
    setup() {
        const errors = ref()
        const router = useRouter();
        const form = reactive({
            email: '',
            password: '',
        })
        const handleLogin = async () => {
            try {
                await axios.get('/api/users');
                const result = await axios.post('/api/auth/login', form);
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await router.push('manualimport')
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
            form,
            errors,
            handleLogin,
        }
    }
}
</script>
