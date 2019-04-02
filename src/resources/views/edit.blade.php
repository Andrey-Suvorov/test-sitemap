@extends('sitemap::layouts.app')

@section('content')
    <div class="panel panel-default user-panel panel-flat">
        <div class="panel-body">
            {!! Form::model($sitemap, ['route' => ['backend.sitemap.update',$sitemap->id],'method'=>'PUT','autocomplete'=>'off','files'=>true,'class'=>'needs-validation','novalidate']) !!}

            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link" id="base-tab" data-toggle="tab" href="#base" data-tab="#base" role="tab"
                           aria-controls="home" aria-selected="true">
                            @lang('backend.base') </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="base" role="tabpanel"
                         aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div>
                                    <div class="form-group">
                                        <label for="sitemapPriority">@lang('backend.priority')</label>
                                        {!! Form::number('priority',null,['class'=>'form-control','id'=>'sitemapPriority','min'=>0,'max'=>1,'step'=>0.1]) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="sitemapChangeFreq">@lang('backend.changefreq')</label>
                                        {!! Form::select('changefreq',$changefreq,$sitemap->getOriginal('changefreq'),['class'=>'form-control','id'=>'sitemapChangeFreq']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="sitemapLastMod">@lang('backend.lastmod')</label>
                                        {!! Form::text('lastmod',null,['class'=>'form-control','id'=>'sitemapLastMod']) !!}
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            {!! Form::checkbox('is_active', 'yes', null, ['class' => 'iswitch iswitch-secondary']) !!}
                                            @lang('backend.active')
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            @include('backend.elements.save_buttons', ['back_link' => route('backend.sitemap.index')])
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $("#sitemapModel").on('change', function () {
                $("#sitemapModelIds").html('');
                $.ajax({
                    url: '{{ route('backend.sitemap.getEntities') }}',
                    data: {
                        model: $(this).val()
                    },
                    dataType: 'json',
                    success: function (json) {
                        console.log(json);
                        for (let key in json) {
                            $("<option/>", {
                                value: key,
                                html: json[key]
                            }).appendTo("#sitemapModelIds");
                        }
                    }
                })
                //
            })
        });
    </script>
@endsection