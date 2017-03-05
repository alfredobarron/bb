<template>
    <div class="container">
        <!-- Create collapse -->
        <div class="collapse possession-create" id="collapse">
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
                            <!-- Favorite Button -->
                            <a href="" class="text-warning" @click.prevent="form.favorite = !form.favorite">
                                <i class="fa fa-star fa-lg" aria-hidden="true" v-if="form.favorite"></i>
                                <i class="fa fa-star-o fa-lg" aria-hidden="true" v-else></i>
                            </a>
                            <!-- Attach Button -->
                            <a href="" class="btn btn-link" @click.prevent="comingSoon">
                                <i class="fa fa-paperclip fa-fw" aria-hidden="true"></i>
                                Attach
                            </a>
                            <!-- AddTag Button -->
                            <button class="btn btn-default btn-xs"
                                    @click="comingSoon">
                                <i class="fa fa-tag fa-fw"></i> Add Tag
                            </button>
                        </div>
                        <!-- Shared -->
                        <div class="col-md-6 shared text-right">
                            <a href="" class="btn btn-link" @click.prevent="comingSoon">
                                <i class="fa fa-share-alt fa-fw" aria-hidden="true"></i> Share
                            </a>
                            <button type="button" class="btn btn-sm btn-default" data-toggle="collapse" data-target="#collapse">Cancel</button>
                            <button type="button" class="btn btn-sm btn-success" @click="createItem">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- List -->
        <div class="panel panel-default possessions">
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li v-for="(item, index) in possessions">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>{{item.title}}</h4>
                                <p><small>{{item.description}}</small></p>
                            </div>
                            <!-- Attach List -->
                            <div class="col-md-10 attach">
                                <ul class="list-inline">
                                    <li><img src="http://lorempixel.com/48/48/business/1" alt=""></li>
                                    <li><img src="http://lorempixel.com/48/48/business/2" alt=""></li>
                                    <li><img src="http://lorempixel.com/48/48/business/3" alt=""></li>
                                    <li><img src="http://lorempixel.com/48/48/business/4" alt=""></li>
                                </ul>
                            </div>
                            <!-- Date -->
                            <div class="col-md-2 text-right">
                                <p class="text-muted"><small>{{item.created_at | ago}}</small></p>
                            </div>
                            <!-- Favorite, Attach button, Delete & Tags -->
                            <div class="col-md-8 tags">
                                <!-- Favorite Button -->
                                <a href="" class="text-warning" @click.prevent="toogleFavorite(item)">
                                    <i class="fa fa-star fa-lg" aria-hidden="true" v-if="item.favorite"></i>
                                    <i class="fa fa-star-o fa-lg" aria-hidden="true" v-else></i>
                                </a>
                                <!-- Attach Button -->
                                <a href="" class="btn btn-link" @click.prevent="comingSoon">
                                    <i class="fa fa-paperclip fa-fw" aria-hidden="true"></i>
                                    Attach
                                </a>
                                <!-- Delete Button -->
                                <a href="" class="btn btn-link" @click.prevent="deleteItem(item.id, index)">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    Delete
                                </a>
                                <!-- AddTag Button -->
                                <button class="btn btn-default btn-xs"
                                        v-show="newTag.options.show != item"
                                        @click="addTag(item)">
                                    <i class="fa fa-tag fa-fw"></i> Add Tag
                                </button>
                                <!-- AddTag Input -->
                                <span class="form-inline">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" placeholder="Bank, Account..."
                                               v-model="newTag.data.title"
                                               v-show="newTag.options.show == item"
                                               v-focus="newTag.options.show == item"
                                               @keyup.esc="cancelAddTag"
                                               @blur="cancelAddTag"
                                               @keyup.enter="addTag(item)">
                                    </div>
                                </span>
                                <!-- List Tags -->
                                <!-- <i class="fa fa-tag fa-lg text-muted" aria-hidden="true"></i> -->
                                <span class="label label-primary" v-for="(tag, index) in item.tags">
                                    {{tag.title}}
                                    <a href="" @click.prevent="removeTag(item, tag.id, index)">
                                        <span class="fa-stack fa-stack-sm">
                                          <i class="fa fa-circle fa-stack-2x"></i>
                                          <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                </span>
                            </div>
                            <!-- Shared -->
                            <div class="col-md-4 shared">
                                <ul class="list-inline shared text-right">
                                    <li v-if="item.share.length==0">
                                        <i class="fa fa-share-alt fa-fw" aria-hidden="true"></i>
                                        <small>Share</small>
                                    </li>
                                    <!-- List Users shared -->
                                    <li v-for="(share, index) in item.share" v-if="index<3">
                                        <div class="thumb">
                                            <img :src="share.avatar" alt="">
                                            <a href="" @click.prevent="removeShare(item, share.id, index)">
                                                <span class="fa-stack fa-stack-sm">
                                                  <i class="fa fa-circle fa-stack-2x"></i>
                                                  <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>
                                            <div class="panel panel-default popover2">
                                                <div class="panel-body">
                                                    <strong>{{share.name}}</strong><br>
                                                    <small>{{share.email}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- </popover> -->
                                    </li>
                                    <!-- Count Users-->
                                    <li v-if="item.share.length>3">
                                        <a href="" class="btn btn-default btn-round border-dashed"
                                           @click.prevent="viewCompleteListShare(item)">
                                            +{{item.share.length - 3}}
                                        </a>
                                    </li>
                                    <!-- Add User Button -->
                                    <li>
                                        <div class="dropdown">
                                            <a href="" class="btn btn-default btn-round"
                                               data-toggle="dropdown"
                                               @click="addShare">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li class="dropdown-header">
                                                    Search by name or email address
                                                </li>
                                                <li role="separator" class="divider"></li>
                                                <li>
                                                    <input type="text" class="form-control"
                                                           placeholder="Search"
                                                           v-focus="true"
                                                           v-model="searchUser">
                                                </li>
                                                <li>
                                                    <div class="list-group">
                                                        <a href="" class="list-group-item"
                                                           v-for="(user, index) in users"
                                                           @click.prevent="addShare(item, user)">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <img class="media-object" :src="user.avatar" alt="">
                                                                </div>
                                                                <div class="media-body">
                                                                    <strong>{{user.name}}</strong>
                                                                    <small class="text-muted">{{user.email}}</small>
                                                                </div>
                                                            </div>
                                                       </a>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- List Share modal-->
        <div class="modal fade modal-share" role="dialog" id="modalShare">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Share</h4>
              </div>
              <div class="modal-body">
                <ul class="media-list">
                    <li class="media" v-for="(user, index) in possession.share">
                        <div class="media-left">
                            <img class="media-object" :src="user.avatar" alt="">
                        </div>
                        <div class="media-body">
                            <button type="button" class="close" aria-label="Close"
                                    @click="removeShare(possession, user.id, index)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>{{user.name}}</strong><br>
                            <small>{{user.email}}</small>
                        </div>
                    </li>
                </ul>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</template>

<script>

import moment from 'moment';
import swal from 'sweetalert';

export default {
    data() {
        return {
            possessions: [],
            possession: {},
            form: {
                title: '',
                description: '',
                favorite: false
            },
            newTag: {
                data: {
                    title: null
                },
                options: {
                    show: false
                }
            },
            searchUser: '',
            users: []
        }
    },

    filters: {
        ago(date) {
            return moment(date).fromNow();
        }
    },

    directives: {
        focus: function (el, value) {
            if (value) {
                setTimeout(function(){el.focus();},0);
            }
        }
    },

    watch: {
        searchUser: 'fetchUsers'
    },

    mounted() {
        axios.get('/possession/byUser').then(response => {
            this.possessions = response.data;
        });
    },

    methods: {
        createItem: function () {
            axios.post('/possession/store', this.form).then(response => {
                this.possessions.unshift(response.data);
                this.form = {
                    title: '',
                    description: '',
                    favorite: false
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

        toogleFavorite: function (possession) {
            axios.post('/possession/favorite/' + possession.id)
            .then(response => {
                possession.favorite = response.data.favorite;
            });
        },

        comingSoon: function () {
            swal('Coming soon...');
        },

        addTag: function (possession) {
            if (this.newTag.data.title) {
                axios.post('/possession/addTag/' + possession.id, this.newTag.data)
                .then(response => {
                    possession.tags.push(response.data);
                    this.newTag = {
                        data: {
                            title: null
                        },
                        options: {
                            show: false
                        }
                    }
                });
            } else {
                this.newTag.options.show = possession;
            }
        },
        removeTag: function (possession, tagId, index) {
            axios.delete('/possession/removeTag/'+ possession.id +'/'+ tagId)
            .then(response => {
                possession.tags.splice(index, 1);
            });
        },
        cancelAddTag: function () {
            this.newTag = {
                data: {
                    title: null
                },
                options: {
                    show: false
                }
            }
        },

        addShare: function (possession, user) {

            if (possession && user) {
                axios.post('/possession/addShare/' + possession.id, {userId: user.id})
                .then(response => {
                    possession.share.push(user);
                    this.searchUser = '',
                    this.users = []
                });
            } else {
                this.searchUser = '',
                this.users = []
            }

        },
        removeShare: function (possession, shareId, index) {
            axios.delete('/possession/removeShare/'+ possession.id +'/'+ shareId)
            .then(response => {
                possession.share.splice(index, 1);
            });
        },

        viewCompleteListShare: function (possession) {
            this.possession = possession;
            $('#modalShare').modal('show');
        },

        fetchUsers: function () {
            if (this.searchUser.length > 3) {
                axios.get('/user/byNameOrEmail/' + this.searchUser)
                .then(response => {
                    this.users = response.data;
                });
            } else {
                this.users = [];
            }
        },

    }
}

</script>

<style lang="scss">

.possession-create.collapsing {
    -webkit-transition: none;
    transition: none;
}

.possessions {

    > .panel-body {
        padding: 0 !important;

        ul.list-unstyled {

            > li {
                padding: 20px 20px 30px;

                &:nth-child(even) {
                    background: #f3f3f3;
                }

                > h4 {
                    margin-bottom: 4px;
                }

                .btn-round {
                    border-radius: 50%;
                }
                .border-dashed {
                    border-style: dashed;
                }
                .fa-stack-sm {
                    font-size: .7em;
                }

                .attach {
                    padding-top:10px;
                    padding-bottom: 20px;
                    ul.list-inline {
                        margin-left: 0;
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

                .tags {
                    .label {
                        font-size: 13px;
                        margin-right: 3px;
                        font-weight: normal;

                        // a {
                        //     color: #fff;
                        //     opacity: 0.6;
                        // }
                    }
                }

                .shared {
                    li {
                        padding-left: 1px;
                        padding-right: 1px;

                        div.thumb {
                            position: relative;
                            cursor: pointer;
                            &:hover a,
                            &:hover .popover2 {
                                visibility: visible;
                                opacity: 1;
                            }
                            &:hover img {
                                border: 2px solid #3097D1;
                            }
                            img {
                                border-radius: 50%;
                                height: 38px;
                                width: 38px;
                                border: 2px solid transparent;
                            }
                            a {
                                position: absolute;
                                top: -7px;
                                right: -3px;
                                visibility: hidden;
                                opacity: 0;
                                transition: opacity .5s;
                            }
                            .popover2 {
                                position: absolute;
                                z-index: 1000;
                                top: 40px;
                                right: 0;
                                visibility: hidden;
                                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
                                opacity: 0;
                                transition: opacity .5s;
                            }
                        }

                        .dropdown-menu {
                            padding: 10px;

                            .list-group {
                                margin: 10px 0;
                            }
                        }
                    }
                }

            }

        }
    }

}

.modal-share {
    .media {
        padding: 10px;
        margin: 0;
        &:nth-child(even) {
            background: #f3f3f3;
        }
    }
}

</style>
