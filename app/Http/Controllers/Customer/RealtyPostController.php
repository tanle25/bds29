<?php

namespace App\Http\Controllers\Customer;

use DB;

use Datatables;
use App\Models\User;
use App\Models\Realty;
use App\Models\Commune;
use App\Models\Project;
use App\Models\District;
use App\Models\PostRank;
use App\Models\Province;
use App\Models\RealtyPost;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\SlugService;
use Illuminate\Support\Carbon;
use App\Services\FilterService;
use App\Helpers\RealtySlugHelper;
use App\Models\RealtyPostPayment;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\RelatedRealtyService;
use App\Http\Requests\RealtyPostRequest;

class RealtyPostController extends Controller
{
    public function __construct(
        SlugService $slug_service,
        FilterService $filter_service,
        RealtySlugHelper $realty_slug_helper,
        RelatedRealtyService $related_realty_service
    ) {

        $this->slug_service = $slug_service;
        $this->slug_service->setModel(RealtyPost::class);
        $this->filter_service = $filter_service;
        $this->realty_slug_helper = $realty_slug_helper;

        $this->related_realty_service = $related_realty_service;
    }

    public function showForm()
    {
        if (!empty(config('constant.provinces'))) {
            $provinces = Province::whereIn('code', config('constant.provinces'))->get();
        } else {
            $provinces = Province::orderBy('slug')->get();
        }
        $post_ranks = PostRank::select('*')->groupBy('rank_code')->get()->sortBy('rank_code');

        return view('customer.pages.user_profile.create_post', compact('provinces', 'post_ranks'));
    }

    function list()
    {
        $posts = RealtyPost::with('realty')->where('status',3)->orderByDesc('realty_posts.id');
        return DataTables::eloquent($posts)
            ->addIndexColumn()
            ->addColumn('realty_type', function ($post) {
                switch ($post->realty->type) {
                    case '1':
                        return 'Chung cư/Căn hộ';
                    case '2':
                        return 'Nhà riêng';
                    case '3':
                        return 'Đất nền';
                    default:
                        return 'Nhà riêng';
                };
            })
            ->editColumn('created_at', function ($post) {
                return Carbon::parse($post->created_at)->format('d/m/Y');
            })
            ->editColumn('type', function ($post) {
                switch ($post->type) {
                    case '1':
                        return 'Bán';
                    case '2':
                        return 'Cho thuê';
                    default:
                        return 'Bán';
                }
            })

            ->addColumn('thumb', function ($post) {
                return '<img width="100%" src="' . \htmlspecialchars($post->thumb) . '" alt="">';
            })
            ->editColumn('status', function ($post) {
                switch ($post->status) {
                    case 1:
                        return '<span class="badge badge-success">Đã duyệt</span>';
                    default:
                        return '<span class="badge badge-danger">Chưa duyệt</span>';
                }
            })
            ->addColumn('action', function ($post) {
                return '
                <a data-toggle-for="tooltip" title="Sửa thông tin" href="' . route('admin.realty_post.edit', $post->id) . '"class="btn text-info customer-edit"><i class="fas fa-edit" data-toggle="modal" data-target="#customer-model"></i></a>
                <a data-toggle-for="tooltip" title="Xóa" href="' . route('admin.realty_post.destroy', $post->id) . '"class="btn text-danger customer-edit"><i class="fas fa-trash" data-toggle="modal" data-target="#customer-model"></i></a>
                ';
            })
            ->rawColumns(['action', 'avatar', 'status', 'name'])
            ->make(true);
    }

