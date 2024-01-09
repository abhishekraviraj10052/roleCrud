@extends('layout.layout')

@section('content')
  <a href="{{route('dashboard')}}" class="btn btn-success">Back</a>
  <h2>Create User</h2>
  @if(!isset($user))
  <form action="{{route('user-insert')}}" method="POST">
  @else
  <form action="{{route('user-update')}}" method="POST">
  @endif
    @csrf
    @error('firstname')
    {{$message}}
    @enderror
    <div class="mb-3 mt-3">
      <input type="hidden" name="id" value="{{$user->id ?? ''}}">
      <input type="text" class="form-control" id="firstname" placeholder="Enter firstname" name="firstname" value="{{old('firstname') ?? $user->firstname  ?? ''}}">
    </div>
    @error('lastname')
    {{$message}}
    @enderror
    <div class="mb-3 mt-3">
      <input type="text" class="form-control" id="lastname" placeholder="Enter lastname" name="lastname" value="{{old('lastname') ?? $user->lastname ?? ''}}">
    </div>
    @error('email')
    {{$message}}
    @enderror
    <div class="mb-3 mt-3">
      <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" value="{{old('email') ?? $user->email ?? ''}}">
    </div>
    @error('number')
    {{$message}}
    @enderror
    <div class="mb-3 mt-3">
      <input type="text" class="form-control" id="number" placeholder="Enter number" name="number" value="{{old('number') ?? $user->number ?? ''}}">
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