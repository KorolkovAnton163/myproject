<template>
    <div class="page-not-found">
        <cat></cat>
        <p>404 Страница не найдена :(</p>
    </div>
</template>
<script>
    module.exports = {
        components: {
            cat: require('../blocks/Cat.vue'),
        }
    }
</script>