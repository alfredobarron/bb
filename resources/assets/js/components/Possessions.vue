<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <span class="glyphicon glyphicon-plus text-success"></span> New
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModalPossession">
                                <i class="fa-fw fa fa-bookmark" aria-hidden="true"></i> Possession
                            </a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#myModalCategory">
                                <i class="fa-fw fa fa-folder" aria-hidden="true"></i> Category
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <br>
        <!-- List -->
        <div class="row">
            <div class="col-sm-3" v-for="(possession, index) in possessions">
                <div class="panel panel-default" v-if="possession.type == 2">
                    <div class="panel-body" @dblclick="goToCategory(possession.id)">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-folder fa-stack-1x fa-inverse"></i>
                        </span>
                        {{possession.title}}
                        <!-- <br><br>
                        <p class="text-right"><a href="#" class="btn btn-default" role="button">Edit</a></p> -->
                        <p class="text-right">
                            <a href="#" @click="goToCategory(possession.id)">
                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        </p>
                    </div>
                </div>
                <div class="panel panel-default" v-else @dblclick="goToPossession(possession.id)">
                    <swiper :options="swiperOption" v-show="possession.files">
                        <swiper-slide v-for="file in possession.files">
                            <img :src="file.urlThumb" class="img-responsive">
                        </swiper-slide>
                        <div class="swiper-pagination" slot="pagination"></div>
                    </swiper>
                    <div class="panel-body">
                        <p>{{possession.title}}</p>
                        <p class="text-right">
                            <a href="#" @click="goToPossession(possession.id)">
                                <i class="fa fa-chevron-right" aria-hidden="true"></i>
                            </a>
                        </p>
                        <!-- <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a> <a href="#" class="btn btn-default" role="button">Button</a></p> -->
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
            possessions: [],
            newPossession: {
                title: null,
                parent_id: 0,
                type: 1,
                files: []
            },
            newCategory: {
                title: null,
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
                this.possessions = response.data;
            });
        } else {
            axios.get('/possession/byUser')
            .then(response => {
                this.possessions = response.data;
            });
        }
    },

    methods: {
        createPossession: function(){
            axios.post('/possession/store', this.newPossession)
            .then(response => {
                this.possessions.push(response.data);
                this.newPossession.title = null;
                this.newPossession.files = [];
                $('#myModalPossession').modal('hide');
            });
        },
        createCategory: function(){
            axios.post('/possession/store', this.newCategory)
            .then(response => {
                this.possessions.unshift(response.data);
                this.newCategory.title = null;
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