    public function store(RealtyPostRequest $request)
    {
        // store realty
        // dd($request->all());
        // if( !$request->session()->has('realty')){
            $commune = Commune::where('code', $request->commune)->first();
            $new_realty = Realty::create([
                'type' => $request->realty_type,
                'province_code' => $request->province,
                'district_code' => $request->district,
                'commune_code' => $request->commune,
                'street' => $request->street,
                'direction' => $request->direction,
                'number_of_bed_rooms' => $request->number_of_bed_rooms,
                'number_of_bath_rooms' => $request->number_of_bath_rooms,
                'number_of_floors' => $request->number_of_floors,
                'area' => $request->area,
                'description' => $request->description,
                'house_image' => $request->house_image,
                'house_design_image' => $request->house_design_image,
                'apartment_number' => $request->apartment_number,
                'full_address' => 'Số nhà' . $request->apartment_number . ", " . $request->street . ", " . $commune->path_with_type,
                'google_map_lat' => $request->google_map_lat,
                'google_map_lng' => $request->google_map_lng,
                'project_id' => $request->project_id,
    
            ]);
            // $request->session()->flash('realty', $new_realty);
            // store realty post
            $open_at = Carbon::createFromFormat('d/m/Y', $request->open_at);
            $close_at = Carbon::createFromFormat('d/m/Y', $request->close_at);
            $slug = $this->slug_service->getSlug($request->title);
            $new_realty_post = RealtyPost::create([
                'title' => $request->title,
                'slug' => $slug,
                'type' => $request->realty_post_type,
                'price' => $request->price,
                'price_type' => $request->price_type,
                'description' => $request->description,
                'realty_id' => $new_realty->id,
                'contact_name' => $request->contact_name,
                'contact_phone_number' => $request->contact_phone_number,
                'contact_email' => $request->contact_email,
                'contact_address' => $request->contact_address,
                'rank' => $request->realty_post_rank,
                'open_at' => $open_at->format('Y-m-d H:i:s'),
                'close_at' => $close_at->format('Y-m-d H:i:s'),
                'created_by' => auth()->user()->id ?? null,
            ]);
    
            $house_images = array_filter(explode(',',$request->house_image));
            $design_images = array_filter(explode(',',$request->house_design_image));
            foreach ($house_images as $key => $image) {
                # code...
                $new_realty_post->images()->create([
                    'type'=>1,
                    'link'=>$image,
                    'alt'=>isset($request->house_image_alt[$key])  ? $request->house_image_alt[$key] : $request->title,
                    'title'=>isset($request->house_image_title[$key])  ? $request->house_image_title[$key] : $request->title
                ]);
            }
            foreach ($design_images as $key => $image) {
                # code...
                $new_realty_post->images()->create([
                    'type'=>2,
                    'link'=>$image,
                    'alt'=>isset($request->house_design_image_alt[$key])  ? $request->house_design_image_alt[$key] : $request->title,
                    'title'=>isset($request->house_design_image_title[$key])  ? $request->house_design_image_title[$key] : $request->title
                ]);
            }
            $post_rank = PostRank::where('rank_code', $request->realty_post_rank)->first();
            $duration = $close_at->diffInDays($open_at);
    
            $wallet = auth()->user()->wallet;
            $new_payment = new RealtyPostPayment;
            $new_payment->realty_post_id = $new_realty_post->id;
            $new_payment->post_rank = $new_realty_post->rank;
            $new_payment->post_duration = $duration;
            $new_payment->post_open_at = $open_at->format('Y-m-d H:i:s');
            $new_payment->post_close_at = $close_at->format('Y-m-d H:i:s');
            $new_payment->total = $duration * $post_rank->price;
            $new_payment->status = 1;
    
            if ($wallet->main_account < $new_payment->total) {
                $new_realty->delete();
                $new_realty_post->delete();
                $request->flash();
                return redirect()->back()->with('error', 'Tài khoản của bạn không đủ');
            }
    
            $new_payment->save();
            $this->handleCustomerPayment(auth()->user(), $new_payment);
            //store image
            return redirect()->back()->with('success', 'Gửi thành công tin đăng, Chúng tôi sẽ duyệt bài đăng của bạn sớm');
        // }else{
        //     return back();
        // }
        
    }

    private function handleCustomerPayment($author, $realty_post_payment)
    {
        try {
            DB::beginTransaction();
            if ($author) {
                $author_wallet = $author->wallet;
                if ($author_wallet && $author_wallet->main_account > $realty_post_payment->total) {
                    $author_wallet->main_account -= $realty_post_payment->total;
                    $author_wallet->save();
                    activity()
                        ->causedBy(auth()->user())
                        ->performedOn($author_wallet)
                        ->withProperties([
                            'amount_of_money' => -$realty_post_payment->total,
                            'main_account' => $author_wallet->main_account,
                        ])
                        ->log('Đăng tin rao bất động sản');
                    DB::commit();
                }
            }
        } catch (\Exception $e) {
            return $e->getMessage();
            DB::rollback();
        }
    }

