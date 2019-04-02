@extends('sitemap::layouts.app')

@section('title', __('backend.seo-sitemap'))
@section('title_sm', $sitemap->total())

{{--@section('search')--}}
    {{--@include('backend.elements.search', [ 'url' => route('backend.sitemap.index')])--}}
{{--@endsection--}}

@section('content')

            <div class="row">
                <div class="col-6 col-md-8 col-lg-10">
                    <h4></h4>
                </div>
                <div class="col-6 col-md-4 col-lg-2"><p>
                        <a href="{{ route('backend.sitemap.generate') }}" data-do="link" data-dialog="@lang('backend.fill_db_dialog')"
                           class="btn btn-block btn-sm btn-warning text-uppercase">
                            <span class="fa fa-warning"></span>
                            <b>@lang('backend.fill_db')</b>
                        </a>

                        {{--<a href="{{ route('backend.sitemap.index') }}" class="btn btn-block btn-sm btn-success text-uppercase">--}}
                            {{--<i class="fa fa-plus"></i>--}}
                            {{--@lang('backend.backend.seo-sitemap-create')--}}
                        {{--</a>--}}
                    </p>
                </div>
            </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>@lang('backend.url')</th>
                <th>@lang('backend.priority')</th>
                <th>@lang('backend.changefreq')</th>
                <th>@lang('backend.lastmod')</th>
                <th class="text-center">@lang('backend.active')</th>
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
                            <span class="label label-success">@lang('backend.yes')</span>
                        @else
                            <span class="label label-danger">@lang('backend.no')</span>
                        @endif
                    </td>
                    <td class="text-right">
                        @include('backend.elements.edit_buttons', [
                                'edit_link'    => route('backend.sitemap.edit', ['sitemap'=> $map]),
                                'destroy_link' => route('backend.sitemap.destroy', ['sitemap'=> $map]),
                                'model'        => $map,
                        ])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="bg-warning">
                        <h3 class="text-center">
                            @lang('backend.nothing_found')
                        </h3>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {!! $sitemap->appends(Request::all())->render() !!}
    </div>
@endsection
