@extends('admin.layouts.site')

@section('breadcrumbs', Breadcrumbs::view('admin.layouts.breadcrumbs', 'edit'))

@section('content')
<!-- layout-content-->
<section class="panel panel-default">
    <header class="panel-heading">
        <h1 class="h5 float-left font-weight-bold">{{ $pageData->title }} @lang('admin.form.edit')</h1>
    </header>

    <div class="panel-wrapper">
        <div class="panel-body">
            <form id="editForm" class="form-horizontal validate editForm"  name="editForm"
                  action="{{ route('admin.profile') }}"
                  method="post"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf

                @inject('modelPresenter', 'App\Presenters\Admin\ProfilePresenter')

                <fieldset id="baseFieldSet">
                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.default')</legend>

                    {!! $modelPresenter->getFieldNormalText($formData, 'username', true) !!}

                    {!! $modelPresenter->getFieldText($formData, 'name', true, ['size' => 4]) !!}

                    {!! $modelPresenter->getFieldEmail($formData, 'email', true) !!}

                </fieldset>

                <fieldset class="mt-4" id="advFieldSet">
                    <legend class="legend h6 mb-4"><i class="icon-angle-double-down2 mr-2"></i>@lang('admin.form.fieldSet.advanced')</legend>

                    {!! $modelPresenter->getFieldPassword($formData, 'password', false, ['size' => 4, 'hint' => true]) !!}

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="Admin-password_confirmation">@lang('models.Admin.password_confirmation')</label>
                        <div class="col-sm-4">
                            <input type="password" class="form-control"
                                   id="Admin-password_confirmation"
                                   name="Admin[password_confirmation]"
                                   placeholder="" />
                        </div>
                        <small class="form-text text-muted ml-sm-auto col-sm-10">@lang('models.Admin.hint.password_confirmation')</small>
                    </div>

                </fieldset>

                <div class="text-center my-4 form-btn-group">
                    <input class="btn btn-main" type="submit" id="submitBut" value="@lang('admin.form.button.send')">
                    <input class="btn btn-default" type="reset" value="@lang('admin.form.button.reset')">
                </div>
            </form>
        </div>
    </div>
</section>
<!-- / layout-content-->
@endsection