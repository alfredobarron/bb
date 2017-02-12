<template>
  <div class="modal fade" role="dialog" id="myModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Possession</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="exampleInputEmail1">Title</label>
            <input type="text" class="form-control" placeholder="Car, House, Account...">
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Description</label>
            <textarea class="form-control" rows="3" placeholder="This possesions is..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-trash"></span> Delete</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success">Add</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
</template>

<script>
  export default {

  }
</script>

<style lang="scss">

</style>
