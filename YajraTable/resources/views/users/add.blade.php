@extends('layouts.app')
@section('content')

<div class="page-content">
<div class="container-fluid">

<div class="row">
<div class="col-12">
    <div class="card">
        <div class="card-body">

            <h4 class="card-title">Add User </h4><br><br>
            <form id="myForm" method="post" action="{{route('store.user')}}">
                    @csrf

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">User Name</label>
                    <div class="form-group col-sm-10">
                        <input name="name" type="text" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                    <div class="form-group col-sm-10">
                        <input name="email" type="text" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus >
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Birth Date</label>
                    <div class="form-group col-sm-10">
                        <input name="birth_date" type="date" id="birth_date" class="form-control @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>
                        @error('birth_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                    <div class="form-group col-sm-10">
                        <input name="title" type="text" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required autocomplete="title" autofocus>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="example-text-input" class="col-sm-2 col-form-label">Password</label>
                    <div class="form-group col-sm-10">
                        <input name="password" type="password" id="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" required autocomplete="password" autofocus>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                
                
                <!-- end row -->

                <input type="submit" class="btn btn-info waves-effect waves-light" value="Add User">

            </form>  
        </div>
    </div>
</div> <!-- end col -->
</div>
 


</div>
</div>
 
@endsection 
