<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Models\Users\Subjects;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use Illuminate\Validation\Rule;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        $categories = MainCategory::get();
        $like = new Like;
        $post_comment = new Post;
        $subjects = Subjects::all();
        $query = Post::with('user', 'postComments')->withCount(['likes', 'postComments']);
        if (!empty($request->subject_id)) {
            $subjectId = $request->subject_id;
            $query->whereHas('user.subjects', function($q) use ($subjectId) {
                $q->where('subject_id', $subjectId);
            });
        }
        if (!empty($request->keyword)) {
            $subCategory = SubCategory::where('sub_category', $request->keyword)->first();
            if ($subCategory) {
                $query->whereHas('subCategories', function($q) use ($subCategory) {
                    $q->where('sub_category_id', $subCategory->id);
                });
            } else {
                $query->where(function($q) use ($request) {
                    $q->where('post_title', 'like', '%' . $request->keyword . '%')
                      ->orWhere('post', 'like', '%' . $request->keyword . '%');
                });
            }
        }
        else if ($request->like_posts) {
            $likePostIds = Auth::user()->likePostId()->pluck('like_post_id')->toArray();
            $query->whereIn('id', $likePostIds);
        }
        else if ($request->my_posts) {
            $query->where('user_id', Auth::id());
        }
        else if ($request->sub_category_word) {
            $subCategory = SubCategory::where('sub_category', $request->sub_category_word)->first();
            if ($subCategory) {
                $query->whereHas('subCategories', function($q) use ($subCategory) {
                    $q->where('sub_category_id', $subCategory->id);
                });
            }
        }
        $posts = $query->get();
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment', 'subjects'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        return view('authenticated.bulletinboard.post_create', compact('main_categories'));
    }

    public function postCreate(Request $request){
        $request->validate([
            'post_category_id' => ['required', 'integer', Rule::exists('sub_categories', 'id')],
            'post_title' => ['required', 'string', 'max:100'],
            'post_body' => ['required', 'string', 'max:2000'],
        ]);

        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        $post->subCategories()->attach($request->post_category_id);
        return redirect()->route('post.show');
    }

    public function postEdit(Request $request)
    {
    $request->validate([
        'post_id' => ['required', 'integer', 'exists:posts,id'],
        'post_category_id' => ['required', 'integer', Rule::exists('sub_categories', 'id')],
        'post_title' => ['required', 'string', 'max:100'],
        'post_body' => ['required', 'string', 'max:2000'],
    ]);
    $post = Post::findOrFail($request->post_id);
    if ($post->user_id !== Auth::id()) {
        return redirect()->route('post.detail', ['id' => $post->id])
                         ->withErrors('この投稿を編集する権限がありません。');
    }
    $post->update([
        'post_title' => $request->post_title,
        'post' => $request->post_body,
    ]);
    $post->subCategories()->sync([$request->post_category_id]);
    return redirect()->route('post.detail', ['id' => $post->id])
                     ->with('message', '投稿を更新しました。');
    }


    public function destroy($id){
        $post = Post::findOrFail($id);
        if ($post->user_id !== Auth::id()) {
            return redirect()->route('post.detail', ['id' => $post->id])
                             ->withErrors('この投稿を削除する権限がありません。');
        }
        $post->delete();
        return redirect()->route('post.show')
                         ->with('message', '投稿を削除しました。');
    }

    public function mainCategoryCreate(Request $request){
        $request->validate([
            'main_category_name' => 'required|string|max:100|unique:main_categories,main_category',
        ]);

        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        $request->validate([
            'comment' => ['required', 'string', 'max:250'],
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ]);
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->like_user_id = $user_id;
        $like->like_post_id = $post_id;
        $like->save();

        return response()->json();
    }

    public function postUnLike(Request $request){
        $user_id = Auth::id();
        $post_id = $request->post_id;

        $like = new Like;

        $like->where('like_user_id', $user_id)
             ->where('like_post_id', $post_id)
             ->delete();

        return response()->json();
    }

    public function subCategoryCreate(Request $request)
    {
        $request->validate([
            'main_category_id' => ['required', 'integer', Rule::exists('main_categories', 'id')],
            'sub_category_name' => ['required', 'string', 'max:100', Rule::unique('sub_categories', 'sub_category')],
        ]);

        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category' => $request->sub_category_name,
        ]);

        return redirect()->back()->with('message', 'サブカテゴリーを追加しました。');
    }
}
