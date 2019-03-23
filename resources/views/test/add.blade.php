<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<script src="/js/jquery-3.2.1.min.js"></script>
<body>
<form id="xiu">
    名称：<input type="text" name="name"><br />
    分类：<select name="cate_id">
        @foreach($cate_list as $v)
            <option value="{{$v->cate_id}}">{{$v->cate_name}}</option>
        @endforeach
    </select><br />
    描述：<textarea name="text" id="" cols="30" rows="10"></textarea><br/>
    是否热销：<input type="radio" name="is_hot" value="1">是<input type="radio" name="is_hot" value="0">否<br />
    是否上架：<input type="radio" name="is_sole" value="1">是<input type="radio" name="is_sole" value="0">否<br />
    <input type="button" id="butt" value="提交">
</form>
</body>
</html>
<script>
    $('#butt').click(function(){
        var data = $('#xiu').serialize();
        $.ajax({
            url: '/addDo',
            type: 'POST',
            data: data,
        }).done(function(data) {

            if( data>0 )(
                    window.location.href = '/goodsList'
            )

        })
    })
</script>