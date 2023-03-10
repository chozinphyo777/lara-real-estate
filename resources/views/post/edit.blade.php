@extends('layout.master')
@section('content')
    <div class="col-md-6 offset-md-3 mt-md-5">
        <a href="{{  route('post_create') }}" class="btn btn-sm btn-light mb-3"><i class="fa-solid fa-arrow-left"></i> back</a>
        <form action="{{ route('post_update')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="postId" value={{$post->id}}>
            <div class="form-group mb-3">
                <label for="">Post Title</label>
                <input type="text" class=" form-control @error('postTitle') is-invalid @enderror" value="{{old('postTitle',$post->title)}}" name="postTitle" placeholder="Enter Post Title">
                @error('postTitle')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Description</label>
                <textarea name="postDescription" class=" form-control @error('postDescription') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Description">{{ old('postDescription',$post->description) }}</textarea>
                @error('postDescription')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Price</label>
                <input type="number" class="form-control @error('postPrice') is-invalid @enderror" name="postPrice" value="{{ old('postPrice', $post->price) }}" placeholder="Enter Post Price">
                @error('postPrice')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="">Location</label>
                <input type="text" class="form-control @error('postAddress') is-invalid @enderror" name="postAddress" value="{{ old('postAddress',$post->address) }}" placeholder="Enter Post Address">
                @error('postAddress')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            
            <div class="form-group mb-3">
                <label for="">Rating</label>
                <input type="number" min="0" max="5" class="form-control @error('postRating') is-invalid @enderror" name="postRating" value="{{ old('postRating',$post->rating) }}" placeholder="Enter Post Rating">
                @error('postRating')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            <div>
                @if($post->image == null)
                <img src="{{Storage::url('MyImage/404_image.jpeg')}}" style="width:600px; height:auto;" class="mb-md-3"> 
                @else
                    <img src="{{Storage::url('MyImage/'.$post->image)}}" style="width:600px; height:auto;" class="mb-md-3"> 
                @endif
            </div>
            <div class="form-group mb-3">
                <label for="">Image</label>
                <input type="file" min="0" max="5" class="form-control @error('postImage') is-invalid @enderror" name="postImage" value="{{ old('postImage') }}" >
                @error('postImage')
                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
            </div>
            <div class="form-group text-end">
                <input type="submit" class=" btn btn-success" value="Update">
            </div>
        </form>
    </div>
@endsection