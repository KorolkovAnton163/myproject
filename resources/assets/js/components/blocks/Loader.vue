<template>
    <div class="loader animated" v-if="loading"></div>
</template>
<script>
    module.exports = {
       props: {
           loading: {
               type: Boolean
           }
       }
    }
</script>