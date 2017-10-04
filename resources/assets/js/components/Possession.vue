<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <p class="lead" v-if="possession.parent">
                    <a :href="'/possessions/'+possession.parent.id">
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                    </a>
                    {{possession.parent.title}}
                </p>
            </div>
            <div class="col-md-6 text-right">
                <a href="#" class="btn btn-default">
                    <i class="fa-fw fa fa-pencil" aria-hidden="true"></i> Edit
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h1>{{possession.title}}</h1>
                <p>{{possession.description}}</p>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12">
                <p>Folders</p>
            </div>
            <div class="col-sm-3">
                <div class="panel panel-success" data-toggle="modal" data-target="#myModalNewFolder">
                    <div class="panel-body text-success">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        New Folder
                    </div>
                </div>
            </div>
            <div class="col-sm-3" v-for="folder in possession.folders">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-folder fa-stack-1x fa-inverse"></i>
                        </span>
                        {{folder.title}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p>Files</p>
            </div>
            <div class="col-sm-3">
                <dropzone id="myVueDropzone" ref="myVueDropzone"
                    :use-custom-dropzone-options=true :dropzoneOptions="dzOptions"
                    :url="'/possession/file/upload/'+possession.id" v-on:vdropzone-success="uploadSuccess">
                </dropzone>
            </div>
            <div class="col-sm-3" v-for="file in poss.files">
                <a :href="file.url" class="thumbnail" v-if="file.is_image">
                    <img :src="file.urlThumb" class="img-responsive">
                </a>
                <a :href="file.url" class="thumbnail" v-else>
                    <i class="fa fa-file-o fa-5x"></i>
                    <div class="caption">
                        <p>{{file.name}}</p>
                    </div>
                </a>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <p>Comments</p>
                <form>
                    <div class="form-group">
                        <textarea class="form-control" rows="3" placeholder="Write a comment here..." v-model="newComment.comment"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-success" @click="createComment">Comment</button>
                    </div>
                </form>
                <div v-for="comment in possession.comments">
                    <p class="text-right"><small>{{comment.created_at | ago}}</small></p>
                    <p><strong>{{comment.comment}}</strong></p>
                    <hr>
                </div>
            </div>
        </div>
        <br><br><br>
        <!-- Modal New Folder -->
        <div class="modal fade" id="myModalNewFolder">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">New Folder</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Photos" v-model="newFolder.title">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" @click="createFolder">Create</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import Dropzone from 'vue2-dropzone';
export default {
    props: ['possession'],
    components: {
        Dropzone
    },
    filters: {
        ago(date) {
            return moment(date).fromNow();
        }
    },
    data() {
        return {
            poss: {},
            dzOptions: {
                useFontAwesome: true,
                acceptedFileTypes: '.jpg,.jpeg,.png,.pdf,.xlsx,.docx,.xml',
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
                maxFileSizeInMB: 10
            },
            newFolder: {
                title: null,
                possession_id: 0
            },
            newComment: {
                comment: null,
                possession_id: 0
            }
        }
    },
    mounted() {
        this.poss = this.possession;
        this.newFolder.possession_id = this.possession.id;
        this.newComment.possession_id = this.possession.id;
    },
    methods: {
        createFolder: function() {
            axios.post('/possession/folder/store', this.newFolder)
            .then(response => {
                this.possession.folders.unshift(response.data);
                this.newFolder.title = null;
                $('#myModalNewFolder').modal('hide');
            });
        },
        uploadSuccess: function(file, response){
            this.$refs.myVueDropzone.removeFile(file);
            this.possession.files.push(response);
        },
        createComment: function() {
            axios.post('/possession/comment/store', this.newComment)
            .then(response => {
                this.possession.comments.unshift(response.data);
                this.newComment.comment = null;
            });
        }
    }
}
</script>
