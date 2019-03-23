<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<script src="/js/jquery-3.2.1.min.js"></script>
<body>
<form id="xiu">
    <input type="hidden" name="id" value="{{$goods_list[0]->id}}">
    名称：<input type="text" name="name" value="{{$goods_list[0]->name}}"><br />
    分类：<select name="cate_id">
        @foreach($cate_list as $v)
            @if($v->cate_id==$goods_list[0]->cate_id)
                <option value="{{$v->cate_id}}" selected>{{$v->cate_name}}</option>
            @else
                <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
            @endif
        @endforeach
    </select><br />
    描述：<textarea name="text" id="" cols="30" rows="10">{{$goods_list[0]->text}}</textarea><br/>
    是否热销：
    @if($goods_list[0]->is_hot==1)
        <input type="radio" name="is_hot" checked value="1">是<input type="radio" name="is_hot" value="0">否<br />
    @else
        <input type="radio" name="is_hot" value="1">是<input type="radio" name="is_hot" checked value="0">否<br />
    @endif
    是否上架：
    @if($goods_list[0]->is_sole==1)
        <input type="radio" name="is_sole" checked value="1">是<input type="radio" name="is_sole" value="0">否<br />
    @else
        <input type="radio" name="is_sole" value="1">是<input type="radio" name="is_sole" checked value="0">否<br />
    @endif
    <input type="button" id="butt" value="修改">
</form>
</body>
</html>
<script>
    $('#butt').click(function(){
        var data = $('#xiu').serialize();
        $.ajax({
            url: '/updateDo',
            type: 'POST',
            data: data,
        }).done(function(data) {
            if(data==1){
                alert("修改成功");
                window.location.href="/goodsList";
            }else{
                alert("修改失败");
            }
        })
    })
</script>