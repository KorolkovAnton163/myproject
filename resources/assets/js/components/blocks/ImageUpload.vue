<template>
    <fieldset class="image-upload">
        <img v-if="currentImage" :src="currentImage.path">
        <label for="images">
            <svg class="svg-icon">
                <use xlink:href="#icon-upload"></use>
            </svg>
            Изоброжение (формат .JPEG, .PNG)
            <input id="images" type="file" name="images" @change="upload" accept="image/jpeg,image/png">
        </label>
    </fieldset>
</template>
<script>
    module.exports = {
        data () {
            return {
                currentImage: null
            }
        },
        props: {
            image: {
                type: Object,
                default: null
            }
        },
        watch: {
            'image' (newVal, oldVal) {
                if (+newVal !== +oldVal) {
                    this.currentImage = this.image
                }
            }
        },
        methods: {
            upload (e) {
                let formData = new FormData();

                formData.append('image', e.currentTarget.files[0]);

                this.$http.post(location.origin + '/image/upload', formData).then((responce) => {
                    this.currentImage = responce.data;
                    this.$parent.$emit('imageUpload', this.currentImage);
                });
            }
        }
    }
</script>