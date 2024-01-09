@extends('layout.layout')

@section('content')
@if(Session('success'))
<span class="alert alert-success">{{Session('success')}}</span>
@endif
@if(Auth::user()->role == 1 || Auth::user()->role == 2)
<div class="container mt4">
  <form action="{{route('user-search')}}">
    <div class="form-group d-flex">
      <input type="text" class="form-control" name="firstname" placeholder="Enter firstname">
      <input type="text" class="form-control" name="lastname" placeholder="Enter lastname">
      <input type="text" class="form-control" name="email" placeholder="Enter email">
      <input type="text" class="form-control" name="number" placeholder="Enter number">
      <button type="submit" class="btn btn-success">Search</button>
      <button type="button" class="btn btn-success" id="reset">Reset</button>
    </div>
  </form>
</div>
<a href="{{route('user-create')}}" class="btn btn-success mt-4">Create New User</a>
@endif
<a href="{{route('user-logout')}}" class="btn btn-danger mt-4">Log Out</a>

  <table class="table table-dark mt-2 text-center">
    <thead>
      <tr>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Number</th>
        <th>Role</th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>
        <th><a href="{{route('user-logout')}}" class="btn btn-danger">Log Out</a></th>
      </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
      <tr>
        <td>{{$user->firstname}}</td>
        <td>{{$user->lastname}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->number}}</td>
        <td>{{$user->role}}</td>
        <td>{{$user->status}}</td>
        <td><a href="{{route('user-create',$user->id)}}" class="btn btn-success">Edit</a></td>
        <td><a href="{{route('user-delete',$user->id)}}" class="btn btn-danger">Delete</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>
@endsection
@push('script')
<script>
$(document).ready(function(){
  $('#reset').click(function(){
    window.location.href="{{route('dashboard')}}"
  })
})
</script>
@endpush