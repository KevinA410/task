@extends('layouts.app')

@section('content')
<!--Navbar tabs-->
<nav class="navbar navbar-light bg-light">
  <!--Button toggle-->
  <button class="navbar-toggler" id="menu-toggle">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!--Tabs-->
  <ul class="h4 nav nav-tabs nav-justified mr-auto" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link" id="tabNotas" data-toggle="tab" href="#notas" role="tab" aria-controls="notas" aria-selected="true">Notes
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="tabTareas" data-toggle="tab" href="#tareas" role="tab" aria-controls="tareas" aria-selected="false">Tasks
      </a>
    </li>
  </ul>
</nav>
<!---->

<div class="d-flex" id="wrapper">

  <!-- Sidebar -->
  <div class="bg-light border-right" id="sidebar-wrapper">
    <!--My slide menu-->
    <!--Header-->
    <div class="row row-cols-3 m-1 mt-4">
      <p class="col-4 h4 text-muted">Categories</p>
      <div class="w-100"></div>

      <form id="form_category" action="{{ route('add_category') }}" method="POST" class="d-none">
        @csrf
        <input type="text" name="user_id" value="{{ $user_id }}">
        <input type="text" name="name" id="form_name" required>
      </form>

      <input type="text" class="col-9 form-control ml-2" placeholder="Add" id="input_name">
      <button class="col-2 ml-1 btn btn-primary d-inline" id="btn_add_category">
        +
      </button>
    </div>

    <hr class="mt-2 ml-2">
    <!--Categories list-->
    <div class="card ml-2">
      <ul class="list-group list-group-flush">
        @foreach($categories as $category)
        <li class="list-group-item" id="category{{ $category->id }}">
          <form action="{{ route('delete_category') }}" method="POST">
            <input type="text" name="id" value="{{ $category->id }}" hidden>
            @csrf
            <button type="submit" class="btn btn-danger px-2 py-1">
              x
            </button>
            {{ $category->name }}&nbsp;
            <span class="badge badge-pill badge-primary">{{ count($category->notes()->get()) }}, {{ count($category->tasklists()->get()) }}</span>
          </form>
        </li>
        @endforeach
      </ul>
    </div>
    <!---->
  </div>
  <!-- /#sidebar-wrapper -->

  <!-- Page Content -->
  <div id="page-content-wrapper">
    <!--Main content-->
    <div class="container tab-content" id="myTabContent">
      <!--Tab area-->
      <div class="tab-pane fade show active" id="notas" role="tabpanel" aria-labelledby="tabNotas">
        <!--Notes-->
        <div class="row row-cols-1 row-cols-lg-2">
          <!--New note (form)-->
          <div class="col mt-2">
            <form action="{{ route('add_note') }}" method="POST" class="card bg-light" width="90%">
              @csrf
              <input type="text" name="user_id" value="{{ $user_id }}" hidden>
              <div class="card-header bg-primary">
                <input id="note_title" type="text" placeholder="Title" class="form-control" name="title" required>
              </div>
              <div class="card-body">
                <!-- Select category -->
                <select id="note_category" name="category" class="form-control" required>
                  <option selected value="" disabled>Select category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>

                <p class="card-text mt-3">
                  <textarea id="note_area" placeholder="Write here..." name="description" class="form-control" required></textarea>
                </p>
                <div class="text-right">
                  <button id="clear_note_form" class="btn btn-secondary">
                    <img src="{{ asset('icons/goma-de-borrar.svg') }}" width="20px" height="20px" alt="">
                  </button>
                  <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('icons/floppy-disk.svg') }}" width="20px" width="20px" alt="">
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!--Note 1-->
          @foreach($notes as $note)
          <div class="col mt-2">
            <form id="form{{ $note->id }}" action="" method="POST" class="card bg-light" width="90%">
              @csrf
              <div class="card-header">
                <input type="text" name="id" value="{{ $note->id }}" hidden>
                <input id="title{{ $note->id }}" type="text" name="title" value="{{ $note->title }}" class="h5 form-control" required readonly>
              </div>
              <div class="card-body">
                <p class="card-text text-justify">
                  <strong>Category:&nbsp;</strong>{{ App\Models\Category::find($note->category_id)->name }}
                </p>
                <p class="card-text text-justify">
                  <textarea id="description{{ $note->id }}" name="description" class="form-control" required readonly>{{$note->description}}</textarea>
                </p>
                <div class="text-right">
                  <button id="btn_delete{{ $note->id }}" class="btn btn-danger">
                    <img src="{{ asset('icons/delete-package.svg') }}" width="20px" height="20px" alt="">
                  </button>
                  <button id="btn_edit{{ $note->id }}" class="btn btn-primary">
                    <img src="{{ asset('icons/lapiz.svg') }}" width="20px" height="20px">
                  </button>
                  <span class="d-none" id="cont{{ $note->id }}">
                    <button id="btn_cancel{{ $note->id }}" class="btn btn-secondary">
                      Cancel
                    </button>
                    <button id="btn_save{{ $note->id }}" class="btn btn-primary">
                      Save
                    </button>
                  </span>

                  <script>
                    $("#btn_delete{{ $note->id }}").click(function(e) {
                      $("#form{{ $note->id }}").attr("action", "{{ route('delete_note') }}");
                      $("#form{{ $note->id }}").submit();
                    });

                    $("#btn_edit{{ $note->id }}").click(function(e) {
                      e.preventDefault();
                      $("#cont{{ $note->id }}").attr("class", " ");
                      $("#btn_edit{{ $note->id }}").attr("class", "d-none");
                      $("#title{{ $note->id }}").removeAttr("readonly");
                      $("#description{{ $note->id }}").removeAttr("readonly");
                    });

                    $("#btn_cancel{{ $note->id }}").click(function(e) {
                      e.preventDefault();

                      $("#title{{ $note->id }}").attr("readonly", true);
                      $("#description{{ $note->id }}").attr("readonly", true);

                      $("#title{{ $note->id }}").val("{{ $note->title }}");
                      $("#description{{ $note->id }}").val("{{ $note->description }}");

                      $("#cont{{ $note->id }}").attr("class", "d-none");
                      $("#btn_edit{{ $note->id }}").attr("class", "btn btn-primary");
                    });

                    $("#btn_save{{ $note->id }}").click(function(e) {
                      $("#form{{ $note->id }}").attr("action", "{{ route('edit_note') }}");
                    });
                  </script>
                </div>
              </div>
            </form>
          </div>
          @endforeach
        </div>
      </div>

      <!--Area de tareas-->
      <div class="tab-pane fade" id="tareas" role="tabpanel" aria-labelledby="tabTareas">
        <div class="row row-cols-1 row-cols-lg-2">
          <!--New list (form)-->
          <div class="col mt-2">
            <form action="{{ route('add_tasklist') }}" method="POST" class="card bg-light" width="90%">
              @csrf
              <input type="text" name="user_id" value="{{ $user_id }}" hidden>
              <input type="text" id="tasks_counter" name="counter" value="1" hidden>
              <div class="card-header bg-primary">
                <input name="name" id="tasklist_title" type="text" placeholder="List title" class="form-control" required>
              </div>
              <div class="card-body">
                <!-- Select category -->
                <select id="tasklist_category" name="category" class="form-control" required>
                  <option selected value="" disabled>Select category</option>
                  @foreach($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
                <div id="tasks" class="mt-3">
                  <div id="cont_task1" class="input-group mb-2">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        <input id="task_rd1" name="task_rd1" type="radio" aria-label="Radio button for following text input" disabled>
                      </div>
                    </div>
                    <input required id="task_txt1" name="task_txt1" type="text" placeholder="Write a task" class="form-control" aria-label="Text input with radio button">
                  </div>
                </div>


                <!-- Add or Remove tasks -->
                <div class="buttons d-flex justify-content-end mt-1 mb-3">
                  <button id="delete_task" class="btn btn-danger mx-2 py-0">
                    -
                  </button>
                  <button id="add_task" class="btn btn-primary py-0">
                    +
                  </button>

                  <script>
                    $("#delete_task").click(function(e) {
                      e.preventDefault();
                      var tasks = parseInt($("#tasks_counter").val());
                      if (tasks > 1) {
                        tasks -= 1;
                        $("#tasks_counter").val(tasks);
                        $("#cont_task" + tasks).remove();
                      }
                    });

                    $("#add_task").click(function(e) {
                      e.preventDefault();
                      var tasks = parseInt($("#tasks_counter").val());
                      tasks += 1;
                      $("#tasks_counter").val(tasks);
                      $("#tasks").append(`
                        <div id="cont_task${tasks}" class="input-group mb-2">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <input disabled name="task_rd${tasks}" type="radio" aria-label="Radio button for following text input">
                            </div>
                          </div>
                          <input required name="task_txt${tasks}" type="text" placeholder="Write a task" class="form-control" aria-label="Text input with radio button">
                        </div>
                      `);
                    });
                  </script>
                </div>

                <div class="text-right">
                  <button id="clear_tasklist_form" class="btn btn-secondary">
                    <img src="{{ asset('icons/goma-de-borrar.svg') }}" width="20px" height="20px">
                  </button>
                  <button class="btn btn-primary">
                    <img src="{{ asset('icons/floppy-disk.svg') }}" width="20px" height="20px">
                  </button>
                </div>
              </div>
            </form>
          </div>

          <!--Checklist 1-->
          @foreach($tasklists as $tasklist)
          <div class="col mt-2">
            <form id="form_tasklist{{ $tasklist->id }}" action="" method="POST" class="card bg-light" width="90%">
              @csrf
              <input type="text" name="id" value="{{ $tasklist->id }}" hidden>
              <div class="card-header">
                <h5 class="card-title">{{ $tasklist->name }}</h5>
              </div>
              <div class="card-body">
                <p class="card-text text-justify">
                  <strong>Category:&nbsp;</strong>{{ App\Models\Category::find($note->category_id)->name }}
                </p>
                @foreach($tasklist->tasks()->get() as $task)
                <div class="input-group mb-2">
                  <div class="input-group-prepend">
                    <div class="input-group-text">
                      @if($task->checked)
                      <input type="radio" checked>
                      @else
                      <input id="rd{{ $task->id }}" type="radio">

                      <script>
                        $("#rd{{ $task->id }}").click(function(e) {
                          $.ajax({
                            url: "{{ route('edit_tasklist') }}",
                            data: {
                              "_token": $("meta[name='csrf-token']").attr("content"),
                              id: "{{ $task->id }}"
                            },
                            type: "POST",
                            success: function() {}
                          });
                        });
                      </script>
                      @endif
                    </div>
                  </div>
                  <input type="text" placeholder="Add dark mode" class="form-control" value="{{ $task->name }}" readonly>
                </div>
                @endforeach

                <div class="text-right">
                  <button id="delete_tasklist" class="btn btn-danger">
                    <img src="{{ asset('icons/delete-package.svg') }}" width="20px" height="20px">
                  </button>
                </div>
                <script>
                  $("#delete_tasklist").click(function(e) {
                    $("#form_tasklist{{ $tasklist->id }}").attr("action", " {{ route('delete_tasklist') }}");
                  });
                </script>
              </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>


</div>

<!-- Menu Toggle Script -->
<script>
  $("#menu-toggle").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled");
  });

  $("#btn_add_category").click(function(e) {
    $("#form_name").val($("#input_name").val());
    if ($("#form_name").val().trim().length > 0) {
      $("#form_category").submit();
    } else {
      alert("Category name is required");
    }
    $("#input_name").val("");
  });

  $("#clear_note_form").click(function(e) {
    e.preventDefault();
    $("#note_title").val("");
    $("#note_description").val("");
    $("#note_category").val("");
    $("#note_area").val("");
  });

  $("#clear_tasklist_form").click(function(e) {
    e.preventDefault();
    var tasks = parseInt($("#tasks_counter").val());
    $("#tasklist_title").val("");
    $("#tasklist_category").val("");
    // $("#task_rd1").prop("checked", false);
    $("#task_txt1").val("");

    for (let i = 2; i <= tasks; i++) {
      $("#cont_task" + i).remove();
    }
  });
</script>
@endsection