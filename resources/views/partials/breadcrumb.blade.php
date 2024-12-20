<div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
        @foreach($lists as $item)
            <li class="breadcrumb-item {{$loop->last? 'active': ''}}">
                @if($loop->last || $item['link']=='#')
                    {{$item['name']}}
                @else
                    @php($link = $item['link'])

                    @if(isset($type) && $type=='link')
                        <a href="{{$link}}">{{$item['name']}}</a>
                    @elseif(isset($item['param']))
                        <a href="{{route($link,$item['param'])}}">{{ $item['name']}}</a>
                    @else
                        <a href="{{route($link)}}">{{$item['name']}}</a>

                    @endif
                @endif

            </li>
        @endforeach
    </ol>
</div>
