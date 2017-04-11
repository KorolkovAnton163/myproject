<template>
    <div class="page-not-found">
        <cat></cat>
        <p>404 Page not found :(</p>
    </div>
</template>
<script>
    module.exports = {
        components: {
            cat: require('../blocks/Cat.vue'),
        }
    }
</script>