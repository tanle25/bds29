<?php

namespace App\Scraper;

use App\Models\RealtyPost;
use App\Services\SlugService;
use Goutte\Client;

class RealtyScraper
{
    public function __construct(SlugService $slug_service)
    {
        $this->slug_service = $slug_service;
        $this->slug_service->setModel(RealtyPost::class);
    }
    public function crawDetail($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        dd($crawler);
    }

    public function scrapeRealty($url)
    {
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $realty_type = $crawler
            ->filter(".infor tr:nth-child(3) td:nth-child(2)")
            ->first()->text();
        $street = $crawler
            ->filter(".address .value")
            ->first()->text();

        $direction = $crawler
            ->filter(".infor tr:nth-child(1) td:nth-child(4)")
            ->first()->text();
        $number_of_bed_rooms = $crawler
            ->filter(".infor tr:nth-child(5) td:nth-child(4)")
            ->first()->text();
        $number_of_floors = $number_of_bath_rooms = $crawler
            ->filter(".infor tr:nth-child(4) td:nth-child(4)")
            ->first()->text();

        $area = $crawler
            ->filter(".square .value")
            ->first()->text();
        $description = $crawler
            ->filter(".detail.text-content")
            ->first()->text();
        $full_address = $crawler
            ->filter(".address .value")
            ->first()->text();
        $google_map_lat = "20.990585";
        $google_map_lng = "105.831522";

        // realty post
        $title = $crawler
            ->filter(".title h1")
            ->first()->text();
        $realty_post_type = $crawler
            ->filter(".infor tr:nth-child(2) td:nth-child(2)")
            ->first()->text();
        $price = $crawler
            ->filter(".price .value")
            ->first()->text();

        // images
        $images = $crawler
            ->filter(".images .image-list img");
        $list = [];
        $images->each(function ($node) {
            $list[] = ;
        });

        dd($images);
        $new_realty = [];
        $new_realty['type'] = $realty_type;
        $new_realty['street'] = $street;
        $new_realty['direction'] = $direction;
        $new_realty['number_of_bed_rooms'] = $number_of_bed_rooms;
        $new_realty['number_of_bath_rooms'] = $number_of_bath_rooms;
        $new_realty['number_of_floors'] = $number_of_floors;
        $new_realty['area'] = $area;
        $new_realty['description'] = $description;
        $new_realty['full_address'] = $full_address;
        $new_realty['google_map_lat'] = $google_map_lat;
        $new_realty['google_map_lng'] = $google_map_lng;

        $new_realty_post = [];
        $new_realty_post["title"] = $title;
        $new_realty_post["realty_post_type"] = $realty_post_type;
        $new_realty_post["price"] = $price;
        $new_realty_post["description"] = $description;
        $new_realty_post["slug"] = $this->slug_service->getSlug($title);

        dd($new_realty_post);

        return [
            'realty' => $new_realty,
            'realty_post' => $new_realty_post,
        ];
    }

    private function createRealty($realty, $realty_post)
    {
        // store realty
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
        $post_rank = PostRank::where('rank_code', $request->realty_post_rank)->first();
        $duration = $close_at->diffInDays($open_at);
    }

}