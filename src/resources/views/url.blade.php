<url>
    <loc>{{ $alias }}</loc>
    @if(!is_null($changefreq))
        <changefreq>{{ $changefreq }}</changefreq>
    @endif
    @if(0 < $priority)
        <priority>{{ $priority }}</priority>
    @endif
    @if(!is_null($lastmod))
        <lastmod>{{ $lastmod }}</lastmod>
    @endif
</url>