@extends('layouts.app')
@section('title','Edit User Profile')
@section('content')
    <div class="container" style="margin-top: 30px;">
        <div class="row flex-lg-nowrap">
       
          <div class="col">
            <div class="row">
              <div class="col mb-3">
                <div class="card">
                  <div class="card-body">
                    <div class="e-profile">
                    
                  
                      <div class="tab-content pt-3">
                        <div class="tab-pane active">
                          <form class="form" method="POST" action="{{route('profile.update',$user->id)}}" enctype="multipart/form-data">
                        
                            @csrf
                            @method('PUT')
                            <div class="mb-2"><b>Change Parsonal Informations</b></div>
                            @if (session('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                 {{session('message')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                             
                            @endif 
                            <div class="row">
                              <div class="col">
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group">
                                      <label>Full Name</label>
                                      <input class="form-control" type="text" value="{{$user->name}}" name="name" >
                                      @error('name')
                                      <small class="form-text text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                  </div>
                               
                                </div>
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group">
                                      <label>Email</label>
                                      <input class="form-control" name="email" value="{{$user->email}}" type="text" >
                                      @error('email')
                                      <small class="form-text text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label>Image</label>
                                        <input class="form-control" name="image"  type="file" >
                                        @error('image')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                                <div class="row">
                                  <div class="col mb-3">
                                    <div class="form-group">
                                      <label>About</label>
                                      <textarea class="form-control" name="bio" rows="5" placeholder="My Bio">{{$user->userProfile->bio ?? ''}}</textarea>
                                      @error('bio')
                                      <small class="form-text text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                       
                            <div class="row">
                              <div class="col d-flex justify-content-end">
                               
                                <button class="btn btn-primary" style="margin-left: 5px;" type="submit">Save Changes</button>

                              </div>
                            </div>
                          </form>
                          <form class="form" method="POST" action="{{route('change.password')}}" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-2"><b>Change Password</b></div>
                            @if (session('error'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                 {{session('error')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                             
                            @endif 
                            <div class="row">
                              <div class="col">
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group">
                                      <label>Current Password</label>
                                      <input class="form-control" type="password"  name="current_password" >
                                      @error('current_password')
                                      <small class="form-text text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                  </div>
                               
                                </div>
                                <div class="row">
                                  <div class="col">
                                    <div class="form-group">
                                      <label>password</label>
                                      <input class="form-control" name="password"  type="password" >
                                      @error('password')
                                      <small class="form-text text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input class="form-control" name="password_confirmation"  type="password" >
                                        @error('password_confirmation')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                              
                              </div>
                            </div>
                       
                            <div class="row">
                              <div class="col d-flex justify-content-end mt-2">
                               
                                <button class="btn btn-primary" style="margin-left: 5px;" type="submit">Change Password</button>

                              </div>
                            </div>
                          </form>
        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
        
           
            </div>
        
          </div>
        </div>
    </div>
@endsection
