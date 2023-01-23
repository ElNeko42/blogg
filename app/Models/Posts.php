<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Comments;
use Carbon\Carbon;

class Posts extends Model
{
    use HasFactory;
    protected $fillable =[
        'image_path',
        'description',
        'date_post',
        'user_id',
    ];
    protected $appends = ['countcomments','countlikes'];

    public function getCountCommentsAttribute(){
        return $this->comments->count();
    }

    public function getCountLikesAttribute(){
        return $this->likes->count();
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comments::class,'post_id');
    }
    public function likes(){
        return $this->hasMany(Likes::class,'post_id');
    }
    public static function createPost(Request $request){
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $url = null;

        $storage = Storage::disk('public')->put($name, $file);
        $url = asset('storage/'.$storage);

        $post = (new static)::create([
            'image_path' => $url,
            'description' => $request->textpost,
            'user_id' => Auth::id(),
            //'date_posts' => Carbon::now(),
        ]);

        return (new static)::with([
            'user',
            'likes',
            'comments'
        ])->find($post->id);
    }
}
