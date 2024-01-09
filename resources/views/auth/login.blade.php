@extends('layout.layout')

@section('content')
  @if(Session('success'))
  <span class="alert alert-danger">{{Session('success')}}</span>
  @endif
  <h2 class="mt-4">Login Here</h2>
  <form action="{{route('login')}}" method="POST">
    @csrf
    @error('email')
    {{$message}}
    @enderror
    <div class="mb-3 mt-3">
      <input type="text" class="form-control" id="email" placeholder="Enter email or phone" name="email">
    </div>
    @error('password')
    {{$message}}
    @enderror
    <div class="mb-3">
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
  </form>
@endsection