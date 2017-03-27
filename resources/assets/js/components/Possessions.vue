<template>
    <div class="container possessions">
        <div class="row">
            <!-- Nav -->
            <div class="col-md-8">
                <ul class="nav nav-pills nav-possessions">
                    <li role="presentation" class="active">
                        <a href="#all" data-toggle="tab" @click="getAll">
                            All
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#favorites" data-toggle="tab" @click="getFavorites">
                            <i class="fa fa-star-o fa-lg" aria-hidden="true"></i> Favorites
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#shared-with-me" data-toggle="tab" @click="getSharedWithMe">
                            Shared with me
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Search -->
            <div class="col-md-4 text-right">
                <input type="text" class="form-control search" placeholder="Search" v-model="searchPossession">
            </div>
        </div>

        <!-- Create collapse -->
        <div class="collapse create-possession" id="collapse">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" class="form-control input-lg" placeholder="Car, House, Account..." v-model="newPossession.data.title">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="This possesions is..." v-model="newPossession.data.description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <!-- Favorite Button -->
                            <a href="" class="text-warning" @click.prevent="newPossession.data.favorite = !newPossession.data.favorite">
                                <i class="fa fa-star fa-lg" aria-hidden="true" v-if="newPossession.data.favorite"></i>
                                <i class="fa fa-star-o fa-lg" aria-hidden="true" v-else></i>
                            </a>
                            <!-- Attach Button -->
                            <a href="" class="btn btn-link" @click.prevent="comingSoon">
                                <i class="fa fa-paperclip fa-fw" aria-hidden="true"></i>
                                Attach
                            </a>
                            <!-- Tags -->
                            <span class="tags">
                                <!-- AddTag Button -->
                                <button class="btn btn-default btn-xs"
                                        v-show="newPossession.options.newTagShow == false"
                                        @click="newPossession.options.newTagShow = true">
                                    <i class="fa fa-tag fa-fw"></i> Add Tag
                                </button>
                                <!-- AddTag Input -->
                                <span class="form-inline">
                                    <div class="form-group">
                                        <input type="text" class="form-control input-sm" placeholder="Bank, Account..."
                                               v-model="newPossession.data.newTag"
                                               v-show="newPossession.options.newTagShow == true"
                                               v-focus="newPossession.options.newTagShow == true"
                                               @keyup.enter="addTagNewPossession"
                                               @keyup.esc="newPossession.options.newTagShow = false"
                                               @blur="newPossession.options.newTagShow = false">
                                    </div>
                                </span>
                                <!-- List Tags -->
                                <span class="label label-primary" v-for="(tag, index) in newPossession.data.tags">
                                    {{tag}}
                                    <a href="" @click.prevent="deleteTagNewPossession(index)">
                                        <span class="fa-stack fa-stack-sm">
                                          <i class="fa fa-circle fa-stack-2x"></i>
                                          <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                </span>
                            </span>
                        </div>
                        <!-- Shared -->
                        <div class="col-md-5 text-right">
                            <span class="shared">
                                <span v-if="newPossession.data.share.length==0">
                                    <i class="fa fa-share-alt fa-fw" aria-hidden="true"></i>
                                    <small>Share</small>
                                </span>
                                <!-- List Users shared -->
                                <span class="thumb" v-for="(share, index) in newPossession.data.share" v-if="index<3">
                                    <img :src="share.avatar" alt="">
                                    <a href="" @click.prevent="deleteShareNewPossession(index)">
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
                                </span>
                                <!-- Count Users-->
                                <span v-if="newPossession.data.share.length>3">
                                    <a href="" class="btn btn-default btn-round border-dashed"
                                       @click.prevent="viewCompleteListShare(newPossession.data)">
                                        +{{newPossession.data.share.length - 3}}
                                    </a>
                                </span>
                                <!-- Add User Button -->
                                <span class="dropdown">
                                    <a href="" class="btn btn-default btn-round"
                                       data-toggle="dropdown"
                                       @click="toogleSearchUsers">
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
                                            <div class="list-group" v-if="users.length>0">
                                                <a href="" class="list-group-item"
                                                   v-for="(user, index) in users"
                                                   @click.prevent="addShareNewPossession(user)">
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
                                            <div class="list-group text-center" v-if="searchUser.length>=3 && users.length==0">
                                                <p class="list-group-item text-muted">No found results!</p>
                                            </div>
                                        </li>
                                    </ul>
                                </span>
                            </span>
                            <button type="button" class="btn btn-sm btn-default margin-left-10" data-toggle="collapse" data-target="#collapse">Cancel</button>
                            <button type="button" class="btn btn-sm btn-success" @click="createPossession">Create</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- List -->
        <div class="panel panel-default list-possessions">
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li v-for="(possession, index) in filteredPossessions">
                        <div class="row" v-if="authUser.id == possession.user_id">
                            <div class="col-md-12 title-description" :class="{
                                'edit-title': currentPossession.id == possession.id,
                                'edit-description': currentPossession.id == possession.id}">
                                <h4 @dblclick="editPossession(possession)">
                                    {{possession.title}}
                                </h4>
                                <p @dblclick="editPossession(possession)">
                                    {{possession.description}}
                                </p>
                                <input type="text" class="form-control input-lg"
                                       v-model="possession.title"
                                       @keyup.esc="cancelEditPossession(possession)"
                                       @keyup.enter="updateTitle(possession)"
                                       @blur="updateTitle(possession)">
                                <textarea name="name" class="form-control"
                                          v-model="possession.description"
                                          @keyup.esc="cancelEditPossession(possession)"
                                          @keyup.enter="updateDescription(possession)"
                                          @blur="updateDescription(possession)">
                                </textarea>
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
                                <p class="text-muted">
                                    <small>{{possession.created_at | ago}}</small>
                                </p>
                            </div>
                            <!-- Favorite, Attach button, Delete & Tags -->
                            <div class="col-md-8">
                                <!-- Favorite Button -->
                                <a href="" class="text-warning" @click.prevent="updateFavorite(possession)">
                                    <i class="fa fa-star fa-lg" aria-hidden="true" v-if="possession.favorite"></i>
                                    <i class="fa fa-star-o fa-lg" aria-hidden="true" v-else></i>
                                </a>
                                <!-- Attach Button -->
                                <a href="" class="btn btn-link" @click.prevent="comingSoon">
                                    <i class="fa fa-paperclip fa-fw" aria-hidden="true"></i>
                                    Attach
                                </a>
                                <!-- Delete Button -->
                                <a href="" class="btn btn-link" @click.prevent="removePossession(possession.id, index)">
                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    Delete
                                </a>
                                <!-- Tags -->
                                <span class="tags">
                                    <!-- AddTag Button -->
                                    <button class="btn btn-default btn-xs"
                                            v-show="newTag.options.show != possession"
                                            @click="addTag(possession)">
                                        <i class="fa fa-tag fa-fw"></i> Add Tag
                                    </button>
                                    <!-- AddTag Input -->
                                    <span class="form-inline">
                                        <div class="form-group">
                                            <input type="text" class="form-control input-sm" placeholder="Bank, Account..."
                                                   v-model="newTag.data.title"
                                                   v-show="newTag.options.show == possession"
                                                   v-focus="newTag.options.show == possession"
                                                   @keyup.enter="addTag(possession)"
                                                   @keyup.esc="cancelAddTag"
                                                   @blur="cancelAddTag">
                                        </div>
                                    </span>
                                    <!-- List Tags -->
                                    <span class="label label-primary" v-for="(tag, index) in possession.tags">
                                        {{tag.title}}
                                        <a href="" @click.prevent="removeTag(possession, tag.id, index)">
                                            <span class="fa-stack fa-stack-sm">
                                              <i class="fa fa-circle fa-stack-2x"></i>
                                              <i class="fa fa-times fa-stack-1x fa-inverse"></i>
                                            </span>
                                        </a>
                                    </span>
                                </span>
                            </div>
                            <!-- Shared -->
                            <div class="col-md-4 text-right">
                                <span class="shared">
                                    <span v-if="possession.share.length==0">
                                        <i class="fa fa-share-alt fa-fw" aria-hidden="true"></i>
                                        <small>Share</small>
                                    </span>
                                    <!-- List Users shared -->
                                    <span class="thumb" v-for="(share, index) in possession.share" v-if="index<3">
                                        <img :src="share.avatar" alt="">
                                        <a href="" @click.prevent="removeShare(possession, share.id, index)">
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
                                    </span>
                                    <!-- Count Users-->
                                    <span v-if="possession.share.length>3">
                                        <a href="" class="btn btn-default btn-round border-dashed"
                                           @click.prevent="viewCompleteListShare(possession)">
                                            +{{possession.share.length - 3}}
                                        </a>
                                    </span>
                                    <!-- Add User Button -->
                                    <span class="dropdown">
                                        <a href="" class="btn btn-default btn-round"
                                           data-toggle="dropdown"
                                           @click="toogleSearchUsers">
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
                                                <div class="list-group" v-if="users.length>0">
                                                    <a href="" class="list-group-item"
                                                       v-for="(user, index) in users"
                                                       @click.prevent="addShare(possession, user)">
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
                                                <div class="list-group text-center" v-if="searchUser.length>=3 && users.length==0">
                                                    <p class="list-group-item text-muted">No found results!</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </span>
                                </span>
                            </div>
                        </div>
                        <div class="row" v-else>
                            <div class="col-md-12 title-description">
                                <h4>{{possession.title}}</h4>
                                <p>{{possession.description}}</p>
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
                                <p class="text-muted">
                                    <small>{{possession.created_at | ago}}</small><br>
                                    <small>Created by {{possession.user.name}}</small>
                                </p>
                            </div>
                            <!-- Favorite, Attach button, Delete & Tags -->
                            <div class="col-md-8">
                                <!-- Favorite -->
                                <i class="fa fa-star fa-lg margin-right-10" aria-hidden="true" v-if="possession.favorite"></i>
                                <i class="fa fa-star-o fa-lg margin-right-10" aria-hidden="true" v-else></i>
                                <!-- Tags -->
                                <span class="tags">
                                    <!-- List Tags -->
                                    <span class="label label-primary" v-for="(tag, index) in possession.tags">
                                        {{tag.title}}
                                    </span>
                                </span>
                            </div>
                            <!-- Shared -->
                            <div class="col-md-4 text-right">
                                <span class="shared">
                                    <!-- List Users shared -->
                                    <span class="thumb" v-for="(share, index) in possession.share" v-if="index<3">
                                        <img :src="share.avatar" alt="">
                                        <div class="panel panel-default popover2">
                                            <div class="panel-body">
                                                <strong>{{share.name}}</strong><br>
                                                <small>{{share.email}}</small>
                                            </div>
                                        </div>
                                    </span>
                                    <!-- Count Users-->
                                    <span v-if="possession.share.length>3">
                                        <a href="" class="btn btn-default btn-round border-dashed"
                                           @click.prevent="viewCompleteListShare(possession)">
                                            +{{possession.share.length - 3}}
                                        </a>
                                    </span>
                                </span>
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
                    <li class="media" v-for="(user, index) in currentPossession.share">
                        <div class="media-left">
                            <img class="media-object" :src="user.avatar" alt="">
                        </div>
                        <div class="media-body">
                            <button type="button" class="close" aria-label="Close" v-if="currentPossession.id && authUser.id == currentPossession.user_id"
                                    @click="removeShare(currentPossession, user.id, index)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <button type="button" class="close" aria-label="Close" v-if="!currentPossession.id"
                                    @click="deleteShareNewPossession(index)">
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
            filteredPossessions: [],
            currentListPossessions: 'all',
            searchPossession: null,
            currentPossession: {},
            newPossession: {
                data: {
                    title: '',
                    description: '',
                    favorite: false,
                    newTag: null,
                    tags: [],
                    share: []
                },
                options: {
                    newTagShow: false
                }
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

    props: ['authUser'],

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
        searchPossession: 'fetchPossessions',
        searchUser: 'fetchUsers'
    },

    mounted() {
        axios.get('/possession/byUser')
        .then(response => {
            this.filteredPossessions = response.data;
            this.possessions = response.data;
        });
    },

    methods: {
        getAll: function () {
            this.currentListPossessions = 'all';
            this.filteredPossessions = this.possessions;
        },

        getFavorites: function () {
            this.currentListPossessions = 'favorites';
            this.filteredPossessions = _.filter(this.possessions, 'favorite');
        },

        getSharedWithMe: function () {
            this.currentListPossessions = 'sharedWithMe';
            var self = this;
            this.filteredPossessions = _.filter(this.possessions, function(o) {
                return o.user_id != self.authUser.id
            });
        },

        fetchPossessions: function () {
            var self = this;
            if (this.searchPossession.length>0) {
                this.filteredPossessions = this.filteredPossessions.filter(function (row) {
                    return Object.keys(row).some(function (key) {
                        if (key == 'tags') {
                            return Object.keys(row[key]).some(function (index) {
                                return String(row[key][index].title).toLowerCase().indexOf(self.searchPossession) > -1
                            })
                        } else {
                            return String(row[key]).toLowerCase().indexOf(self.searchPossession) > -1
                        }
                    })
                })
            } else {
                switch (this.currentListPossessions) {
                    case 'all':
                        this.getAll();
                        break;
                    case 'favorites':
                        this.getFavorites();
                        break;
                    case 'sharedWithMe':
                        this.getSharedWithMe();
                        break;
                }
            }
        },

        createPossession: function () {
            axios.post('/possession/store', this.newPossession.data)
            .then(response => {
                this.possessions.unshift(response.data);
                this.filteredPossessions = this.possessions;
                this.newPossession.data = {
                    title: '',
                    description: '',
                    favorite: false,
                    newTag: null,
                    tags: [],
                    share: []
                };
                $('#collapse').collapse('hide');
            });
        },

        removePossession: function (id, index) {
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
                    self.filteredPossessions = self.possessions;
                    swal({
                        title: "Deleted!",
                        text: "Your possession has been deleted.",
                        type: "success",
                        timer: 1000,
                        showConfirmButton: false
                    });
                });
            });

        },

        addTagNewPossession: function () {
            if (this.newPossession.data.newTag) {
                this.newPossession.data.tags.push(this.newPossession.data.newTag);
                this.newPossession.data.newTag = null;
                this.newPossession.options.newTagShow = false;
            }
        },
        deleteTagNewPossession: function (index) {
            this.newPossession.data.tags.splice(index, 1);
        },

        addShareNewPossession: function (user) {
            this.newPossession.data.share.push(user);
        },
        deleteShareNewPossession: function (index) {
            this.newPossession.data.share.splice(index, 1);
        },

        editPossession: function (possession) {
            this.currentPossession = _.clone(possession);
        },
        cancelEditPossession: function (possession) {
            possession.title = this.currentPossession.title;
            possession.description = this.currentPossession.description;
            this.currentPossession = {};
        },

        updateTitle: function (possession) {
            if (possession.title) {
                if (this.currentPossession.title) {
                    if (possession.title != this.currentPossession.title) {
                        axios.put('/possession/update/' + possession.id, possession)
                        .then(response => {
                            possession = response.data;
                            console.log('se guardo correctamente');
                            this.currentPossession = {};
                        });
                    }
                    this.currentPossession = {};
                }
            } else {
                possession.title = this.currentPossession.title;
            }
        },

        updateDescription: function (possession) {
            if (possession.description) {
                if (this.currentPossession.description) {
                    if (possession.description != this.currentPossession.description) {
                        axios.put('/possession/update/' + possession.id, possession)
                        .then(response => {
                            possession = response.data;
                            console.log('se guardo correctamente');
                            this.currentPossession = {};
                        });
                    }
                    this.currentPossession = {};
                }
            } else {
                possession.description = this.currentPossession.description;
            }
        },

        updateFavorite: function (possession) {
            axios.post('/possession/favorite/' + possession.id)
            .then(response => {
                possession.favorite = response.data.favorite;
            });
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

            axios.post('/possession/addShare/' + possession.id, {userId: user.id})
            .then(response => {
                possession.share.push(user);
                this.searchUser = '',
                this.users = []
            });

        },
        removeShare: function (possession, shareId, index) {
            axios.delete('/possession/removeShare/'+ possession.id +'/'+ shareId)
            .then(response => {
                possession.share.splice(index, 1);
            });
        },

        viewCompleteListShare: function (possession) {
            this.currentPossession = possession;
            $('#modalShare').modal('show');
        },

        toogleSearchUsers: function () {
            this.searchUser = '',
            this.users = []
        },
        fetchUsers: function () {
            if (this.searchUser.length >= 3) {
                axios.get('/user/byNameOrEmail/' + this.searchUser)
                .then(response => {
                    this.users = response.data;
                });
            } else {
                this.users = [];
            }
        },

        comingSoon: function () {
            swal('Coming soon...');
        }
    }
}

