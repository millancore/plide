@props([
    'trim',
    'noescape',
    'lines',
])

<pre>
    <code {{$attributes}}
            @if($trim) data-trim @endif
            @if($noescape) data-noescape @endif
            @if($lines) data-line-numbers="{{$lines}}" @endif
    >
        <script type="text/template">
            {!! $slot !!}
        </script>
    </code>
</pre>