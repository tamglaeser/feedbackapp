<template>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <h2 class="mb-4"> Create Account </h2>
            <form method="post" @submit.prevent="handleRegister">
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" v-model="form.name" required/>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" class="form-control" id="email" v-model="form.email" required/>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" class="form-control" id="password" v-model="form.password" required/>
                </div>
                <div class="mb-3">
                    <label for="role" class="form-label">Role:</label>
                    <select class="form-control" id="role" v-model="form.role" required>
                        <option disabled value="">Please select one</option>
                        <option>admin</option>
                        <option>user</option>
                    </select>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Register</button>
                    <router-link to="/login" class="btn btn-secondary">Login</router-link>
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
            name: '',
            email: '',
            password: '',
            role: '',
        })
        const handleRegister = async () => {
            try {
                const result = await axios.post('/api/auth/register', form)
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
            form,
            errors,
            handleRegister,
        }
    }
}
</script>

