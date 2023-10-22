@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('admin.product.update',$product->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">@lang('Product Name')</label>
                            <input type="text" class="form-control" placeholder="@lang('Enter name')" value="{{ $product->name }}" name="name" required>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Category')</label>
                                    <select name="category_id" id="category" class="form-control" required>
                                        @foreach ($categories as $item)
                                            <option data-subcategory="{{$item->subcategories}}" value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Subcategory')</label>
                                    <select name="sub_category_id" id="subcategory" class="form-control" required></select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('Old Price') <code>[@lang('max 8 digits fractional')]</code></label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input type="number" step="any" class="form-control" name="old_price" value="{{$product->old_price}}" placeholder="@lang('Enter price')">
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{$general->cur_text}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">@lang('New Price') <code>[@lang('max 8 digits fractional')]</code></label>
                                    <div class="input-group mb-2 mr-sm-2">
                                        <input type="number" step="any" class="form-control" name="new_price" value="{{$product->new_price}}" placeholder="@lang('Enter price')" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text">{{$general->cur_text}}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-bold" class="font-weight-bold">@lang('Short Description')</label>
                                    <textarea name="short_description" id="" class="form-control"  rows="5" required>{{$product->short_description}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold" class="font-weight-bold">@lang('HTML Description')</label>
                            <small><code>(@lang('HTML or plain text allowed'))</code></small>
                            <textarea name="description" class="form-control nicEdit" rows="10" placeholder="@lang('Enter your message')">{{$product->description}}</textarea>
                        </div>

                        <div class="payment-method-body">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Upload Downloadable File')

                                    @if ($product->p_file)
                                        <small class="text--danger text-bold">(@lang('Previous file detected. By uploading new one previous one will be removed'))</small>
                                    @endif
                                </h5>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-xl-12 col-12">
                                            <div class="custom-file">

                                                <input type="file" class="custom-file-input" name="p_file" accept=".zip,.pdf,.txt" >

                                                <label class="custom-file-label">@lang('Select file')</label>
                                                <small>@lang('Supported files'): <b>@lang('zip, pdf, txt')</b>.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @if ($product->image)
                            <h4 class="font-weight-bold mt-3 mb-3">@lang('Current Images')</h4>
                            <div class="row">
                                @foreach ($product->image as $item)
                                    <div class="col-xl-3 col-lg-4 col-sm-6">
                                        <div class="form-group">
                                            <div class="image-upload mt-2">
                                                <div class="thumb">
                                                    <div class="avatar-preview">
                                                        <div class="profilePicPreview" style="background-image: url({{ getImage(imagePath()['p_image']['path'].'/'. $item) }})">

                                                            @if (count($product->image) > 1)
                                                                <a href="#0" class="remove-img-2" data-toggle="modal" data-target="#removeImageModal{{$loop->index}}"><i class="fa fa-times"></i></a>
                                                            @endif

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="removeImageModal{{$loop->index}}" class="modal fade" tabindex="-1" role="dialog">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title text--danger">@lang('Image Removal Confirmation')</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>@lang('Are you sure to remove this image?')</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn--dark" data-dismiss="modal">@lang('No')</button>
                                                    <a href="{{ route('admin.product.image.remove',[$product->id,$item]) }}" class="btn btn--danger">@lang('Yes')</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="payment-method-body">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Add More Image')
                                    <button type="button" class="btn btn-sm btn-outline-light float-right" id="upload-image">
                                        <i class="la la-fw la-plus"></i>@lang('Add New')
                                    </button>
                                </h5>
                                <div class="card-body">
                                    <div class="addedField">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn--primary btn-block">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


@push('style')
    <style>
        .remove-img-2 {
            position: absolute;
            top: 0;
            right: 0;width: 50px;
            height: 50px;line-height: 50px;text-align: center;
            background: red;
            color: #fff;
            font-size: 18px;
            border-radius: 50% 0 50% 50%;
        }
    </style>
@endpush


@push('breadcrumb-plugins')
    <a href="{{route('admin.product.all')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('script')

    <script>
        "use strict";

        (function ($) {
            $('select[name="category_id"]').val('{{$product->category_id}}');

            $('#category').on('change',function(){
                var subcategory = $(this).find('option:selected').data('subcategory');

                $('#subcategory').empty();

                $.each(subcategory, function (index, value) {
                    $('#subcategory').append(`<option value="${value.id}">${value.name}</option>`);
                });
            }).change();


            let imgCounter = 0;

            $('#upload-image').on('click', function () {
                var html = `<div class="remove-data">
                                <div class="form-group row">
                                    <div class="col-xl-11 col-10">
                                        <div class="custom-file">

                                            <input type="file" class="custom-file-input" id="customFile${imgCounter}" name="image[]" accept=".jpg,.jpeg,.png" required >

                                            <label class="custom-file-label" for="customFile${imgCounter}">@lang('Select image')</label>

                                            <small>@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image will be resized to'): <b>{{imagePath()['p_image']['size']}}</b> @lang('px')</small>
                                        </div>


                                    </div>
                                    <div class="col-xl-1 col-2">
                                        <button class="btn btn--danger removeBtn w-100 text-center" type="button">
                                            <i class="la la-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>`;
                $('.addedField').append(html);
            });

            $('select[name="sub_category_id"]').val('{{$product->sub_category_id}}');

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.remove-data').remove();
            });

            $(document).on("change", ".custom-file-input",function() {
                var fileName = $(this).val().split("\\").pop();

                console.log(fileName);

                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

        })(jQuery);
    </script>

@endpush