    public function edit($id)
    {

        $realty_post = RealtyPost::with('realty', 'realty.district', 'realty.province', 'realty.commune')->findOrFail($id);
        $realty = $realty_post->realty;
        // $house_image = explode(',', $realty_post->realty->house_image);
        $house_image = $realty_post->images()->where('type',1)->get()->toArray();

        // dd($house_image, $images);
        $house_design_image = $realty_post->images()->where('type',2)->get()->toArray();

        if (!empty(config('constant.provinces'))) {
            $provinces = Province::whereIn('code', config('constant.provinces'))->get();
        } else {
            $provinces = Province::orderBy('slug')->get();
        }
        $districts = District::where('parent_code', $realty->district->parent_code ?? 0)->get();
        $communes = Commune::where('parent_code', $realty->commune->parent_code ?? 0)->get();

        // dd($house_design_image);
        $house_image = array_map(function ($item) {
            // dd($item);
            return [
                'path' => $item['link'],
                'storage_path' => Str::replaceFirst('/storage/', '', $item['link']),
                'thumb' => Str::replaceLast('/', '/thumbs/', $item['link']),
                'alt'=>$item['alt'],
                'title'=>$item['title']
            ];
        }, $house_image);


        $house_design_image = array_map(function ($item) {
            if ($item == '') {
                return;
            }
            // dd($item);
            return [
                'path' => $item['link'],
                'storage_path' => Str::replaceFirst('/storage/', '', $item['link']),
                'thumb' => Str::replaceLast('/', '/thumbs/', $item['link']),
                'alt'=>$item['alt'],
                'title'=>$item['title']
            ];
        }, $house_design_image);

        $post_ranks = PostRank::select('*')->groupBy('rank_code')->get()->sortBy('rank_code');

        return view('customer.pages.user_profile.update_post', compact(
            'realty_post',
            'house_image',
            'house_design_image',
            'districts',
            'provinces',
            'communes',
            'realty',
            'post_ranks'
        ));
    }

    public function update($id, RealtyPostRequest $request)
    {
        // dd($request->all());
        
        $commune = Commune::where('code', $request->commune)->first();
        $realty_post = RealtyPost::findOrFail($id);
        $realty = $realty_post->realty;
        $slug = $this->slug_service->getSlug($request->title);
        $projects = implode(",", $request->project);
        $realty->update([
            'type' => $request->realty_type,
            'province_code' => $request->province,
            'district_code' => $request->district,
            'commune_code' => $request->commune,
            'street' => $request->street,
            'direction' => $request->direction,
            'number_of_bed_rooms' => $request->number_of_bed_rooms,
            'number_of_bath_rooms' => $request->number_of_bath_rooms,
            'number_of_floors' => $request->number_of_floors,
            'area' => $request->area,
            'description' => $request->description,
            'apartment_number' => $request->apartment_number,
            'direction' => $request->direction,
            'house_image' => $request->house_image,
            'house_design_image' => $request->house_design_image,
            'full_address' => 'Số nhà' . $request->apartment_number . ", " . $request->street . ", " . $commune->path_with_type,
            'google_map_lat' => $request->google_map_lat,
            'google_map_lng' => $request->google_map_lng,
            'project_id' => $projects,
            'furniture' => $request->furniture,
        ]);
        // store realty post
        $realty_post->update([
            'title' => $request->title,
            'slug' => $slug,
            'type' => $request->realty_post_type,
            'price' => $request->price,
            'description' => $request->description,
            'price_type' => $request->price_type,

            'contact_name' => $request->contact_name,
            'contact_phone_number' => $request->contact_phone_number,
            'contact_email' => $request->contact_email,
            'contact_address' => $request->contact_address,
        ]);
        $realty_post->images()->delete();
        $house_images = array_filter(explode(',',$request->house_image));
            $design_images = array_filter(explode(',',$request->house_design_image));
            foreach ($house_images as $key => $image) {
                # code...
                $realty_post->images()->create([
                    'type'=>1,
                    'link'=>$image,
                    'alt'=>isset($request->house_image_alt[$key])  ? $request->house_image_alt[$key] : $request->title,
                    'title'=>isset($request->house_image_title[$key])  ? $request->house_image_title[$key] : $request->title
                ]);
            }
            foreach ($design_images as $key => $image) {
                # code...
                $realty_post->images()->create([
                    'type'=>2,
                    'link'=>$image,
                    'alt'=>isset($request->house_design_image_alt[$key])  ? $request->house_design_image_alt[$key] : $request->title,
                    'title'=>isset($request->house_design_image_title[$key])  ? $request->house_design_image_title[$key] : $request->title
                ]);
            }

        $realty_post->save();

        return redirect()->back()->with('success', 'Cập nhật thành công tin rao');
    }