</script>

<style lang="scss">

.possessions {
    .margin-left-10 {
        margin-left: 10px;
    }
    .margin-right-10 {
        margin-right: 10px;
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

    .search {
        background-color: #f5f8fa;
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
        .thumb {
            display: inline-block;
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

        .dropdown {
            display: inline-block;
        }

        .dropdown-menu {
            padding: 10px;

            .list-group {
                margin: 10px 0;
            }
        }
    }
}

.create-possession.collapsing {
    -webkit-transition: none;
    transition: none;
}

.nav-possessions {
    margin-bottom: 10px;
}

.list-possessions {

    > .panel-body {
        padding: 0 !important;

        ul.list-unstyled {
            margin-bottom: 0;
            > li {
                padding: 20px 20px 30px;

                &:nth-child(even) {
                    background: #f3f3f3;
                }

                .title-description {
                    input, textarea {
                        border: 1px solid transparent;
                        background-color: transparent;
                        box-shadow: none;
                        display: none;
                        &:hover {
                            border: 1px solid #ccd0d2;
                        }
                    }
                    textarea {
                        resize: none;
                        height: auto;
                    }
                }

                .edit-title {
                    h4 {
                        display: none;
                    }
                    input {
                        display: block;
                    }
                }

                .edit-description {
                    p {
                        display: none;
                    }
                    textarea {
                        display: block;
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
