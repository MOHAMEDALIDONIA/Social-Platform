@extends('layouts.app')
@section('title','Edit Post')
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
                          <form class="form" method="POST" action="{{route('post.update',$post->id)}}" enctype="multipart/form-data">
                        
                            @csrf
                            @method('PUT')
                            <div class="mb-2"><b>Edit Post</b></div>
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
                                      <label>Content</label>
                                      <input class="form-control" type="text" value="{{$post->content}}" name="content" >
                                      @error('content')
                                      <small class="form-text text-danger">{{$message}}</small>
                                      @enderror
                                    </div>
                                  </div>
                               
                                </div>
                          
                                <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label>Image</label>
                                        <input class="form-control" name="image[]" multiple  type="file" >
                                        <div>
                                            @if($post->images)
                                            <div class="row">
                                                @foreach($post->images as $image)
                                                <div class="col-md-2">
                                                    <img src="{{ asset('storage/'.$image->image)}}" style="width:80px; height:80px;" class="me-4 border p-2" alt="img">
                                                    <a href="{{route('delete.post.image',$image->id)}}" class="d-block">Remove</a>
            
                                                </div>
                                                @endforeach
            
                                            </div>
                                             
                                         
                                       
                                            @else
                                             <h5>No Images Added</h5>
                                            @endif
                                        </div>
                                        @error('image')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                      </div>
                                    </div>
                                  </div>
                             
                              </div>
                            </div>
                       
                            <div class="row">
                              <div class="col d-flex justify-content-end mt-5">
                               
                                <button class="btn btn-success" style="margin-left: 5px;" type="submit">Save Changes</button>

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
