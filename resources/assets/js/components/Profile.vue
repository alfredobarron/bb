<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="media">
                            <div class="media-left">
                                <img class="media-object img-circle" :src="user.avatar_url">
                            </div>
                            <div class="media-body">
                                <vue-core-image-upload
                                  class="btn btn-default"
                                  @imageuploaded="uploadAvatar"
                                  extensions="png,jpeg,jpg"
                                  :headers=headers
                                  :url="'user/uploadAvatar/'+user.id">
                                </vue-core-image-upload>
                            </div>
                        </div>
                        <hr>
                        <form>
                            <div class="form-group" :class="{'has-error': this.errors.name}">
                                <label>Name *</label>
                                <input type="text" class="form-control" v-model="user.name">
                                <small class="help-block" v-if="this.errors.name">{{this.errors.name[0]}}</small>
                            </div>
                            <div class="form-group" :class="{'has-error': this.errors.email}">
                                <label>E-mail *</label>
                                <input type="email" class="form-control" v-model="user.email">
                                <small class="help-block" v-if="this.errors.email">{{this.errors.email[0]}}</small>
                            </div>
                            <div class="alert alert-info" v-if="this.user.email_change">
                                There is a request to change the email for <strong>{{this.user.email_change.email}}</strong>
                            </div>
                            <button type="submit" class="btn btn-success" @click.submit.prevent="updateProfile">Update profile</button>
                        </form>
                        <hr>
                        <form>
                            <div class="form-group" :class="{'has-error': this.errors.current}">
                                <label>Current password *</label>
                                <input type="password" class="form-control" v-model="password.current">
                                <small class="help-block" v-if="this.errors.current">{{this.errors.current[0]}}</small>
                            </div>
                            <div class="form-group" :class="{'has-error': this.errors.password}">
                                <label>New password *</label>
                                <input type="password" class="form-control" v-model="password.password">
                                <small class="help-block" v-if="this.errors.password">{{this.errors.password[0]}}</small>
                            </div>
                            <div class="form-group" :class="{'has-error': this.errors.password_confirmation}">
                                <label>Password confirmation *</label>
                                <input type="password" class="form-control" v-model="password.password_confirmation">
                                <small class="help-block" v-if="this.errors.password_confirmation">{{this.errors.password_confirmation[0]}}</small>
                            </div>
                            <button type="submit" class="btn btn-success" @click.submit.prevent="updatePassword">Change password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import VueCoreImageUpload from 'vue-core-image-upload'

    import Toasted from 'vue-toasted';
    Vue.use(Toasted);

    export default {
        props: ['userAuth'],
        data() {
            return {
                headers: {'X-CSRF-TOKEN': Laravel.csrfToken},
                user: this.userAuth,
                password: {},
                errors: {}
            }
        },
        components: {
            'vue-core-image-upload': VueCoreImageUpload,
        },
        mounted() {
            console.log(this.user);
            //console.log('Component mounted.')
        },
        methods: {
            updateProfile: function() {
                var data = {
                    name: this.user.name,
                    email: this.user.email
                }
                axios.post('/user/updateProfile/' + this.user.id, data)
                .then(response => {
                    console.log(response);
                    this.user.name = response.data.user.name;
                    this.user.email = response.data.user.email;
                    this.$toasted.show('Your profile is updated!', {
                        position: 'bottom-left',
                        duration: 2000
                    });
                    if (response.data.emailChange) {
                        this.user.email_change = response.data.user.email_change;
                        this.$toasted.show(response.data.emailChange, {
                            position: 'bottom-left',
                            duration: 6000,
                            theme: 'bubble'
                        });
                    }
                    this.errors = {};
                })
                .catch(error => {
                    this.error = error.data;
                });
            },
            updatePassword: function() {
                axios.post('/user/updatePassword/' + this.user.id, this.password)
                .then(response => {
                    console.log(response);
                    this.$toasted.show('Your password is updated!', {
                        position: 'bottom-left',
                        duration:2000
                    });
                    this.password = {};
                    this.errors = {};
                })
                .catch(error => {
                    this.errors = error.data;
                });
            },
            uploadAvatar(response) {
                console.log(response);
                this.user.avatar = response.data.avatar;
                this.user.avatar_url = response.data.avatar_url;
                this.$toasted.show('Your avatar is updated!', {
                    position: 'bottom-left',
                    duration:2000
                });
            }
        }
    }
</script>

<style lang="scss">

.media {
    .media-left{
        .media-object {
            width: 100px;
            height: 100px;
        }
    }
}
</style>
