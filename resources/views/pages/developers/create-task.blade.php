@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Create a new Task')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/flag-icon/css/flag-icon.min.css')}}">
@endsection

{{-- page content --}}
@section('content')

<div class="section">
  <div class="row" >
    <div class="col s12">

      <div id="validations" class="card card-tabs">

        <div class="card-content">
            <div class="card-title">
                <div class="row center">
                    <div class="col s12">
                        <h5 class="center-align" style="font-weight: 900;">Create a New Task</h5>
                    </div>
                        @if(Session::has('message_success'))
                         <div >
                            <div class="card-alert card gradient-45deg-green-teal">
                                <div class="card-content white-text">
                                    <p>
                                    <i class="material-icons">check</i> {{Session::get('message_success') }}.
                                    </p>
                                </div>
                                <button type="button" class="close white-text" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                                </button>
                            </div>
                         </div>
                        @endif
                </div>
            </div>

            <form enctype="multipart/form-data" class="formValidate" action="{{ route('developers.create-task') }}" style="margin-bottom: 20px;" id="formSubmit" method="POST">
                @csrf

                <div class="row s12 right">
                   <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('developers.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Task List</a>
                </div>
                <div class="row"></div>
                <div id="details">
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="name">Subject</label>
                            <input name="task[subject]" type="text" value="{{old('task.subject')}}" required>
                            @error('task.subject')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col s12">
                            <label for="category_id">Category*</label>
                            <div class="input-field">
                                <select  name="task[category_id]" value="{{old('task[category_id')}}" required >
                                    <option value="">Select a Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == old('task[category_id')? 'selected' : '' }}>{{$category->name}}</option>
                                    	}
                                    @endforeach
                                </select>
                                @error('task[category_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="subcategory_id">Sub Category*</label>
                            <div class="input-field">
                                <select  name="task[subcategory_id]" value="{{old('task[subcategory_id')}}" required >
                                    <option value="">Select a Sub Category</option>
                                    @foreach ($sub_categories as $category)
                                        <option value="{{$category->id}}" {{$category->id == old('task[subcategory_id')? 'selected' : '' }}>{{$category->name}}</option>
                                    	}
                                    @endforeach
                                </select>
                                @error('task[subcategory_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <label for="developer_id">Assigned to*</label>
                            <div class="input-field">
                                <select  name="task[developer_id]" value="{{old('task[developer_id')}}" required >
                                    <option value="">Select a Developer</option>
                                    @foreach ($developers as $developer)
                                        <option value="{{$developer->id}}" {{$developer->id == old('task[developer_id')? 'selected' : '' }}>{{$developer->firstname . ' ' . $developer->lastname}}</option>
                                        }
                                    @endforeach
                                </select>
                                @error('task[developer_id')
                                    <small class="red-text">
                                        <p>{{ $message }}</p>
                                    </small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="description">Task's description</label>
                            <textarea class="materialize-textarea"  name="task[description]" type="text" required>{{old('task.description')}}</textarea>
                            @error('task.description')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <label for="usernote">Note / Comment</label>
                            <textarea class="materialize-textarea"  name="task[usernote]" type="text" >{{old('task.usernote')}}</textarea>
                            @error('task.usernote')
                                <small class="red-text">
                                    <p>{{ $message }}</p>
                                </small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row s12 right">
                   <button type="submit" class="mb-6 btn waves-effect waves-light gradient-45deg-green-teal" >Save </button>
                    <a href="{{ route('developers.index') }}" class="mb-6 btn waves-effect waves-light gradient-45deg-purple-deep-orange">Task List</a>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/form-validation.js')}}"></script>
<script src="{{asset('js/scripts/ui-alerts.js')}}"></script>
@endsection
