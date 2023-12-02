<template>
    <div>
        <h1> Create Account </h1>
        <form method="post" @submit.prevent="handleRegister">
            <div class="form-group">
                <p>Name:</p>
                <input type="text" v-model="form.name" required/>
            </div>
            <div class="form-group">
                <p>Email Address:</p>
                <input type="text" v-model="form.email" required/>
            </div>
            <div class="form-group">
                <p>Password:</p>
                <input type="password" v-model="form.password" required/>
            </div>
            <div class="form-group">
                <p>Role:</p>
                <select v-model="form.role" required>
                    <option disabled value="">Please select one</option>
                    <option>admin</option>
                    <option>user</option>
                </select>
            </div>
            <div>
                <button type="submit">Register</button>
                <router-link to="/login">Login</router-link>
            </div>
        </form>
    </div>
</template>
<script>
import {reactive, ref} from "vue";
import {useRouter} from "vue-router";

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
                if (result.status === 200 && result.data && result.data.token) {
                    localStorage.setItem('APP_DEMO_USER_TOKEN', result.data.token)
                    await router.push('home')
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

