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

                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" id="delete-task-{{ $task->id }}" class="btn btn-danger">
                                        <i class="fa fa-btn fa-trash"></i>Delete
                                    </button>
                                </form>
                            </td>
                            <!-- Update Button -->
                            <td>

                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}

                                    <button type="button" id="edit-task-{{ $task->id }}" class="btn btn-danger" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-btn fa-trash"></i>Edit
                                    </button>
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

                      <form action="{{ url('task/'.$task->id) }}" method="POST">
                      <textarea class="form-control" id="description" name="description"></textarea>
                      <br>

                    <div class="modal-footer">
                      <button type="button" class="btn" data-dismiss="modal" id="form-close">Cancel</button>
                      <button type="button" id="edit-task-{{ $task->id }}" class="btn btn-success" data-toggle="modal" data-target="#myModal">
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
    function toggleModal() {
      $('#myModal').modal("toggle");
    }
      $(document).ready(function () {
        $("#edit-task-{{ $task->id }}").click(toggleModal);
          // e.preventDefault();

          // .on('shown.bs.modal', function () {
            // $('#myInput').focus();
          // })

      });
    </script>
@endsection
