@extends('layout.master')
@section('content')
    <div class="col-md-6 offset-md-3 mt-5 bg-white p-5 shadow-sm">
        <a href="{{ URL::previous() }}" class="btn btn-sm btn-light text-decoration-none mb-3"><i class="fa-solid fa-arrow-left"></i> back</a>
        <div class="d-flex justify-content-between mb-md-3">
            <h5>{{$post->title}}</h5>
            <div class="text-muted"><small>{{$post->created_at->format("Y-m-d H:i:s")}}</small></div>
        </div>
        <div class="d-flex mb-md-3">
            <div class="pe-2 "><i class="fa-solid fa-money-check-dollar text-primary"></i> {{$post->price}} |</div>
            <div class="pe-2"><i class="fa-solid fa-location-dot text-primary text-danger "></i> {{$post->address}} | </div>
            <div class="pe-2"><i class="fa-solid fa-star  text-warning"></i> {{$post->rating}} </div>
        </div>
        
        @if($post->image == null)
             <img src="{{Storage::url('MyImage/404_image.jpeg')}}" style="width:600px; height:auto;" class="mb-md-3"> 
        @else
            <img src="{{Storage::url('MyImage/'.$post->image)}}" style="width:600px; height:auto;" class="mb-md-3"> 
        @endif

        
        {{-- <img src="{{asset('storage/MyImage/404_image.jpeg')}}" style="width:600px; height:auto;" class="mb-md-3">  --}}

        <p class="text-muted">
            {{$post->description}}
        </p>
       <div class="text-end">
         <a href="{{ route('post_edit', $post->id) }}" class="btn btn-primary">Edit</a>
       </div>
       
        
        
    </div>
@endsection