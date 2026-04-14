@if($description)
<meta name="description" content="{{ Str::limit($description, 320) }}">
@endif

@if(config('geo.schema.include_organization'))
{!! app('geo.schema')->organization()->render() !!}
@endif

{!! $schemas !!}
