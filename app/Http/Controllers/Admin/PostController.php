<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogPostRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Auth;
use DataTables;
use DB;
use Illuminate\Support\Carbon;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.pages.posts.index');
    }

    public function create()
    {
        $categories = PostCategory::all()->sortByDesc('id');
        return view('admin.pages.posts.create', compact('categories'));
    }

    public function store(BlogPostRequest $request)
    {
        $data = $request->all();
        if (isset($data['is_featured'])) {
            $data['is_featured'] = 1;
        } else {
            $data['is_featured'] = 0;
        };
        $data['created_by'] = Auth::user()->id;
        $new_post = Post::create($data);

        if ($request->has('tags_string') && $request->tags_string != '') {
            $tag_list = explode('|', $request->tags_string);
            $new_post->attachTags($tag_list);
        }

        //update category
        if (!isset($data['categories'])) {
            $data['categories'] = [];
        }
        $this->updateCategory($new_post->id, $data['categories']);
        return redirect()->route('admin.post.index')->with('success', 'Tạo mới thành công tin đăng');
    }

    public function edit($id)
    {
        $post = Post::with('categories')->findOrFail($id);
        $categories = PostCategory::all()->sortByDesc('id');
        return view('admin.pages.posts.edit', compact('post', 'categories'));
    }

    public function update($id, BlogPostRequest $request)
    {
        $post = Post::findOrFail($id);
        $data = $request->all();
        if (isset($data['is_featured'])) {
            $data['is_featured'] = 1;
        } else {
            $data['is_featured'] = 0;
        };
        $post->update($data);

        if ($request->has('tags_string') && $request->tags_string != '') {
            $tag_list = explode('|', $request->tags_string);
            $post->syncTags($tag_list);
        }

        //update category
        if (!isset($data['categories'])) {
            $data['categories'] = [];
        }
        $this->updateCategory($post->id, $data['categories']);
        return redirect()->route('admin.post.index')->with('success', 'Cập nhật thành công khóa học');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Xóa thành công');
    }

    function list() {
        $posts = Post::with('author');

        return DataTables::eloquent($posts)
            ->addIndexColumn()
            ->editColumn('name', function ($post) {
                $url = route('customer.post.show', ['cat_slug' => $post->categories->first()->slug ?? 'danh-muc', 'post_slug' => $post->slug]);
                return "<a target='_blank' href='{$url}'>{$post->name} </a>";
            })
            ->editColumn('created_by', function ($post) {
                return $post->author->username ?? '';
            })
            ->editColumn('created_at', function ($post) {
                return Carbon::parse($post->created_at)->format('H:i:s d/m/Y');
            })
            ->editColumn('avatar', function ($post) {
                return '<img width="100%" src="' . \htmlspecialchars($post->thumb) . '" alt="">';
            })
            ->editColumn('status', function ($post) {
                switch ($post->status) {
                    case 1:
                        return '<span class="badge badge-success">Đang hoạt động</span>';
                    default:
                        return '<span class="badge badge-danger">Dừng hoạt động</span>';
                }

            })
            ->addColumn('action', function ($post) {
                return '
                <a data-toggle-for="tooltip" title="Sửa thông tin" href="' . route('admin.post.edit', $post->id) . '"class="btn text-info customer-edit"><i class="fas fa-edit" data-toggle="modal" data-target="#customer-model"></i></a>
                <a data-toggle-for="tooltip" title="Xóa" href="' . route('admin.post.destroy', $post->id) . '"class="btn text-danger customer-edit"><i class="fas fa-trash" data-toggle="modal" data-target="#customer-model"></i></a>
                ';
            })
            ->rawColumns(['action', 'avatar', 'status', 'name'])
            ->make(true);
    }

    private function updateCategory($post_id, $categories)
    {

        DB::table('post_to_category')->where('post_id', $post_id)->delete();
        foreach ($categories as $category) {
            DB::table('post_to_category')->insert([
                'post_id' => $post_id,
                'category_id' => $category,
            ]);
        }
    }

}