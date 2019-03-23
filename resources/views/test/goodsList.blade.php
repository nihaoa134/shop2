<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
</head>
<script src="/js/jquery-3.2.1.min.js"></script>
<style>
    .pagination li{float:left;margin-left: 20px;list-style: none;}
</style>
<body>

<form action="">
    热销：<select name="" id="is_hot">
        <option value="1">是</option>
        <option value="0">否</option>
    </select>
    上架<select name="" id="is_sole">
        <option value="1">是</option>
        <option value="0">否</option>
    </select>
    <input type="button" id="butt" value="搜索">
</form>

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
                @if( $v -> is_hot = 1 )
                    是
                @else
                    否
                @endif
            </td>
            <td>
                @if( $v -> is_sole = 1 )
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
<div id="page">
    {{ $goods_list -> links() }}
</div>
</body>
</html>

<script>

    $(document).on('click','#butt',function(){

        var is_hot = $('#is_hot').val();

        var is_sole = $('#is_sole').val();

        $.ajax({
            url: "/goodsSelect",
            type: "POST",
            data: {is_hot: is_hot,is_sole: is_sole},
        }).done(function(msg){
            $('#show').html(msg);
        })

    })



    $(document).on('click','.mobile',function(){

        var mobile = $(this).text();


        $(this).parent().html('<input class=ajaxupd type=text value='+mobile+'>');

    })


    $(document).on('blur','.ajaxupd',function(){

        var data = $(this).val();

        var id = $(this).parent().attr('id');

        var obj = $(this);

        $.ajax({
            url: "/ajaxUpd",
            type: "POST",
            data: {data: data,id: id},
        }).done(function(msg){

            if( msg == 1){

                obj.parent().html('<span class="mobile">'+data+'</span>');

            }else{

                alert("修改失败");

            }

        })

    })


    function del(id){

        if( confirm("小仙女确定要删除么~") ){

            $.ajax({
                url:'/delete',
                type: 'POST',
                data: {id:id},
            }).done(function( msg ){
                if( msg == 1 ){

                    alert('删除成功');
                    window.location.reload();

                }else{

                    alert("删除失败");

                }

            })

        }



    }

</script>