    public function getRealtyPosts()
    {
        $query = RealtyPost::with(
            'author',
            'featured_by',
            'realty',
            'realty.province',
            'realty.district',
            'realty.commune'
        )
            ->join('realty as table_realty', 'realty_posts.realty_id', '=', 'table_realty.id')
            ->select([
                'table_realty.area as area',
                'realty_posts.*',
            ]);
        // return $query;
        $query = $this->filter_service->filter($query);
        $realties = $query->paginate(12)->appends(request()->where('status',3)->query());

        // dd($realties);

        if (!$realties) {
            return abort(404);
        }
        return view('customer.pages.realty_post.index', compact('realties'));
    }

    public function show($type,$ward,$slug)
    {

        // Log::alert('show');

        // dd('test');

        $realty_post = RealtyPost::with(
            'tags',
            'author',
            'realty',
            'featured_by',
        )
            ->where('slug', $slug)->where('status',3)->whereHas('realty')->firstOrFail();

            $post_ward = Str::slug($realty_post->realty->commune->name_with_type,'-');
            $post_type = $realty_post->type == 1? 'ban' : 'cho-thue';
        if($post_type != $type || $post_ward != $ward){
            $url = url($post_type.'/'.$post_ward.'/'.$slug);
            return redirect($url);
        }

        $newest_post = RealtyPost::with('realty', 'author', 'realty.district')
            ->orderByDesc('id')
            ->take(6)->where('status',3)
            ->get();

            // dd($realty_post);

        return view('customer.pages.realty_post.realty-details',['newest_post'=>$newest_post, 'realty_post'=>$realty_post]);

    }

    public function searchByParam($search_slug, Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Update bds 
        |--------------------------------------------------------------------------
        | update form search bds
        */
        // dd(request()->query());

        if(count($request->query) > 0 && !$request->has('page')){
            return redirect()->route('home');
        }

        

        // dd($request->all());
        if (!$request->sort) {
            $request->request->add(['sort' => '-rank']);
        }
        $query_from_slug = $this->realty_slug_helper->getFilterStringFromSlug($search_slug);
        $request->request->add(['filter' => $query_from_slug]);
        $side_lists = $this->related_realty_service->getRelatedRealty($query_from_slug['loai-tin-dang'] ?? null, null, $query_from_slug['tinh'] ?? null, $query_from_slug['huyen'] ?? null);

        $query = RealtyPost::with(
            'author',
            'realty',
            'featured_by',
            'realty.province',
            'realty.district',
            'realty.commune'
        )
            ->join('realty as table_realty', 'realty_posts.realty_id', '=', 'table_realty.id')
            // ->join('projects as table_projects', 'table_realty.project_id', '=', 'table_projects.id')
            ->select([
                'table_realty.area as area',
                'table_realty.commune_code as commune_code',
                'table_realty.district_code as district_code',
                'table_realty.province_code as province_code',
                'table_realty.project_id as project_id',
                'table_realty.number_of_bed_rooms as number_of_bed_rooms',
                'table_realty.number_of_bath_rooms as number_of_bath_rooms',
                'table_realty.furniture as furniture',
                // 'table_projects.name as project_name',
                'realty_posts.*',
            ])->where('status',3);
        $user = null;
        // If request has us param, get user and pass to view
        if ($request->has('us')) {
            $user = User::find($request->us);
        }
        

        $query = $this->filter_service->filter($query);

        // Xử lý ô tìm kiếm hiện tại
        $filter_search = $this->filter_service->readQuery();
        // dd($filter_search);

        $search_address = $this->filter_service->getSearchAddress();

        $realties = $query->paginate(12)->onEachSide(5);
        // $realties->withPath('pages');


        if (!$realties) {
            return abort(404);
        }

        $query_list = request()->filter;
        $title = $this->getTitleFromQuery($query_list);
        $project_name = '';
        // dd($request->all());
        if($request->has('du-an') && $request->input('du-an') != null){
            $project_name = Project::findOrFail($request->input('du-an'))->name;
        }

        $listProjectOfDistrictFilter = Project::all();

        if (isset($query_from_slug['huyen']) && $query_from_slug['huyen'] != null) {
            $listProjectOfDistrictFilter = Project::where('district_code', $query_from_slug['huyen'])->get();
        }

        
        // dd($listProjectOfDistrictFilter);
        
        return view('customer.pages.realty_post.index', compact('realties', 'side_lists', 'title', 'user', 'filter_search', 'search_address', 'listProjectOfDistrictFilter','project_name'));
    }

