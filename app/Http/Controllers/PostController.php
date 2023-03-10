<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function create(){
       $posts = Post::when(request('search'), function($posts){
                    $posts->where('title','like','%'.request('search').'%')
                            ->orWhere('description','like','%'.request('search').'%')
                            ->orWhere('address','like','%'.request('search').'%');
                })
                ->orderBy('id','desc')->paginate(4);
                

        // dd($posts);
       
        // Retrieving All Rows From A Table
        // $posts = Post::all();
        // $posts = DB::table('posts')->inRandomOrder()->get();
        //         dd($posts); 

        // Retrieve a single row/column from a table
        // $post = Post::where('address','yangon')->first()->toArray();
        // $post = Post::where('address','Yangon')->value('title'); //Extract a single value from a record using value()
        // $post = Post::find(3);
        //  $post = DB::table('posts')->get()->random(); 
        // $post = DB::table('posts')->oldest() ->first();
        // $post = Post::latest()->first();

        // Retrieving A List Of Column Values
        // $posts = Post::pluck('title'); //get array
        // $posts = Post::select('address','title')->get();
        // $posts = Post::select('title as post_title','address')->get()->toArray();

        //Group By and Having
        //  $posts = Post::select('address',DB::raw('count(address) as address_count'))
        //             ->groupBy('address')
        //             ->get()
        //             ->toArray();

        // $posts = DB::table("posts")->select('posts.*',DB::raw('count(posts.address) as address_count'),DB::raw('SUM(posts.price) as total_price'))
        //              ->groupBy('posts.address')
        //             ->get()
        //             ->toArray();

        // $posts = Post::select('rating',DB::raw('count(rating) as rating_count'),DB::raw('MAX(price) as max_price'))
        // ->groupBy('rating')
        // ->get()
        // ->toArray();
        
        // $posts = Post::select('rating')
        //         ->having('rating','<' ,3)
        //         ->groupBy('rating')
        //         ->latest()
        //         ->get()
        //         ->toArray();

        // Aggregate
        // $post = Post::sum('price');
        // $post = Post::where('rating',4)->avg('price');
        // $post = Post::where('address','Mandalay')->count();
        // $post = Post::where('rating',5)->min('price');



        //Determining If Records Exist
        // $posts = Post::where('address','Taung Thar')->exists();
        // $posts = Post::where('address','Taung Thar')->doesntExist();

        // whereBetween/ whereNotBetween/ orWhereBetween /orWhereNotBetween
        // $posts = Post::select('title','price')->whereBetween('price',[10000,15000])->get()->toArray(); // orWhereBetween

        // whereIn / whereNotIn / orWhereIn / orWhereNotIn
        // $posts = Post::whereNotIn('rating', [4,5])->get();


        //whereTime /whereDay / whereMonth / whereYear /whereDate 
        // $posts = Post::whereYear('created_at','2023')->get();


        // $posts = DB::table('posts')->get();
        // $posts = $posts->chunk(20)->toArray();

        //Skip and Take
        // $posts = DB::table('posts')->skip(10)->take(5)->get();//(start id-11 to 15 )
        // $posts = DB::table('posts')->offset(10)->limit(5)->get();//(start id-11 to 15 )

        // Collection's method
        //map each (same )=> if paginate => get only data ( can use get(), paginate())
        //through => if paginate => get data + pagination data ( cannot not use with get())

        // $posts = Post::get()->each(function($post){
        //     $post->title = strtoupper($post->title);
        //     $post->price = $post->price - 10000;
        //     return $post;
        // });

        // $posts = Post::paginate(5)->map(function($post){
        //     $post->title = strtoupper($post->title);
        //     $post->price = $post->price - 10000;
        //     return $post;
        // });
      

        // $posts = Post::paginate(5)->through(function($post){
        //     $post->title = strtoupper($post->title);
        //     $post->price = $post->price - 10000;
        //     return $post;
        // });

        //When
        // $posts = Post::when(request('search'), function($posts){
        //     $posts->where('title','like','%'.request('search').'%');
        // })
        // ->get();

        
       
        // $posts = Post::where('price','<',30000)->select('title','description')->get()->toArray(); 
        return view('post.create',compact('posts'));
    }
    public function store(Request $req){

        $this->checkValidationPost($req);

        $data = $this->getPostData($req);
        if($req->hasFile('postImage')){
            $file_name = $this->uploadImage($req);
            $data['image'] = $file_name;
        }
        // dd($data);
        Post::create($data);

       //return back(); // current page ( post create page)
       //return view('post.create'); // go to view page (can occur cause of data require to retrieve)
        //return redirect('post/create'); // use uri name
        return redirect()->route('post_create')->with(['message'=>'Post Successfully Created!']); // use route name
    }

    public function delete($id){

        // Post::where('id',$id)->delete();
        
        Post::find($id)->delete();


        // return redirect()->route('post_create'); 
        return back();
       
    }

    public function detail($id){
        $post = Post::find($id);
        return view('post.detail',compact('post'));
    }

    public function edit($id){
       $post = Post::where('id',$id)->first();
       return view('post.edit',compact('post'));
    }

    public function update(Request $req){
        $this->checkValidationPost($req);

        $new_data = $this->getPostData($req);

        if($req->hasFile('postImage')){
            //Delete Image
            $old_image = Post::where('id',$req->postId)->value('image');
            Storage::delete('public/MyImage/'.$old_image);
            
            //Uplaod New Image
            $file_name = $this->uploadImage($req);
            $new_data['image'] = $file_name;
        }

       
        Post::where('id',$req->postId)->update($new_data);
        return redirect()->route('post_create')->with(['message' => 'Post Successfully Updated!']);
    }
    private function getPostData($req){
        return [
            'title' => $req->postTitle,
            'description' => $req->postDescription,
            'address' =>$req->postAddress,
            'price' => $req->postPrice,
            'rating' => $req->postRating,
        ];
    }

    private function checkValidationPost($req){
        $validation_rule = [
            'postTitle' => 'required|unique:posts,title,'.$req->postId,
            'postDescription' => 'required',
            'postAddress' => 'required',
            'postRating' => 'required',
            'postPrice' => 'required',
            'postImage' => 'nullable|mimes:jpg,bmp,png,jpeg',
        ];
        $validation_custom_meessage = [
            'postTitle.required' => "Please fill post title",
            'postTitle.unique' => "Post title must be unique",
            'postDescription.required' => "Please fill post description",
        ];
        Validator::make($req->all(),$validation_rule,$validation_custom_meessage)->validate();
    }

    private function uploadImage($req){
        $file_name = uniqid().'_'.$req->file('postImage')->getClientOriginalName();
        $req->file('postImage')->storeAs('public/MyImage',$file_name);
        return $file_name;
    }
}
