@props(['content'])

@php
    if (is_string($content)) {
        // Simple fallback for old string content
        $blocks = [[
            'type' => 'paragraph',
            'data' => ['text' => $content]
        ]];
    } else {
        $blocks = is_array($content) ? ($content['blocks'] ?? []) : [];
    }
@endphp

<div class="editorjs-content space-y-6">
    @foreach($blocks as $block)
        @switch($block['type'])
            @case('paragraph')
                <p class="text-slate-800 dark:text-slate-200 text-sm sm:text-base md:text-lg leading-relaxed">
                    {!! str_replace(['**', '__'], ['<b>', '<b>'], str_replace(['** ', ' **'], ['<b>', '</b>'], $block['data']['text'])) !!}
                </p>
                @break

            @case('header')
                @php $level = $block['data']['level'] ?? 2; @endphp
                <h{{ $level }} class="font-black text-slate-900 dark:text-white uppercase italic border-l-4 border-blue-600 pl-4 leading-tight
                    {{ $level == 1 ? 'text-2xl sm:text-4xl' : '' }}
                    {{ $level == 2 ? 'text-xl sm:text-3xl mt-8' : '' }}
                    {{ $level == 3 ? 'text-lg sm:text-2xl mt-6' : '' }}
                    {{ $level > 3 ? 'text-base sm:text-xl mt-4' : '' }}">
                    {!! $block['data']['text'] !!}
                </h{{ $level }}>
                @break

            @case('list')
                <ul class="{{ ($block['data']['style'] ?? 'unordered') === 'ordered' ? 'list-decimal' : 'list-disc' }} ml-6 space-y-2 text-slate-800 dark:text-slate-200">
                    @foreach($block['data']['items'] ?? [] as $item)
                        <li>{!! $item !!}</li>
                    @endforeach
                </ul>
                @break

            @case('math')
                <div class="my-6 p-6 bg-blue-50 dark:bg-blue-900/10 rounded-2xl border-2 border-blue-100 dark:border-blue-500/20 text-center">
                    $${!! $block['data']['formula'] !!}$$
                </div>
                @break

            @case('visualization')
                <div class="my-8">
                    <x-visualization :data="$block['data']" />
                </div>
                @break
        @endswitch
    @endforeach
</div>
