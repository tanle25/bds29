<?php

namespace App\Http\Controllers\Customer;

use File;
use Tinify\Tinify;
use App\Models\Post;
use App\Models\User;
use App\Models\Widget;
use App\Models\Partner;
use App\Models\Project;
use App\Models\District;
use App\Models\Province;
use App\Models\RealtyPost;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct(ProjectService $project_service)
    {
        $this->project_service = $project_service;
    }

    public function test()
    {
        # code...
        $keys =[
            'N4ltLGqjkzMmWPg8VdvDByQdJBr9mYxT',
            'Frq70zfjY2T5fCf1cFCrn0bZyHpNhsDz',
            'FHmN1yg3lmkYQTjP8Q6rZWPJWn4ZRYfc'
        ];
        Tinify::setKey('Frq70zfjY2T5fCf1cFCrn0bZyHpNhsDz');
        // for($i =0 ; $i < count($keys); $i ++){
        //     Tinify::setKey('Frq70zfjY2T5fCf1cFCrn0bZyHpNhsDz');
        //     \Tinify\validate();
        //     $compressionsThisMonth = \Tinify\compressionCount();
        //     if($compressionsThisMonth < 499){
        //         break;
        //     }
        // }
        // $realties = RealtyPost::whereStatus(3)->get();

        // foreach ($realties as $realty) {
        //     # code...
        //     $thumb = $realty->thumb;
        //     $ex = pathinfo($thumb,PATHINFO_EXTENSION);
        //     if($ex != 'webp'){
        //         $source = \Tinify\fromFile(public_path($thumb));
        //         $path = Str::replace($ex,'webp',$thumb);
        //         $source->toFile(public_path($path));
        //         File::delete($thumb);

        //     }
        // }
        // dd($realties->first()->thumb);


        // foreach ($realties as $realty) {
        //     # code...
        //     $images = explode(',',$realty->realty->house_image);
        //     $convertedImages=[];
        //     foreach($images as $image){
                
        //         $ex = pathinfo($image,PATHINFO_EXTENSION);
        //         // if($ex != 'webp'){

        //                 //code...
        //                 $source = \Tinify\fromFile(public_path($image));
                
        //                 $path = Str::replace($ex,'webp',$image);
        //                 $resized = $source->resize([
        //                     "method" => "scale",
        //                     "width" => 825 
        //                 ]);
        //                 $resized->toFile(public_path($path));
        //                 // Storage::rename($image, $path);
        //                 $convertedImages[]= $path;
        //             File::delete(public_path($image));
   
                   
        //         // }
                
        //     }
        //     $convertImage = implode(',',$convertedImages);
        //     // dd($convertImage);
        //     $realty->realty->update([
        //         'house_image'=>$convertImage
        //     ]);
            
        // }

        // $image = '/storage/photos/1/du-an/20210202105549-824e_wm.webp';

        // $ex = pathinfo($image,PATHINFO_EXTENSION);
        // $filename = Str::of($image)->basename('.'.$ex);
        // $newname = Str::replace($filename,$filename.'_mb',$image);
        // $path = Str::replace($ex,'webp',$newname);

        // // dd($path);
        // $source = \Tinify\fromFile(public_path($image));
        // $resized = $source->resize([
        //     "method" => "scale",
        //     "height" => 250 
        // ]);
        // $resized->toFile(public_path($path));

        // dd($realties);


        $users = User::whereNotNull('profile_image_path')->get();
        // dd($user);
        foreach ($users as $user) {
            # code...]
            $image = $user->profile_image_path;
            $ex = pathinfo($image,PATHINFO_EXTENSION);
            $path = Str::replace($ex,'webp',$image);

            // dd($path);
            $source = \Tinify\fromFile(public_path($image));
            $resized = $source->resize([
                "method" => "fit",
                "width" => 150,
                "height" => 150
            ]);
            $resized->toFile(public_path($path));
            $user->profile_image_path = $path;
            $user->save();
            // File::delete(public_path($image));
        }
    }

    public function moveImage()
    {
        # code...
        dd('test');
        $realties = RealtyPost::whereStatus(3)->get();
        foreach ($realties as $realty) {
            # code...
            $images = explode(',',$realty->realty->house_image);
            foreach ($images as $image) {
                # code...
                dd($image);
                $realty->images()->create([
                    'link'=>$image,
                    'title'=>$realty->title,
                    'alt'=>$realty->title
                ]);
            }
        }
       
    }

    public function index(Request $request)
    {
        // dd('index');
        $widgets = Widget::all();

        if (!empty(config('constant.provinces'))) {
            $provinces = Province::whereIn('code', config('constant.provinces'))->get();
        } else {
            $provinces = Province::orderBy('slug')->get();
        }
        $featured_district_code = $widgets->where('name', 'bds_noi_bat')->first()->data_array->districts ?? [];
        $featured_district = District::whereIn('code', $featured_district_code)->get();
        $show_districts = District::whereIn('code', $featured_district_code)->where('parent_code', '=',config('constant.provinces'))->join('district_details','districts.id','district_details.district_id')->get();
        if ($show_districts->count() >= 8) {
            $show_districts = $show_districts->random(8)->sortByDesc('district_id');
        }

        $current_post_categories = $widgets->where('name', 'tin_tuc_noi_bat')->first()->data_array->post_categories ?? [];
        $home_featured_cats = PostCategory::whereIn('id', $current_post_categories)
            ->with('posts')
            ->get();
        $home_featured_post = Post::where('is_featured', 1)->take(6)->get();
        $home_projects = $widgets->where('name', 'du_an_noi_bat')->first()->data_array->projects ?? [];

        $home_projects = Project::whereIn('id', $home_projects)->with('realty_posts', 'realty_posts.realty')->get();

        $home_search_projects = Project::where('district_code', 19)->get();

        // $home_projects = $this->project_service->getProjectDetails($home_projects)->chunk(3);
        $random_realties_type1 = RealtyPost::with('realty', 'realty.district')->where('type','=',1)->where('status',3)->orderByDesc('id')->take(50)->get();
        $random_realties_type2 = RealtyPost::with('realty', 'realty.district')->where('type','=',2)->where('status',3)->orderByDesc('id')->take(50)->get();
        if ($random_realties_type1->count() >= 8) {
            $random_realties_type1 = $random_realties_type1->random(8)->sortByDesc('rank');
        }
        if ($random_realties_type2->count() >= 8) {
            $random_realties_type2 = $random_realties_type2->random(8)->sortByDesc('rank');
        }

        $partners = Partner::where('rank', 1)->take(10)->get();
        return view('customer.pages.home.index', compact('partners', 'random_realties_type1', 'random_realties_type2', 'home_projects', 'home_search_projects', 'provinces', 'featured_district', 'home_featured_cats', 'home_featured_post', 'show_districts'));
    }
}
