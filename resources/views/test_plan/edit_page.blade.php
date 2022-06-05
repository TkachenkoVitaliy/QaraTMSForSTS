@extends('layout.base_layout')

@section('content')

    @include('layout.sidebar_nav')

    <div class="col">

        <div class="border-bottom my-3 d-flex justify-content-between">

            <h3 class="page_title">
                Edit Test Plan
                <i class="bi bi-arrow-right-short text-muted"></i>
                {{$testPlan->title}}
            </h3>

            <form method="POST" action={{route("test_plan_delete")}}>
                @csrf
                <input type="hidden" name="project_id" value="{{$project->id}}">
                <input type="hidden" name="id" value="{{$testPlan->id}}">
                <button type="submit" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash3"></i>
                    Delete
                </button>
            </form>

        </div>


        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row m-0">

            <div class="col-4 base_block p-3 shadow" style="margin-right: 10px;" >

                <form action="{{route('test_plan_update')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="project_id" value="{{$project->id}}">
                    <input type="hidden" name="id" value="{{$testPlan->id}}">

                    <input type="hidden" name="data" id="test_plan_data" value="{{$testPlan->data}}">

                    <div class="mb-3">
                        <label for="title" class="form-label">Name</label>
                        <input type="text" class="form-control" name="title" required value="{{$testPlan->title}}" maxlength="100">
                    </div>

                    <div class="mb-3">

                        <label for="test_suite_id" class="form-label">Test Repository</label>
                        <select name="repository_id" id="plan_repository_select" class="form-select" onchange="renderPlanTree(this)" required>
                            <option disabled selected value> ----- </option>

                            @foreach($repositories as $repository)
                                <option value="{{$repository->id}}"

                                    @if($repository->id == $testPlan->repository_id)
                                        selected
                                    @endif

                                >
                                    {{$repository->title}}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" maxlength="255" rows="7">{{$testPlan->description}}</textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-warning w-100"><b>Update</b></button>
                    </div>

                </form>

            </div>


            <div class="col p-3 shadow base_block" >

                <div class="border-bottom position-static d-flex justify-content-between">
                    <h3>Select Test Cases</h3>

                    <div>
                        <button href="button" class="btn btn-outline-link" onclick="selectAllTestPlanCases()">
                            <i class="bi bi-check-all"></i> Select All
                        </button>

                        <button href="button" class="btn btn-outline-link" onclick="deselectAllTestPlanCases()">
                            <i class="bi bi-x-lg"></i> Deselect All
                        </button>
                    </div>

                </div>


                <div id="tree" style="min-height: 75vh; max-height: 75vh; overflow-y: scroll; margin-top: 10px;">
                    @include('test_plan.tree')
                </div>

            </div>

        </div>

    </div>



@endsection


@section('footer')
    <script src="{{asset('js/test_plan_page.js')}}"></script>

    <script>
        $( document ).ready(function() {


            {{--// Отметить все выбранные тест кейсы, чекбоксы--}}

            const testCasesIdsArray = $("#test_plan_data").val().split(",");
            testCasesIdsArray.forEach( (id) => {
                $(`.test_case_cbx[data-test_case_id='${id}']`).click(); //prop('checked', true);
            });

        });
    </script>

@endsection