    public function searchByParam2($search_slug, $realty_slug = null, Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Update bds 
        |--------------------------------------------------------------------------
        | update form search bds
        */

        // dd($request);

        if($search_slug == 'bat-dong-san'){
            $rtp = RealtyPost::whereSlug($realty_slug)->firstOrFail();
            $t = $rtp->type == 1 ? 'ban' : 'cho-thue';
            $ad = Str::slug($rtp->realty->commune->name_with_type,'-');
            return redirect(url($t.'/'.$ad.'/'.$realty_slug));
        }

      

        // dd($request->all());
        if (!$request->sort) {
            $request->request->add(['sort' => '-rank']);
        }
        $project_id = Project::whereSlug($realty_slug)->first();
        // dd($project_id);
        $request->merge(['du-an'=>$project_id->id]);
        $query_from_slug = $this->realty_slug_helper->getFilterStringFromSlug($search_slug);
        $request->request->add(['filter' => $query_from_slug]);
        $side_lists = $this->related_realty_service->getRelatedRealty($query_from_slug['loai-tin-dang'] ?? null, null, $query_from_slug['tinh'] ?? null, $query_from_slug['huyen'] ?? null);

        $query = RealtyPost::with(
            'author',
            'realty',
            'featured_by',
            'realty.province',
            'realty.district',
            'realty.commune'
        )
            ->join('realty as table_realty', 'realty_posts.realty_id', '=', 'table_realty.id')
            // ->join('projects as table_projects', 'table_realty.project_id', '=', 'table_projects.id')
            ->select([
                'table_realty.area as area',
                'table_realty.commune_code as commune_code',
                'table_realty.district_code as district_code',
                'table_realty.province_code as province_code',
                'table_realty.project_id as project_id',
                'table_realty.number_of_bed_rooms as number_of_bed_rooms',
                'table_realty.number_of_bath_rooms as number_of_bath_rooms',
                'table_realty.furniture as furniture',
                // 'table_projects.name as project_name',
                'realty_posts.*',
            ])->where('status',3);
        $user = null;
        // If request has us param, get user and pass to view
        if ($request->has('us')) {
            $user = User::find($request->us);
        }

        // dd($request->all());
        

        $query = $this->filter_service->filter($query);

        // Xử lý ô tìm kiếm hiện tại
        $filter_search = $this->filter_service->readQuery();
        // dd($filter_search);

        $search_address = $this->filter_service->getSearchAddress();

        $realties = $query->paginate(12)->onEachSide(5)->appends(request()->query());

        // dd($realties);

        if (!$realties) {
            return abort(404);
        }

        $query_list = request()->filter;
        $title = $this->getTitleFromQuery($query_list);
        $project_name = '';
        if($request->has('du-an') && $request->input('du-an') != null){
            $project_name = Project::find($request->input('du-an'))->name;
        }

        $listProjectOfDistrictFilter = Project::all();

        if (isset($query_from_slug['huyen']) && $query_from_slug['huyen'] != null) {
            $listProjectOfDistrictFilter = Project::where('district_code', $query_from_slug['huyen'])->get();
        }
        
        return view('customer.pages.realty_post.index', compact('realties', 'side_lists', 'title', 'user', 'filter_search', 'search_address', 'listProjectOfDistrictFilter','project_name'));
    }

    public function showListCustomer()
    {
        $user = auth()->user();
        $realty_posts = RealtyPost::where('created_by', $user->id)->with('realty')->orderByDesc('realty_posts.id')->get();
        return view('customer.pages.user_profile.list_realty_post', compact('realty_posts'));
    }

    protected function getTitleFromQuery($query_list)
    {
        $result = [
            'loai-tin-dang' => '',
            'loai-bds' => '',
            'dia-chi' => '',
        ];
        try {
            foreach ($query_list as $key => $item) {
                switch ($key) {
                    case 'loai-tin-dang':
                        $result['loai-tin-dang'] = config('constant.realty_post_type.' . $item)['name'] ?? '';
                        break;
                    case 'loai-bds':
                        $result['loai-bds'] = config('constant.realty_type.' . $item)['name'];
                        break;
                    case 'tinh':
                        $address = Province::where('code', $item)->first();
                        $result['dia-chi'] = $address->name_with_type ?? '';
                        break;
                    case 'huyen':
                        $address = District::where('code', $item)->first();
                        $result['dia-chi'] = $address->path ?? '';
                        break;
                    case 'xa':
                        $address = Commune::where('code', $item)->first();
                        $result['dia-chi'] = $address->path ?? '';
                        break;
                    default:
                        # code...
                        break;
                }
            }
        } catch (\Exception $e) {
            $result = [];
        }

        return $result;
    }
}
