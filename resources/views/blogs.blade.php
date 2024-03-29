<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel 11 Ajax CRUD Operation Example Tutorial - Tutsmake.com</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="container" style="
    margin: 60px;
    padding: 22px;
">
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-1 mb-1" style="
    text-align: center;
    border: 15px solid yellow;">
                <h2>Laravel 11 Ajax CRUD Operation Example Tutorial - Tutsmake.com</h2>
            </div>
            <div class="pull-right mb-2 mt-1">
                <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Add Blog Post</a>
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <div class="card-body">
        <table class="table table-bordered" id="blogs">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Title</th>
                 <th>Detail</th>
                 <th>Created at</th>
                 <th>Action</th>
              </tr>
           </thead>
        </table>
    </div>
   
</div>
  <!-- boostrap blog model -->
  <!-- boostrap blog model -->
    <div class="modal fade" id="blog-modal" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="BlogModal"></h4>
          </div>
          <div class="modal-body">
            <form action="javascript:void(0)" id="blogForm" name="blogForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="id" id="id">
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Title</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="title" name="title" placeholder="Enter title" maxlength="50" required="">
                </div>
              </div>  
              <div class="form-group">
                <label class="col-sm-2 control-label">Detail</label>
                <div class="col-sm-12">
                  <input type="text" class="form-control" id="detail" name="detail" placeholder="Enter Detail" required="">
                </div>
              </div>
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                </button>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>
<!-- end bootstrap model -->
</body>
<script type="text/javascript">
     
 $(document).ready( function () {
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
    $('#blogs').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ url('blog-list') }}",
           columns: [
                    { data: 'id', name: 'id' },
                    { data: 'title', name: 'title' },
                    { data: 'detail', name: 'detail' },
                    { data: 'created_at', name: 'created_at' },
                    {data: 'action', name: 'action', orderable: false},
                 ],
                 order: [[0, 'desc']]
       });
  });
  
  function add(){
       $('#blogForm').trigger("reset");
       $('#BlogModal').html("Add Blog");
       $('#blog-modal').modal('show');
       $('#id').val('');
  }   
  function editFunc(id){
    
    $.ajax({
        type:"POST",
        url: "{{ url('edit-blog') }}",
        data: { id: id },
        dataType: 'json',
        success: function(res){
          $('#BlogModal').html("Edit Blog");
          $('#blog-modal').modal('show');
          $('#id').val(res.id);
          $('#title').val(res.title);
          $('#detail').val(res.detail);
       }
    });
  }  
  function deleteFunc(id){
        if (confirm("Delete Record?") == true) {
        var id = id;
         
          // ajax
          $.ajax({
              type:"POST",
              url: "{{ url('delete-blog') }}",
              data: { id: id },
              dataType: 'json',
              success: function(res){
                var oTable = $('#blogs').dataTable();
                oTable.fnDraw(false);
             }
          });
       }
  }
  $('#blogForm').submit(function(e) {
     e.preventDefault();
  
     var formData = new FormData(this);
  
     $.ajax({
        type:'POST',
        url: "{{ url('store-blog')}}",
        data: formData,
        cache:false,
        contentType: false,
        processData: false,
        success: (data) => {
          $("#blog-modal").modal('hide');
          var oTable = $('#blogs').dataTable();
          oTable.fnDraw(false);
          $("#btn-save").html('Submit');
          $("#btn-save"). attr("disabled", false);
        },
        error: function(data){
           console.log(data);
         }
       });
   });
</script>
</body>
</html>