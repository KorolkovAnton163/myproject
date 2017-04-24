<template>
    <div class="message-box" :class="{'success': success, 'fail': fail}">
        {{ message }}
    </div>
</template>
<script>
    module.exports = {
        data () {
            return {
                success: false,
                fail: false,
                message: null
            }
        },
        mounted () {
            this.$root.$on('success', (message) => {
                this.message = message;
                this.success = true;
                this.toggleBox();
            });
            this.$root.$on('fail', (responce) => {
                if (responce.status == 500) {
                    this.message = 'System error.';
                } else {
                    for(let i in responce.data) {
                        this.message = responce.data[i][0];
                    }
                }
                this.fail = true;
                this.toggleBox();
            });
        },
        methods: {
            toggleBox () {
                setTimeout(() => {
                    this.success = false;
                    this.fail = false;
                }, 3000);
            }
        },
        destroyed () {
            this.$root.$off('success');
            this.$root.$off('fail');
        }
    }
</script>