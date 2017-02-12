<template>
  <div class="container possession-create">
    <div class="collapse" id="collapse">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <ul class="list-unstyled possessions">
              <li>
                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <input type="text" class="form-control input-lg" placeholder="Car, House, Account..." v-model="form.title">
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" rows="3" placeholder="This possesions is..." v-model="form.description"></textarea>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                        <span class="label label-info">tags</span>
                      </div>
                      <div class="col-md-4 text-right">
                        usuarios
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <ul class="list-unstyled">
                      <li><a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-tag"></span> Tag</a></li>
                      <li><a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-paperclip"></span> Attach</a></li>
                      <li><a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-share-alt"></span> Shared</a></li>
                      <li><a href="#" class="btn btn-sm"><span class="glyphicon glyphicon-trash"></span> Delete</a></li>
                      <li><br></li>
                      <li><button type="button" class="btn btn-success btn-block btn-sm" v-on:click="create">Create</button></li>
                    </ul>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          title: '',
          description: ''
        }
      }
    },

    methods: {
      create: function () {
        axios.post('/possession/store', this.form).then(response => {
          this.form = {
            title: '',
            description: ''
          };
          $('#collapse').collapse('hide');
          this.$emit('create', this.form);
        });
      }
    }
  }
</script>

<style lang="scss">
  .possession-create {
    .collapsing {
      -webkit-transition: none;
      transition: none;
    }
  }
</style>
