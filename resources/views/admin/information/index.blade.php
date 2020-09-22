@extends('admin.layout.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Thông tin trang web
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Thông tin trang web</a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <!-- form start -->
            <form role="form" action="{{ route('information.store') }}" method="POST">
                {!! csrf_field() !!}
                {{ method_field('POST') }}

                <div class="col-xs-12 col-md-8">

                    <!-- Nội dung thêm mới -->
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($languages as $id => $language)
                            <li role="presentation" class="{{ ($id == 0) ? 'active' : '' }}">
                                <a href="#{{ $language->acronym }}" aria-controls="{{ $language->acronym }}" role="tab" data-toggle="tab">{{ $language->language }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <!-- /.box-header -->
                    <div class="tab-content clearfix">
                        @foreach ($languages as $id => $language)
                            <div role="tabpanel" class="tab-pane {{ ($id == 0) ? 'active' : '' }}" id="{{ $language->acronym }}">
                                @foreach($typeInformations as $typeinformation)
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">{{ $typeinformation->title }}</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="form-group">
                                                <input type="hidden" value="{{ $typeinformation->slug }}" name="slug_type_input[]"/>

                                                @if ($typeinformation->type_input == 'one_line')
                                                    <input type="text" class="form-control" name="content{{ $language->acronym }}[]"
                                                           placeholder="{{ $typeinformation->placeholder }}"
                                                           value="{{ $typeinformation['information'.$language->acronym] }}"/>
                                                @endif

                                                @if ($typeinformation->type_input == 'multi_line')
                                                    <textarea rows="4" class="form-control" name="content{{ $language->acronym }}[]"
                                                              placeholder="{{ $typeinformation->placeholder }}">{{ $typeinformation['information'.$language->acronym] }}</textarea>
                                                @endif

                                                @if ($typeinformation->type_input == 'editor')
                                                    <textarea class="editor" id="{{$typeinformation->slug}}" name="content{{ $language->acronym }}[]"
                                                              rows="10" cols="80"
                                                              placeholder="{{ $typeinformation->placeholder }}"/>{{ $typeinformation['information'.$language->acronym] }}</textarea>
                                                @endif

                                                @if ($typeinformation->type_input == 'image')
                                                    <div>
                                                        <input type="button" onclick="return uploadImage(this);" value="Chọn ảnh"
                                                               size="20"/>
                                                        <img src="{{ $typeinformation['information'.$language->acronym] }}" width="80" height="70"/>
                                                        <input name="content{{ $language->acronym }}[]" type="hidden"
                                                               value="{{ $typeinformation['information'.$language->acronym] }}"/>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                <!-- /.box-body -->

                    <!-- /.box -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Lưu thông tin thay đổi</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

@endsection

