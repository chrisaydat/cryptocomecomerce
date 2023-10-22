@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{route('admin.product.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Product Name')</label>
                                            <input type="text" class="form-control" placeholder="@lang('Enter name')" value="{{ old('name') }}" name="name" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Category')</label>
                                            <select name="category_id" id="category" class="form-control" required>
                                                @foreach ($categories as $item)
                                                    <option data-subcategory="{{$item->subcategories}}" value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Subcategory')</label>
                                            <select name="sub_category_id" id="subcategory" class="form-control" required></select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('Old Price') <code>[@lang('max 8 digits fractional')]</code></label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <input type="number" step="any" class="form-control" name="old_price" value="{{old('old_price')}}" placeholder="@lang('Enter price')">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{$general->cur_text}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold">@lang('New Price') <code>[@lang('max 8 digits fractional')]</code></label>
                                            <div class="input-group mb-2 mr-sm-2">
                                                <input type="number" step="any" class="form-control" name="new_price" value="{{old('new_price')}}" placeholder="@lang('Enter price')" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">{{$general->cur_text}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold" class="form-control-label font-weight-bold">@lang('Short Description')</label>
                                            <textarea name="short_description" id="" class="form-control"  rows="5" required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label font-weight-bold" class="form-control-label font-weight-bold">@lang('HTML Description')</label>
                                            <small><code>(@lang('HTML or plain text allowed'))</code></small>
                                            <textarea name="description" class="form-control nicEdit" rows="10" placeholder="@lang('Enter your message')"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-method-body">
                            <div class="card border--primary mt-3">
                                <h5 class="card-header bg--primary  text-white">@lang('Upload Downloadable File')</h5>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-xl-12 col-12">
                                            <div class="custom-file">

                                                <input type="file" class="custom-file-input" name="p_file" accept=".zip,.pdf,.txt">

                                                <label class="custom-file-label">@lang('Select file')</label>
                                                <small>@lang('Supported files'): <b>@lang('zip, pdf, txt')</b>.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="payment-method-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card border--primary mt-3">
                                        <h5 class="card-header bg--primary  text-white">@lang('Product Image')
                                            <button type="button" class="btn btn-sm btn-outline-light float-right" id="addNewButton"><i class="la la-fw la-plus"></i>@lang('Add New')
                                            </button>
                                        </h5>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-12 col-10">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile" name="image[]" required>
                                                        <label class="custom-file-label" for="customFile" accept=".jpg,.jpeg,.png" required>@lang('Select image')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="addedField">

                                            </div>

                                            <small>@lang('Supported files'): <b>@lang('jpeg, jpg, png')</b>. @lang('Image will be resized to'): <b>{{imagePath()['p_image']['size']}}</b> @lang('px')</small>
                                        </div>
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

@push('breadcrumb-plugins')
    <a href="{{route('admin.product.all')}}" class="btn btn-sm btn--primary box--shadow1 text--small"><i class="la la-fw la-backward"></i> @lang('Go Back') </a>
@endpush

@push('script')

    <script>
        "use strict";

        (function ($) {

            $('#category').on('change',function(){
                var subcategory = $(this).find('option:selected').data('subcategory');

                $('#subcategory').empty();

                $.each(subcategory, function (index, value) {
                    $('#subcategory').append(`<option value="${value.id}">${value.name}</option>`);
                });
            }).change();

            let imgCounter = 0;

            $('#addNewButton').on('click', function () {
                var html = `<div class="remove-data mt-3">
                                <div class="row">
                                    <div class="col-xl-11 col-10">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile${imgCounter}" name="image[]" accept=".jpg,.jpeg,.png" required >

                                            <label class="custom-file-label" for="customFile${imgCounter}">@lang('Select image')</label>
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

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.remove-data').remove();
            });

            $(document).on("change", ".custom-file-input",function() {
                var fileName = $(this).val().split("\\").pop();

                $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
            });

        })(jQuery);
    </script>

@endpush
