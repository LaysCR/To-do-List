@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="panel-body">
        <!-- Display Validation Errors -->
        @include('common.errors')

        <!-- New Task Form -->
        <form action="{{ url('task') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <!-- Task Name -->
            <div class="form-group">
                <label for="task-name" class="col-sm-3 control-label">Task</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="task-name" class="form-control">
                </div>
            </div>

            <!-- Add Task Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-default">
                        <i class="fa fa-plus"></i> Add Task
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- TODO: Current Tasks -->

    @if (count($tasks) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                        <th>Task</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($tasks as $task)
                          <tr>
                            <!-- Task Name -->
                            <td class="table-text">
                                <div>{{ $task->name }}</div>
                            </td>

                            <!-- Delete Button -->
                            <td>
                                <form action="{{ url('task/'.$task->id) }}" method="POST">
                                  <input type="hidden" value="{{$task}}">

                                    {{ csrf_field() }}
                                    {{ method_field("DELETE") }}

                                    <button type="submit" class="btn btn-danger delete-task">
                                        <i class="fa fa-btn fa-trash"></i>Delete
                                    </button>
                                </form>
                            </td>
                            <!-- Update Button -->
                            <td>
                                <form>
                                  <input type="hidden" value="{{$task}}">
                                  <button type="button" class="btn btn-danger edit-task">
                                      <i class="fa fa-btn fa-trash"></i>Edit
                                  </button>
                                </form>
                            </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">

                    <div class="modal-header">
                      <label for="message-text" class="control-label">Edit</label>
                    </div>

                      <br>
                      <form id="updateForm" action="{{ url('task/'.$task->id) }}" method="POST">
                        {{-- <input id="tokenVerify" type="hidden" value="{{csrf_token()}}"> --}}
                      <textarea id="edit-text" class="edit-area form-control"></textarea>
                      <br>

                    <div class="modal-footer">
                      <button type="button" class="btn" data-dismiss="modal" id="form-close">Cancel</button>
                      <button type="submit" id="btn-edit" class="btn btn-success edit-task-{{ $task->id }}" value="{{ $task->id }}"
                        data-toggle="modal" data-target="#myModal">
                          <i class="fa fa-btn fa-trash"></i>Submit
                      </button>
                    </form>
                    </div>
                  </div>

                </div>
              </div>

            </div>
        </div>
    @endif

@endsection

@section('scripts')
    <script type="text/javascript">

      $(document).ready(function () {

        var task;
        var row;

        function editTask() {
          $("#myModal").modal("toggle");
          task = JSON.parse($(this).parent().children().val());
          row = $(this).parent().parent().parent().children(".table-text");
          var name = row.children().text();
          $("#edit-text").val(name);
        }
        // function deleteTask(e) {
        //   e.preventDefault();
        //   task = JSON.parse($(this).parent().children().val()); console.log(task);
        //   var token = $("meta[name=csrf]").attr('token');
        //   $.ajax({
        //     url : '/task/' + task,
        //     method : "POST",
        //     data : {
        //       _token : token,
        //       _method : "DELETE"
        //     },
        //     success : function(response) {
        //       console.log(response);
        //     },
        //     error : function(response) {
        //       console.log(response);
        //     }
        //   });
        // }

        $(".edit-task").on("click", editTask);
        // $(".delete-task").on("click", deleteTask);

        $("#updateForm").submit(function(e){
          e.preventDefault();
          // var tokenVerify = $("#tokenVerify").val(); console.log(tokenVerify);
          var text = $("#edit-text").val();
          var token = $("meta[name=csrf]").attr('token');
          var id = task.id;
          $.ajax({
            url: '/tasks/' + id,
            method: "POST",
            data: {
              _token: token,
              _method: "PUT",
              name: text
            },
            success: function(response) {
              var newTask =
              '<td class="table-text">' +
                  '<div>' + text + '</div>' +
              '</td>';

              row.html(newTask);
              // $(".edit-task").on("click",editTask);
            },
            error: function(response) {
              console.log(response);
            }
          })
        });
      });
    </script>
@endsection
