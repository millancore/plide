{{--
   Defined here to be dectected by Laravel IDE Plugins
--}}
@props([
    // Colors
   'bg-color',
   'bg-gradient',

    // Images
    'bg-image',
    'bg-position',
    'bg-repeat',

    // Video
    'bg-video',
    'bg-video-loop',
    'bg-video-muted',

    // Iframe
    'bg-iframe',
    'bg-interactive',

    // General
    'bg-size',
    'bg-opacity',
])

<section
        {{ $attributes }}
        {!! \Plide\View\Attributes::resolve(\Plide\Enum\Slide::Slide, get_defined_vars()) !!}
>

    {{ $slot }}

</section>