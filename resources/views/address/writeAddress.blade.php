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
    <div class="addrcon">
        <ul>
            <li>
                <em>收货人</em>
                <input type="text" class="address_man" name="address_man" placeholder="请填写真实姓名" value="赵恒旭">
            </li>
            <li>
                <em>手机号码</em>
                <input type="number" class="address_tel" name="address_tel" placeholder="请输入手机号" value="17600999005">
            </li>
            <li>
                <em>所在区域</em>
                <input id="demo1" class="area" type="text" name="area" placeholder="请选择所在区域" value="昌平区">
            </li>
            <li class="addr-detail">
                <em>详细地址</em>
                <input type="text" class="address_detail" name="address_detail" placeholder="20个字以内" class="addr" value="哒哒哒哒哒哒">
            </li>
        </ul>
        <div class="setnormal">
            <span>设为默认地址</span>
            <input type="checkbox" name="address_default" lay-skin="switch">
        </div>
    </div>
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
        var data = $('.layui-form').serialize();
        var url = 'addressAdd';
        $.ajax({
            'url':url,
            'data':data,
            'type':'post',
            'dataType':'json',
            success:function( msg ){
                if( msg.status == 1 ){
                    alert( msg.msg );
                    window.location.href ='/orderList';
                }
                if( msg.status == 2 ){
                    alert( msg.msg );
                    window.location.href ='/address';
                }

            }
        });
    });

</script>


</body>
</html>
