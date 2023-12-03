<template>
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
        <div>
            <p>Welcome to the Feedback App.<br>Would you like to submit a feedback by filling out a form or <br>manually import feedback data from a JSON or CSV file?</p>
            <router-link to="/review" tag="button" class="btn btn-primary mr-2">Submit feedback</router-link>
            <router-link to="/login" tag="button" class="btn btn-primary">Manually import feedback</router-link>
        </div>
    </div>
</template>
<style scoped>
a {
    padding: 5px;
    margin: 10px;
}
</style>
<script setup>
</script>
