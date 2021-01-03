<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Spatie\Tags\Tag;

class PostController extends Controller
{
    public function show($cat_slug, $post_slug)
    {

        $post = Post::where('slug', $post_slug)->with('tags', 'categories', 'categories.posts', 'categories.posts.categories')->first();
        if (!$post) {
            return abort(404);
        }
        $created_at = $post->created_at;

        $date_string = __($created_at->format('l')) . ', ngày ' . $created_at->format('d/m/Y g:i A');
        // $post_categories = PostCategory::take(10)->get();
        $curent_category = $post->categories->first();
        $related_post = $curent_category->posts->take(5) ?? [];
        $weekly_news = Post::with('categories')->where('is_featured', 1)->orderByDesc('id')->take(5)->get();

        return view('customer.pages.posts.show', compact('post', 'date_string', 'related_post', 'weekly_news'));
    }

    public function index()
    {
        $posts = Post::orderByDesc('id')->paginate(9);
        $post_categories = PostCategory::with('posts', 'posts.tags')->take(10)->get();
        $featured_posts = Post::with('categories')->take(7)->get();

        return view('customer.pages.posts.index', compact('posts', 'post_categories', 'featured_posts'));
    }

    public function showByCategory($slug)
    {
        $category = PostCategory::where('slug', $slug)->first();
        if (!$category) {
            return abort(404);
        }
        $posts = $category->getPostRecursion()->paginate(12);
        $post_categories = PostCategory::take(10)->get();
        return view('customer.pages.posts.list_by_category', compact('posts', 'post_categories', 'category'));
    }

    public function getPostByTag($slug)
    {
        $tag = Tag::where('slug->vi', $slug)->first();
        if (!$tag) {
            return abort(404);
        }
        $posts = Post::withAnyTags([$tag->name], 'post')->paginate(9);
        return view('customer.pages.posts.list_by_tag', compact('posts', 'tag'));
    }
}