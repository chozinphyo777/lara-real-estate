@extends('layout.master')
@section('content')
    <div class="container">
        <div class="row mt-5">
             <div class="col-md-5">
                {{-- @dd(request()->query()) --}}
                <div class="m-3">
                    {{-- Success Message  --}}
                    @if(session('message'))
                        <div class="alert alert-success alert-dismissible">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <strong>{{ session('message') }}</strong> 
                    </div>
                    @endif

                    {{-- Validation Error all Message --}}
                    {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif --}}
                      
                    {{-- <form action="{{ route('post_store')}}" method="post"> --}}
                     <form action="{{ url('post/store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">Post Title</label>
                            <input type="text" class="form-control @error('postTitle') is-invalid @enderror" name="postTitle" value="{{ old('postTitle') }}" placeholder="Enter Post Title">
                            @error('postTitle')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                              </div>
                            @enderror
                            
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Description</label>

                            <textarea name="postDescription" class="form-control @error('postDescription') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Description">{{ old('postDescription') }}</textarea>
                            @error('postDescription')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Price</label>
                            <input type="number" class="form-control @error('postPrice') is-invalid @enderror" name="postPrice" value="{{ old('postPrice') }}" placeholder="Enter Post Price">
                            @error('postPrice')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                              </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Location</label>
                            <input type="text" class="form-control @error('postAddress') is-invalid @enderror" name="postAddress" value="{{ old('postAddress') }}" placeholder="Enter Post Address">
                            @error('postAddress')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                              </div>
                            @enderror
                        </div>
                        
                        <div class="form-group mb-3">
                            <label for="">Rating</label>
                            <input type="number" min="0" max="5" class="form-control @error('postRating') is-invalid @enderror" name="postRating" value="{{ old('postRating') }}" placeholder="Enter Post Rating">
                            @error('postRating')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                              </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Image</label>
                            <input type="file" min="0" max="5" class="form-control @error('postImage') is-invalid @enderror" name="postImage" value="{{ old('postImage') }}" placeholder="Enter Post Image">
                            @error('postImage')
                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                {{ $message }}
                              </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="submit" class=" btn btn-success" value="Create">
                        </div>
                    </form>
                </div>
               
             </div>
             <div class="col-md-7">
                <div class="m-3">
                    <div class="d-flex justify-content-between mb-2">
                        <div>Total News : {{$posts->total()}}</div>
                        <form action="{{url('post/create')}}" >
                            <div class="input-group">
                                <input type="text" name="search" value="{{request('search')}}"  class="form-control" id=""></a>
                                <button class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                            
                        </form>
                       
                    </div>
                    @forelse($posts as $post)
                        <div class="shadow-sm p-3 mb-4 bg-white">
                            <div class="d-flex justify-content-between">
                                <h5 class="">{{$post->title}}</h5>
                                <div class="text-muted"><small>{{Carbon\Carbon::parse($post['created_at'])->format('Y-m-d H:i:s') }}</small></div>
                            </div>
                            <p class="text-muted">{{Str::words($post['description'],30,"...")}}</p>
                                   
                            <div class="text-end d-flex justify-content-between">
                                <div class="d-flex">
                                    <div class="pe-2 "><i class="fa-solid fa-money-check-dollar text-primary"></i> {{$post->price}} |</div>
                                    <div class="pe-2"><i class="fa-solid fa-location-dot text-primary text-danger "></i> {{$post->address}} | </div>
                                    <div class="pe-2"><i class="fa-solid fa-star  text-warning"></i> {{$post->rating}} </div>
                                </div>
                                <div class="d-flex">
                                    <a href="{{ route('post_detail',$post['id']) }}" class="btn btn-sm btn-primary mx-2"><i class="fa fa-more"></i></a>
    
                                    <a href="{{ route('post_edit',$post['id']) }}" class="btn btn-sm btn-success mx-2"><i class="fa fa-edit"></i></a>
    
                                    {{-- <a href="{{ url('post/delete/'.$post['id'])}}" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a> --}}
                                
                                    <form action="{{ url('post/delete/'.$post['id'])}}" method="post">
                                        @csrf
                                        @method('delete')
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                    <div class="text-center mt-5 text-danger h2">There is no post</div>
                    @endforelse
               
                  
                    {{-- Use For Loop --}}

                    {{-- @for($i=0; $i< count($posts); $i++)
                        <div class="shadow-sm p-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="">{{$posts[$i]['title']}}</h5>
                                <div class="text-muted"><small>{{Carbon\Carbon::parse($posts[$i]['created_at'])->format('Y-m-d H:i:s') }}</small></div>
                            </div>

                            <p class="text-muted">{{Str::words($posts[$i]['description'],30,"...")}}</p>

                            <div class="text-end">
                              <a href="{{ url('post/delete/'.$posts[$i]['id'])}}" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></a>

                              <button class="btn btn-sm btn-success"><i class="fa fa-more"></i></button>
                            </div>
                        </div>
                    @endfor --}}
                    {{-- {{ $posts->links()}} --}}
                    {{-- {{ $posts->appends(Request::except('page'))->links() }} --}}
                    {{  $posts->appends(request()->query())->links() }}
                </div>
                
            </div>
        </div>
    </div>
@endsection

    
