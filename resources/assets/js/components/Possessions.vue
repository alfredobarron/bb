<template>
  <div class="container">
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
                  <a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-tag"></span> Tag</a>
                  <a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-paperclip"></span> Attach</a>
                </div>
                <!-- Shared -->
                <div class="col-md-6 shared">
                  <ul class="list-inline shared text-right">
                    <li><a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-share-alt"></span> Shared</a></li>
                  </ul>
                </div>
                <!-- Action Buttons-->
                <div class="col-md-12 text-right">
                  <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#collapse">Cancel</button>
                  <button type="button" class="btn btn-success" v-on:click="create">Create</button>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <ul class="list-unstyled possessions">
              <li v-for="item in possessions">

                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="close" aria-label="Close"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>
                    <h4>{{item.title}}</h4>
                    <p><small>{{item.description}}</small></p>
                  </div>
                  <!-- Tags -->
                  <div class="col-md-6 tags">
                    <span class="label label-info" v-for="tag in item.tags">{{tag.title}}</span>
                    <a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-tag"></span> Tag</a>
                    <a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-paperclip"></span> Attach</a>
                  </div>
                  <!-- Shared -->
                  <div class="col-md-6 shared">
                    <ul class="list-inline shared text-right">
                      <li><a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-share-alt"></span> Shared</a></li>
                      <li><img src="http://lorempixel.com/48/48/people/1" alt=""></li>
                      <li><img src="http://lorempixel.com/48/48/people/2" alt=""></li>
                      <li><img src="http://lorempixel.com/48/48/people/3" alt=""></li>
                      <li><img src="http://lorempixel.com/48/48/people/4" alt=""></li>
                    </ul>
                  </div>
                </div>

                <div class="row attach">
                  <!-- Attach-->
                  <div class="col-md-10">
                    <ul class="list-inline">
                      <li><img src="http://lorempixel.com/48/48/business/1" alt=""></li>
                      <li><img src="http://lorempixel.com/48/48/business/2" alt=""></li>
                      <li><img src="http://lorempixel.com/48/48/business/3" alt=""></li>
                      <li><img src="http://lorempixel.com/48/48/business/4" alt=""></li>
                    </ul>
                  </div>
                  <div class="col-md-2 text-right">
                    <p class="text-muted"><small>{{item.created_at | ago}}</small></p>
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

  export default {
    data() {
      return {
        possessions: [],
        form: {
          title: '',
          description: ''
        }
      }
    },

    filters: {
      ago(date) {
        return moment(date).fromNow();
      }
    },

    methods: {
      create: function () {
        axios.post('/possession/store', this.form).then(response => {
          console.log(response);
          console.log(this.form);
          this.possessions.unshift(this.form);
          this.form = {
            title: '',
            description: ''
          };
          $('#collapse').collapse('hide');
        });
      }
    },

    created() {
      axios.get('/possession/all/byUser').then(response => {
        this.possessions = response.data;
      });
    }

  }
</script>

<style lang="scss">
  .collapse.possession-create.collapsing {
    -webkit-transition: none;
    transition: none;
  }

  ul.possessions {
    .close {
      font-size: 14px;
    }
    h4 {
      margin-bottom: 4px;
    }
    .tags .label {
      font-size: 14px;
      margin-right: 3px;
    }
    .shared {
      li {
        padding-left: 0;
        padding-right: 0;
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
        padding-left: 2;
        padding-right: 2;
      }
    }

  }

</style>
