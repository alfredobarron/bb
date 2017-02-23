<template>
    <div class="container">
        <!-- Create collapse -->
        <div class="collapse possession-create" id="collapse">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-lg" placeholder="Car, House, Account..." v-model="form.title">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="3" placeholder="This possesions is..." v-model="form.description"></textarea>
                                    </div>
                                </div>
                                <!-- Tags -->
                                <div class="col-md-6 tags">
                                    <a href="#" class="btn btn-link btn-sm">
                                        <i class="fa fa-lg fa-fw fa-tag" aria-hidden="true"></i> Tag
                                    </a>
                                    <a href="#" class="btn btn-link btn-sm">
                                        <i class="fa fa-lg fa-fw fa-paperclip" aria-hidden="true"></i> Attach
                                    </a>
                                </div>
                                <!-- Shared -->
                                <div class="col-md-6 shared text-right">
                                    <a href="#" class="btn btn-link btn-sm">
                                        <i class="fa fa-lg fa-fw fa-share-alt" aria-hidden="true"></i> Share
                                    </a>
                                    <button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#collapse">Cancel</button>
                                    <button type="button" class="btn btn-sm btn-success" v-on:click="createItem">Create</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- List -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <ul class="list-unstyled possessions">
                            <li v-for="(item, index) in possessions">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>{{item.title}}</h4>
                                        <p><small>{{item.description}}</small></p>
                                    </div>
                                    <!-- Tags -->
                                    <div class="col-md-8 tags">
                                        <!-- Favorite -->
                                        <a href="" v-on:click="comingSoon">
                                            <i class="fa fa-star-o fa-lg" aria-hidden="true"></i>
                                        </a>
                                        <a href="" class="btn btn-link" v-on:click="comingSoon">
                                            <i class="fa fa-paperclip fa-fw" aria-hidden="true"></i>
                                            <small>Attach</small>
                                        </a>
                                        <!-- List Tags -->
                                        <!-- <i class="fa fa-lg fa-fw fa-tag text-muted" aria-hidden="true"></i> -->
                                        <span class="label label-info" v-for="tag in item.tags">{{tag.title}}</span>

                                        <span class="form-inline" v-bind:class="{'show-new-tag':showNewTag}">
                                            <button class="btn btn-default btn-xs" v-on:click="showNewTag=true">
                                                <i class="fa fa-tag fa-fw"></i> Add Tag
                                            </button>
                                            <div class="form-group">
                                                <input type="text" class="form-control input-sm" placeholder="Bank, Account..." v-model="newTag.title" v-on:keyup.enter="addTag(item)">
                                            </div>
                                        </span>
                                    </div>
                                    <!-- Shared -->
                                    <div class="col-md-4 shared">
                                        <ul class="list-inline shared text-right">
                                            <li>
                                                <!-- <i class="fa fa-fw fa-share-alt" aria-hidden="true"></i> -->
                                                <small>Share</small>
                                            </li>
                                            <!-- List Users shared -->
                                            <li v-for="(share, index) in item.share" v-if="index<3">
                                                <img :src="share.avatar" alt="">
                                            </li>
                                            <!-- Count Users-->
                                            <li v-if="item.share.length>3">
                                                <a href="#" class="btn btn-default btn-round border-dashed">
                                                    +{{item.share.length - 3}}
                                                </a>
                                            </li>
                                            <!-- Add user -->
                                            <li>
                                                <a href="#" class="btn btn-default btn-round" v-on:click="comingSoon">
                                                    <i class="fa fa-plus"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Attach-->
                                <div class="row attach">
                                    <!-- List Attached Files -->
                                    <div class="col-md-10">
                                        <ul class="list-inline">
                                            <li><img src="http://lorempixel.com/48/48/business/1" alt=""></li>
                                            <li><img src="http://lorempixel.com/48/48/business/2" alt=""></li>
                                            <li><img src="http://lorempixel.com/48/48/business/3" alt=""></li>
                                            <li><img src="http://lorempixel.com/48/48/business/4" alt=""></li>
                                        </ul>
                                    </div>
                                    <!-- Date & Delete button -->
                                    <div class="col-md-2 text-right">
                                        <p class="text-muted"><small>{{item.created_at | ago}}</small></p>
                                        <button type="button" class="close" aria-label="Close" v-on:click="deleteItem(item.id, index)">
                                            <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import moment from 'moment';
import swal from 'sweetalert';

export default {
    data() {
        return {
            possessions: [],
            form: {
                title: '',
                description: ''
            },
            newTag: {
                title: ''
            },
            showNewTag: false
        }
    },

    mounted() {
        axios.get('/possession/byUser').then(response => {
            this.possessions = response.data;
        });
    },

    filters: {
        ago(date) {
            return moment(date).fromNow();
        }
    },

    methods: {
        createItem: function () {
            axios.post('/possession', this.form).then(response => {
                this.possessions.unshift(response.data);
                this.form = {
                    title: '',
                    description: ''
                };
                $('#collapse').collapse('hide');
            });
        },
        deleteItem: function (id, index) {
            var self = this;
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this possession!",
                type: "warning",
                showLoaderOnConfirm: true,
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                axios.delete('/possession/' + id).then(response => {
                    self.possessions.splice(index, 1);
                    swal({
                        title: "Deleted!",
                        text: "Your possession has been deleted.",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                });
            });

        },
        comingSoon: function () {
            swal('Coming soon...');
        },
        addTag: function (possession) {
            axios.post('/possession/add_tag/' + possession.id, this.newTag).then(response => {
                possession.tags.push(response.data);
                this.newTag = {
                    title: ''
                };
                this.showNewTag = false;
            });
        }
    }

}

</script>

<style lang="scss">

.possession-create.collapsing {
    -webkit-transition: none;
    transition: none;
}

ul.possessions {
    li {
        .close {
            opacity: 0;
            filter: alpha(opacity=0);
        }
        &:hover .close {
            opacity: 0.3;
            filter: alpha(opacity=30);
        }
        .btn-round {
            border-radius: 50%;
        }
        .border-dashed {
            border-style: dashed;
        }
    }
    h4 {
        margin-bottom: 4px;
    }
    .tags {
        .label {
            font-size: 13px;
            margin-right: 3px;
            font-weight: normal;
        }
    }
    .form-inline {
        input {
            display: none;
        }
        &.show-new-tag {
            input {
                display: block;
            }
            button {
                display: none
            }
        }
    }
    .shared {
        li {
            padding-left: 1px;
            padding-right: 1px;
            img {
                border-radius: 50%;
                height: 35px;
                width: 35px;
            }
        }
    }
    .attach {
        margin-top:10px;
        margin-bottom: 20px;
        li {
            padding-left: 1px;
            padding-right: 1px;
            img {
                height: 45px;
                width: 45px;
            }
        }
    }

}

</style>
