<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Posts;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private $post;
    private $comments;
    private $like;

    public function __construct(Posts $post,Comments $comments,Likes $likes)
    {
        $this->post=$post;
        $this->comments=$comments;
        $this->like=$likes;
    }
    public function createPost(Request $request){
        try{
            DB::beginTransaction();
            $post=$this->post->createPost($request);
            DB::commit();
            return $post;
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json($e->getMessage(),500);
        }
    }
}
