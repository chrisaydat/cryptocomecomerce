@extends('admin.layouts.app')
@section('panel')

    <div class="row">
        <div class="col-lg-12 col-md-12 mb-30">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Subcategory')</th>
                                    <th>@lang('Old Price')</th>
                                    <th>@lang('New Price')</th>
                                    <th>@lang('Downloadable File')</th>
                                    <th>@lang('Image Count')</th>
                                    <th>@lang('Total Sell')</th>
                                    <th>@lang('Featured')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody class="list">
                                @forelse ($products as $item)
                                    <tr>
                                        <td data-label="@lang('Name')">{{ __($item->name) }}</td>
                                        <td data-label="@lang('Category')">{{ __($item->category->name) }}</td>
                                        <td data-label="@lang('Subcategory')">{{ __($item->subcategory->name) }} </td>
                                        <td data-label="@lang('Old Price')">{{showAmount($item->old_price)}}</td>
                                        <td data-label="@lang('New Price')">{{showAmount($item->new_price)}}</td>
                                        <td data-label="@lang('Downloadable File')">
                                            @if ($item->p_file)
                                                <span class="badge badge--primary">@lang('Yes')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('No')</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Image Count')">{{count($item->image)}}</td>
                                        <td data-label="@lang('Total Sell')">{{$item->total_sell}}</td>
                                        <td data-label="@lang('Featured')">
                                            @if ($item->featured == 1)
                                                <span class="badge badge--primary">@lang('Yes')</span>
                                            @else
                                                <span class="badge badge--warning">@lang('No')</span>
                                            @endif
                                        </td>

                                        <td data-label="@lang('Action')">
                                            @if ($item->featured == 1)
                                                <span data-toggle="tooltip" title="@lang('Remove From Featured')">
                                                    <button type="button" class="icon-btn bg--warning" data-toggle="modal" data-target="#unFeaturedModal{{$loop->index}}">
                                                        <i class="las la-star"></i>
                                                    </button>
                                                </span>
                                            @else
                                                <span data-toggle="tooltip" title="@lang('Make Featured')">
                                                    <button type="button" class="icon-btn" data-toggle="modal" data-target="#featuredModal{{$loop->index}}"><i class="las la-star"></i></button>
                                                </span>
                                            @endif
                                            <span data-toggle="tooltip" title="@lang('Edit')">
                                                <a href="{{route('admin.product.edit',$item->id)}}" class="icon-btn "><i class="la la-pencil-alt"></i></a>
                                            </span>

                                            @if ($item->status == 0)
                                                <span data-toggle="tooltip" title="@lang('Enable')">
                                                    <button type="button" class="icon-btn bg--success" data-toggle="modal" data-target="#enableModal{{$loop->index}}"><i class="la la-eye"></i></button>
                                                </span>
                                            @else
                                                <span data-toggle="tooltip" title="@lang('Disable')">
                                                    <button type="button" class="icon-btn bg--danger" data-toggle="modal" data-target="#disableModal{{$loop->index}}"><i class="la la-eye-slash"></i></button>
                                                </span>
                                            @endif
                                        </td>

                                        <div id="featuredModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@lang('Confirmation Alert')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.featured.product') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="modal-body">
                                                            <p>@lang('Are you sure to make this product featured?')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                                                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="unFeaturedModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text--danger">@lang('Make Unfeatured Confirmation')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.unfeatured.product') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="modal-body">
                                                            <p>@lang('Are you sure to make this product unfeatured?')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                                                            <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="enableModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">@lang('Confirmation Alert')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.product.enable') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="modal-body">
                                                            <p>@lang('Are you sure to make this product enabled?')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                                                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="disableModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text--danger">@lang('Confirmation Alert')</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.product.disable') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$item->id}}">
                                                        <div class="modal-body">
                                                            <p>@lang('Are you sure to make this product disabled?')</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                                                            <button type="submit" class="btn btn--danger">@lang('Yes')</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer py-4">
                    {{ $products->links('admin.partials.paginate') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.product.new')}}" class="btn btn--primary mr-3 mt-2"><i class="fa fa-fw fa-plus"></i>@lang('Add New')</a>
    <form action="" method="GET" class="form-inline float-sm-right bg--white mt-2">
        <div class="input-group has_append">
            <input type="text" name="search" class="form-control" placeholder="@lang('By product name')" value="{{$search ?? ''}}" autocomplete="off">
            <div class="input-group-append">
                <button class="btn btn--primary" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>
@endpush
