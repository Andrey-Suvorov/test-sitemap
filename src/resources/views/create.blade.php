@extends('sitemap::layouts.app')

@section('title', __('sitemap::sitemap.create'))

@section('content')
    <div class="panel panel-default user-panel panel-flat">
        <div class="panel-body">
            {!! Form::open(['route' => [config('sitemap.route_prefix') . '.sitemap.store'],'method'=>'POST','autocomplete'=>'off','files'=>true,'class'=>'needs-validation','novalidate']) !!}
                @include('sitemap::fields')
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