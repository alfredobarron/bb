<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <p class="lead">
                    <a :href="'/possessions/'+possession.parent.id">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                    {{possession.parent.title}} / {{possession.title}}
                </p>
            </div>
        </div>
        <hr>
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
export default {
    props: ['possession']
}
</script>
