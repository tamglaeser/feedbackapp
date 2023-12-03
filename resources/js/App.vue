<template>
    <div id="app">
        <TopBand />
        <router-view></router-view>
    </div>
</template>
<script>
import TopBand from "./components/TopBand.vue";

export default {
    components: {
        TopBand
    },
}
</script>
