<template>
    <footer>
        <div class="footer-inner">
            <nav-menu></nav-menu>
            <span class="copy">&copy; Anton Korolkov 2017</span>
        </div>
    </footer>
</template>
<script>
    module.exports = {
        components: {
            'nav-menu': require('./NavMenu.vue')
        }
    }
</script>