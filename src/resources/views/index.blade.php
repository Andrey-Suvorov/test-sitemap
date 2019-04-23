@extends('sitemap::layouts.app')

@section('title', __('sitemap::sitemap.seo-sitemap'))
@section('title_sm', $sitemap->total())

@section('content')

            <div class="row">
                <div class="col-6 col-md-8 col-lg-10">
                    <h4></h4>
                </div>
                <div class="col-6 col-md-4 col-lg-2"><p>
                        <a href="{{ route(config('sitemap.route_prefix') . '.sitemap.load.urls') }}" data-do="link" data-dialog="@lang('sitemap::sitemap.fill_db_dialog')"
                           class="btn btn-block btn-sm btn-warning text-uppercase">
                            <b>@lang('sitemap::sitemap.load_urls')</b>
                        </a>

                        <a href="{{ route(config('sitemap.route_prefix') . '.sitemap.generate') }}" data-do="link" data-dialog="@lang('sitemap::sitemap.fill_db_dialog')"
                           class="btn btn-block btn-sm btn-warning text-uppercase">
                            <b>@lang('sitemap::sitemap.fill_db')</b>
                        </a>

                        <a href="{{ route(config('sitemap.route_prefix') . '.sitemap.create') }}" class="btn btn-block btn-sm btn-success text-uppercase">
                            @lang('sitemap::sitemap.create')
                        </a>
                    </p>
                </div>
            </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('sitemap::sitemap.url')</th>
                <th>@lang('sitemap::sitemap.priority')</th>
                <th>@lang('sitemap::sitemap.changefreq')</th>
                <th>@lang('sitemap::sitemap.lastmod')</th>
                <th class="text-center">@lang('sitemap::sitemap.active')</th>
                <th width="300px"></th>
            </tr>
            </thead>
            <tbody>
            @forelse($sitemap as $map)
                <tr>
                    <td><a href="{{ $map->alias }}" target="_blank">{{ $map->alias }}</a></td>
                    <td>{{ $map->priority }}</td>
                    <td>{{ $map->changefreq }}</td>
                    <td>{{ $map->lastmod }}</td>
                    <td class="text-center">
                        @if($map->is_active)
                            <span class="label label-success">@lang('sitemap::sitemap.yes')</span>
                        @else
                            <span class="label label-danger">@lang('sitemap::sitemap.no')</span>
                        @endif
                    </td>
                    <td class="text-right">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                            {!! Form::open(array('url' => route(config('sitemap.route_prefix') . '.sitemap.destroy', $map), 'method' => 'DELETE', 'style' => 'margin-bottom: 0px;')) !!}
                                <button class="delete-btn btn btn-danger btn-sm text-uppercase pull-right"
                                        onclick="confirm('@lang('sitemap::sitemap.delete_question')"
                                        title="">@lang('sitemap::sitemap.delete')
                                </button>
                            {!! Form::close() !!}

                            <a href="{{ route(config('sitemap.route_prefix') . '.sitemap.edit', $map) }}"
                               class="btn btn-sm btn-primary text-uppercase pull-right">
                                <span class="hidden-xs hidden-sm hidden-md">@lang('sitemap::sitemap.edit')</span>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="bg-warning">
                        <h3 class="text-center">
                            @lang('sitemap::sitemap.nothing_found')
                        </h3>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {!! $sitemap->appends(Request::all())->render() !!}
    </div>
@endsection
