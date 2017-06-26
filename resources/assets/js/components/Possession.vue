<template>
    <div class="container">
        <h1>{{possession.title}}</h1>
        <div class="row">
            <div class="col-sm-3" v-show="possession.files" v-for="file in possession.files">
                <a :href="file.url" class="thumbnail">
                    <img :src="file.urlThumb">
                </a>
            </div>
        </div>
    </div>
</template>

<script>

import LightGallery from 'lightgallery'

export default {
    props: ['possession'],
    components: {
        LightGallery
    },
    mounted() {
        $("#lightgallery").lightGallery();
    }
}

</script>

<style lang="scss">


</style>
