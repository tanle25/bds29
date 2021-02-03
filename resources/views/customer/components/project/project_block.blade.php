<div class="block realty">
    <div class="realty-container shadow-6 flex-wrap rounded d-flex d-md-block">
        <div class="overflow-hidden col-5 px-0 col-md-12 order-2 bg-white">
            <a href="{{route('customer.project.show', $project->slug)}}"class="d-block ml-2 ml-md-0 img-wraper height-md-240 height-120">
                <img src="{{$project->thumb}}" alt="" srcset="">
            </a>
        </div>
        <div class="order-1 col-12 bg-white px-3 pt-4 pb-2 pb-md-0">
            <a href="{{route('customer.project.show', $project->slug)}}" class="d-block font-9 main-text w-100 hrm-truncate
                {{-- @if ($item->rank == 4)
                text-danger
                @endif
                @if ($item->rank == 3)
                text-info
                @endif --}}
                " style="font-weight: 500; max-height: 3.6em; line-height: 1.8em"
                >{{$project->name}}
            </a>
        </div>
        <div class="realty-body col-7 col-md-12  bg-white order-3 px-3 pb-3">
            <div class="font-8 pt-2">
                <i class="fas fa-map-marker-alt pr-2 font-9"></i>
                {{$project->full_address}}
            </div>

            <div class="d-flex justify-content-between text-dark py-1 font-8 ">
                <span class="">
                    Loại hình: {{config('constant.project_type.' . $project->project_type. '.name')}}
                </span>
                <span class=""><i class="fas fa-expand"></i> {{$project->construction_area ?? ''}}m²</span>
            </div>

            <div class="font-8 d-flex justify-content-between">
                <span class="text-muted">
                    Bàn giao: {{\Carbon\Carbon::parse($project->launch_time)->format('d/m/Y') ?? 'Đang cập nhật'}}
                </span>
                <div data-post-id="1" class="btnlike like-heart unchecked">
                    @if ($project->min_price && $project->max_price)
                    {{\App\Helpers\CurrencyHelper::beautyPrice($project->min_price)}} - {{\App\Helpers\CurrencyHelper::beautyPrice($project->max_price)}}
                    @else
                        Đang cập nhật giá
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
