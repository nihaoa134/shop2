<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>填写收货地址</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/writeaddr.css">
    <link rel="stylesheet" href="layui/css/layui.css">
    <link rel="stylesheet" href="dist/css/LArea.css">
</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">填写收货地址</strong>
    <a href="javascript:history.back();" class="m-back-arrow"><i class="m-public-icon"></i></a>
    <a href="javascript:;" class="m-index-icon">保存</a>
</div>
<div class=""></div>
<!-- <form class="layui-form" action="">
  <input type="checkbox" name="xxx" lay-skin="switch">

</form> -->
<form class="layui-form" action="">
    @foreach( $addressList as $v )
        <div class="addrcon">
            <ul address_id="{{$v -> address_id}}">
                <li>
                    <em>收货人</em>
                    <input type="text" class="address_man" name="address_man" placeholder="请填写真实姓名" value="{{$v -> address_man}}">
                </li>
                <li>
                    <em>手机号码</em>
                    <input type="number" class="address_tel" name="address_tel" placeholder="请输入手机号" value="{{$v -> address_tel}}">
                </li>
                <li>
                    <em>所在区域</em>
                    <input id="demo1" class="area" type="text" name="area" placeholder="请选择所在区域" value="{{$v -> area}}">
                </li>
                <li class="addr-detail">
                    <em>详细地址</em>
                    <input type="text" class="address_detail" name="address_detail" placeholder="20个字以内" class="addr" value="{{$v -> address_detail}}">
                </li>
            </ul>
        </div>
    @endforeach
</form>

<!-- SUI mobile -->
<script src="dist/js/LArea.js"></script>
<script src="dist/js/LAreaData1.js"></script>
<script src="dist/js/LAreaData2.js"></script>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="layui/layui.js"></script>

<script type="text/javascript">
    //Demo
    layui.use('form', function(){
        var form = layui.form();

        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });


    //保存
    $('.m-index-icon').click(function(){
        var address_man = $('.address_man').val();
        if( address_man == '' ){
            alert('请输入你的收货名字');
            return false;
        }

        var address_tel = $('.address_tel').val();
        if( address_tel == '' ){
            alert('请输入你的手机号');
            return false;
        }

        var area = $('.area').val();
        if( address_man == '' ){
            alert('请输入你的所在区域');
            return false;
        }

        var address_detail = $('.address_detail').val();
        if( address_man == '' ){
            alert('请输入你的详细地址');
            return false;
        }


        var address_id = $('.addrcon ul').attr('address_id');
        var data = {};
        data.address_man = address_man;
        data.address_tel = address_tel;
        data.area = area;
        data.address_detail = address_detail;
        data.address_id = address_id;
        var url = '/updateDo';
        $.ajax({
            'url':url,
            'data':data,
            'type':'post',
            'dataType':'json',
            success:function( msg ){
                if( msg.status == 1 ){
                    alert( msg.msg );
                    window.location.href ='/address';
                }else{
                    alert( msg.msg );
                    window.location.href ='/address';
                }
            }
        });
    });

</script>


</body>
</html>