<table border="" id="show">
    <tr>
        <td>id</td>
        <td>名称</td>
        <td>分类</td>
        <td>描述</td>
        <td>是否热销</td>
        <td>是否上架</td>
        <td>操作</td>
    </tr>
    @foreach( $goods_list as $v )
        <tr>
            <td>{{$v -> id}}</td>
            <td id="{{$v->id}}"><span class="mobile">{{$v->name}}</span></td>
            <td>{{$v -> cate_name}}</td>
            <td>{{$v -> text}}</td>
            <td>
                @if( $v -> is_hot == 1 )
                    是
                @else
                    否
                @endif
            </td>
            <td>
                @if( $v -> is_sole == 1 )
                    是
                @else
                    否
                @endif
            </td>
            <td>
                <a href="javascript:;" onclick="del({{$v -> id}})">删除</a>
                <a href="update/{{$v -> id}}">修改</a>
            </td>
        </tr>
    @endforeach
</table>
{{--<div id="page">--}}
    {{--{{ $goods_list -> links() }}--}}
{{--</div>--}}