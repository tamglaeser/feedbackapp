<template>
    <router-link to="/review">Submit feedback</router-link>
    <router-link to="/login">Manually import feedback</router-link>
    <span>
        <router-view></router-view>
    </span>
</template>
<script>
export default {
    setup() {

    }
}
</script>
<style scoped>
a {
    display: inline-block;
    background-color: #1523ce;
    border: solid 1px #1523ce;
    color: white;
    padding: 5px;
    margin: 10px;
}
a:hover,
a.router-link-active {
    background-color: rgb(63, 77, 248);
}
div {
    border: dashed black 1px;
    padding: 20px;
    margin: 10px;
    display: inline-block;
}
</style>
