<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="lead" v-if="parent.title"><a href="/possessions"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> {{parent.title}}</p>
            </div>
            <div class="col-md-6 text-right">
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModalPossession">
                    <span class="glyphicon glyphicon-plus text-success"></span> Possession
                </a>
                <a href="#" class="btn btn-default" data-toggle="modal" data-target="#myModalCategory">
                    <i class="fa-fw fa fa-folder" aria-hidden="true"></i> New category
                </a>
            </div>
        </div>
        <hr>
        <!-- List -->
        <div class="row">
            <div class="col-sm-3" v-for="(possession, index) in possessions">
                <div class="panel panel-default" v-if="possession.type == 2" @click="goToCategory(possession.id)">
                    <div class="panel-body">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-folder fa-stack-1x fa-inverse"></i>
                        </span>
                        {{possession.title}}
                    </div>
                </div>
                <div class="panel panel-default" v-else @click="goToPossession(possession.id)">
                    <swiper :options="swiperOption" v-show="possession.files">
                        <swiper-slide v-for="file in possession.files">
                            <img :src="file.urlThumb" class="img-responsive">
                        </swiper-slide>
                        <div class="swiper-pagination" slot="pagination"></div>
                    </swiper>
                    <div class="panel-body">
                        <p>{{possession.title}}</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Possession -->
        <div class="modal fade" id="myModalPossession">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">New Possession</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Car" v-model="newPossession.title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Description" v-model="newPossession.description"></textarea>
                        </div>
                        <dropzone id="myVueDropzone" :use-font-awesome=true
                            :use-custom-dropzone-options=true :dropzoneOptions="dzOptions"
                            url="/possession/file/upload/temp" v-on:vdropzone-success="showSuccess">
                        </dropzone>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="createPossession">Create</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Category -->
        <div class="modal fade" id="myModalCategory">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">New Category</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Cars" v-model="newCategory.title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Description" v-model="newCategory.description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="createCategory">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import moment from 'moment';
import swal from 'sweetalert';
import Dropzone from 'vue2-dropzone';
import { swiper, swiperSlide } from 'vue-awesome-swiper';

export default {
    data() {
        return {
            parent: {},
            possessions: [],
            newPossession: {
                title: null,
                description: null,
                parent_id: 0,
                type: 1,
                files: []
            },
            newCategory: {
                title: null,
                description: null,
                parent_id: 0,
                type: 2
            },
            dzOptions: {
                acceptedFiles: '.jpg,.jpeg,.png,.pdf',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken}
            },
            swiperOption: {
                pagination : '.swiper-pagination',
                paginationClickable :true
            }
        }
    },

    components: {
        Dropzone,
        swiper,
        swiperSlide
    },

    filters: {
        ago(date) {
            return moment(date).fromNow();
        }
    },

    mounted() {
        var str = window.location.pathname;
        var res = str.split("/");

        if (res.length == 3) {
            var currentCategoryId = parseInt(res[2]);

            this.newPossession.parent_id = currentCategoryId;
            this.newCategory.parent_id = currentCategoryId;

            axios.get('/possession/byUser/' + currentCategoryId)
            .then(response => {
                this.possessions = response.data.possessions;
                this.parent = response.data.parent;
            });
        } else {
            axios.get('/possession/byUser')
            .then(response => {
                this.possessions = response.data.possessions;
            });
        }
    },

    methods: {
        createPossession: function(){
            axios.post('/possession/store', this.newPossession)
            .then(response => {
                this.possessions.push(response.data);
                this.newPossession.title = null;
                this.newPossession.description = null;
                this.newPossession.files = [];
                $('#myModalPossession').modal('hide');
            });
        },
        createCategory: function(){
            axios.post('/possession/store', this.newCategory)
            .then(response => {
                this.possessions.unshift(response.data);
                this.newCategory.title = null;
                this.newCategory.description = null;
                $('#myModalCategory').modal('hide');
            });
        },
        goToCategory: function(id){
            location.href = '/possessions/' + id;
        },
        goToPossession: function(possessionId){
            location.href = '/possession/' + possessionId;
        },
        showSuccess: function(file, response){
            this.newPossession.files.push(response);
        }
    }
}

</script>

<style lang="scss">


</style>
