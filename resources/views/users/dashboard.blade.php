@extends('layout.layout')

@section('content')
@php
$order=$_GET['order'] ?? 'asc';
$url='/user/dashboard?';

$firstname=$_GET['firstname'] ?? '';
$lastname=$_GET['lastname'] ?? '';
$email=$_GET['email'] ?? '';
$number=$_GET['number'] ?? '';

if($firstname != ''){
  $url .= 'firstname='.$firstname.'&';
}
if($lastname != ''){
  $url .= 'lastname='.$lastname.'&';
}
if($email != ''){
  $url .= 'email='.$email.'&';
}
if($number != ''){
  $url .= 'number='.$number.'&';
}
  

@endphp
@if(Session('success'))
<span class="alert alert-success">{{Session('success')}}</span>
@endif
@if(Auth::user()->role == 1 || Auth::user()->role == 2)
<div class="container mt4">
  <form action="">
    <div class="form-group d-flex">
      <input type="text" class="form-control" name="firstname" placeholder="Enter firstname" value="{{$firstname}}">
      <input type="text" class="form-control" name="lastname" placeholder="Enter lastname" value="{{$lastname}}">
      <input type="text" class="form-control" name="email" placeholder="Enter email" value="{{$email}}">
      <input type="text" class="form-control" name="number" placeholder="Enter number" value="{{$number}}">
      <input type="hidden" name="order_by" value="{{$order_by ?? 'firstname'}}">
      <input type="hidden" name="order" value="{{$order ?? 'asc'}}">
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
        <th>Firstname&nbsp<a href="{{$url}}order_by=firstname&order=asc">asc</a>&nbsp<a href="{{$url}}order_by=firstname&order=desc">desc</a></th>
        <th>Lastname&nbsp<a href="{{$url}}order_by=lastname&order=asc">asc</a>&nbsp<a href="{{$url}}order_by=lastname&order=desc">desc</a></th>
        <th>Email&nbsp<a href="{{$url}}order_by=email&order=asc">asc</a>&nbsp<a href="{{$url}}order_by=email&order=desc">desc</a></th>
        <th>Number&nbsp<a href="{{$url}}order_by=number&order=asc">asc</a>&nbsp<a href="{{$url}}order_by=number&order=desc">desc</a></th>
        <th>Role</th>
        <th>Status</th>
        <th>Edit</th>
        <th>Delete</th>
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
  {{$users->links()}}
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
@push('style')
<!-- <style>
  a{
    text-decoration:none;
    color:#fff;
  }
</style> -->
@endpush