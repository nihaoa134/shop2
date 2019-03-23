<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>地址管理</title>
    <meta content="app-id=984819816" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/address.css">
    <link rel="stylesheet" href="css/sm.css">



</head>
<body>

<!--触屏版内页头部-->
<div class="m-block-header" id="div-header">
    <strong id="m-title">地址管理</strong>
    <a href="/orderList" class="m-back-arrow">
        <i class="m-public-icon"></i>
    </a>
    <a href="/writeAddress" class="m-index-icon">添加</a>
</div>
<div class="addr-wrapp">
    @foreach( $addressList as $v )
        <div class="addr-list">
            <ul>
                <li class="clearfix">
                    <span class="fl">{{$v -> address_man}}</span>
                    <span class="fr">{{$v -> address_tel}}</span>
                </li>
                <li>
                    <p>{{$v -> address_detail}}</p>
                </li>
                @if( $v -> address_default == 1 )
                    <li class="a-set">
                        <s class="z-set default" address_id="{{$v -> address_id}}" style="margin-top: 6px;"></s>
                        <span>设为默认</span>
                        <div class="fr">
                            <a href="addressUpdate?address_id={{$v -> address_id}}" class="edit" address_id="{{$v -> address_id}}">编辑</a>
                            <span class="remove" address_id="{{$v -> address_id}}">删除</span>
                        </div>
                    </li>
                @else
                    <li class="a-set">
                        <s class="z-defalt default" address_id="{{$v -> address_id}}" style="margin-top: 6px;"></s>
                        <span>设为默认</span>
                        <div class="fr">
                            <a href="addressUpdate?address_id={{$v -> address_id}}" class="edit" address_id="{{$v -> address_id}}">编辑</a>
                            <span class="remove" address_id="{{$v -> address_id}}">删除</span>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    @endforeach
</div>


<script src="js/zepto.js" charset="utf-8"></script>
<script src="js/sm.js"></script>
<script src="js/sm-extend.js"></script>


<!-- 单选 -->
<script>


    // 删除地址
//    $(document).on('click','span.remove', function () {
//        var buttons1 = [
//            {
//                text: '删除',
//                bold: true,
//                color: 'danger',
//                onClick: function() {
//                    $.alert("您确定删除吗？");
//                }
//            }
//        ];
//        var buttons2 = [
//            {
//                text: '取消',
//                bg: 'danger'
//            }
//        ];
//        var groups = [buttons1, buttons2];
//        $.actions(groups);
//    });
</script>
<script src="js/jquery-1.8.3.min.js"></script>
<script>
    var $$=jQuery.noConflict();
    $$(document).ready(function(){
        // jquery相关代码
        $$('.addr-list .a-set s').toggle(
                function(){
                    if($$(this).hasClass('z-set')){

                    }else{
                        $$(this).removeClass('z-defalt').addClass('z-set');
                        $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                    }
                },
                function(){
                    if($$(this).hasClass('z-defalt')){
                        $$(this).removeClass('z-defalt').addClass('z-set');
                        $$(this).parents('.addr-list').siblings('.addr-list').find('s').removeClass('z-set').addClass('z-defalt');
                    }

                }
        )

    });

</script>
<script type="text/javascript">
    $('.default').click(function(){
        var address_id = $(this).attr('address_id');
        var url = 'addressUp';
        $.ajax({
            'url':url,
            'data':{'address_id':address_id},
            'type':'post',
            success:function( msg ){
//                console.log(msg);
            }
        });
    });

    $('.remove').click(function(){
        var address_id = $(this).attr('address_id');
        var url = 'addressDelete';
        $.ajax({
            'url':url,
            'data':{'address_id':address_id},
            'type':'post',
            success:function( msg ){
                console.log(msg);
            }
        });
    });

//    $('.edit').click(function(){
//        var address_id = $(this).attr('address_id');
//        var url = 'addressUpdate';
//        $.ajax({
//            'url':url,
//            'data':{'address_id':address_id},
//            'type':'post',
//            success:function( msg ){
////                console.log(msg);
//            }
//        });
//    });
</script>


</body>
</html>
