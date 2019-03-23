<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>购物车</title>
    <meta content="app-id=518966501" name="apple-itunes-app" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no, maximum-scale=1.0" />
    <meta content="yes" name="apple-mobile-web-app-capable" />
    <meta content="black" name="apple-mobile-web-app-status-bar-style" />
    <meta content="telephone=no" name="format-detection" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link href="css/comm.css" rel="stylesheet" type="text/css" />
    <link href="css/cartlist.css" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body id="loadingPicBlock" class="g-acc-bg">
<input name="hidUserID" type="hidden" id="hidUserID" value="-1" />
<div>
    <!--首页头部-->
    <div class="m-block-header">
        <a href="/" class="m-public-icon m-1yyg-icon"></a>
        <a href="/" class="m-index-icon">编辑</a>
    </div>
    <!--首页头部 end-->
    <div class="g-Cart-list">
        @if( $List )
        <ul id="cartBody">
            @foreach( $List as $v )
                <li price="{{$v -> add_price}}">
                <s class="xuan current" cart_id="{{$v -> cart_id}}"></s>
                <a class="fl u-Cart-img" href="/v44/product/12501977.do">
                    <img src="{{env('STATIC_URL')}}{{$v -> goods_img}}" border="0" alt="">
                </a>
                <div class="u-Cart-r">
                    <a href="/v44/product/12501977.do" class="gray6">{{$v -> goods_name}}</a>
                        <span class="gray9">
                            <em class="price" >价格：￥{{$v -> add_price}}</em>
                        </span>
                    <div class="num-opt">
                        <em class="num-mius dis min" goods_id="{{$v -> goods_id}}" cart_id="{{$v -> cart_id}}"><i></i></em>
                        <input class="text_box" name="num" maxlength="6" goods_id="{{$v -> goods_id}}" cart_id="{{$v -> cart_id}}" type="number" value="{{$v -> buy_number}}" codeid="12501977">
                        <em class="num-add add" goods_id="{{$v -> goods_id}}" cart_id="{{$v -> cart_id}}"><i></i></em>
                    </div>
                    <a href="javascript:;" name="delLink" cid="12501977" isover="0" class="z-del" cart_id="{{$v -> cart_id}}"><s></s></a>
                </div>
            </li>
            @endforeach
        </ul>
        @else
        <div id="divNone" class="empty "  style="display: none">
            <s></s>
            <p>您的购物车还是空的哦~</p>
            <a href="https://m.1yyg.com" class="orangeBtn">立即潮购</a>
        </div>
        @endif
    </div>

    <div id="mycartpay" class="g-Total-bt g-car-new" style="">
        <dl>
            <dt class="gray6">
                <s class="quanxuan current"></s>全选
            <p class="money-total">合计<em class="orange total"><span>￥</span>17.00</em></p>

            </dt>
            <dd>
                <a href="javascript:;" id="a_payment" class="orangeBtn w_account remove">删除</a>
                <a href="javascript:;" id="a_payment" class="orangeBtn w_account close">去结算</a>
            </dd>
        </dl>
    </div>
    <div class="hot-recom">
        <div class="title thin-bor-top gray6">
            <span><b class="z-set"></b>人气推荐</span>
            <em></em>
        </div>
        <div class="goods-wrap thin-bor-top">
            <ul class="goods-list clearfix">
                @foreach( $goodsList as $v )
                    <li>
                    <a href="/particulars?goods_id={{$v -> goods_id}}" class="g-pic">
                        <img src="{{env('STATIC_URL')}}{{$v -> goods_img}}" width="136" height="136">
                    </a>
                    <p class="g-name">
                        <a href="https://m.1yyg.com/v44/products/23458.do">(第<i>368671</i>潮){{$v -> goods_name}}</a>
                    </p>
                    <ins class="gray9">价值:￥{{$v -> goods_selfprice}}</ins>
                    <div class="btn-wrap">
                        <div class="Progress-bar">
                            <p class="u-progress">
                                    <span class="pgbar" style="width:1%;">
                                        <span class="pging"></span>
                                    </span>
                            </p>
                        </div>
                        <div class="gRate" data-productid="23458">
                            <a href="javascript:;"><s></s></a>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>




    <div class="footer clearfix">
        <ul>
            <li class="f_home"><a href="/index" ><i></i>潮购</a></li>
            <li class="f_announced"><a href="/allShops" ><i></i>最新揭晓</a></li>
            <li class="f_single"><a href="/v41/post/index.do" ><i></i>晒单</a></li>
            <li class="f_car"><a id="btnCart" href="" class="hover"><i></i>购物车</a></li>
            <li class="f_personal"><a href="/v41/member/index.do" ><i></i>我的潮购</a></li>
        </ul>
    </div>

    <script src="js/jquery-1.11.2.min.js"></script>
    <!---商品加减算总数---->
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function(){
            $('.text_box').blur(function(){
                var t = $(this);
                var number = $(this).val();
                if( number<1 ){
                    t.val(1);
                    number = 1;
                }
                if( isNaN(number) ){
                    t.val(1);
                    number = 1;
                }
                var cart_id = $(this).attr('cart_id');
                var goods_id = $(this).attr('goods_id');
                var data = {};
                data.number = number;
                data.cart_id = cart_id;
                data.goods_id = goods_id;
                var url = '/cart';
                $.ajax({
                    url:url,
                    data:data,
                    type:"post",
                    dataType:"json",
                    success: function (msg) {
                        if( msg.status == 0 ){
                            alert(msg.msg);
                            t.val(msg.num);
                        }
                    }
                })

                GetCount();
            });
        })

        $(function () {
            $(".add").click(function () {
                var t = $(this).prev();
                t.val(parseInt(t.val()) + 1 );
                var number = parseInt(t.val());
                var cart_id = $(this).attr('cart_id');
                var goods_id = $(this).attr('goods_id');
                var data = {};
                data.number = number;
                data.cart_id = cart_id;
                data.goods_id = goods_id;
                var url = '/cart';
                $.ajax({
                    url:url,
                    data:data,
                    type:"post",
                    dataType:"json",
                    success: function (msg) {
                        if( msg.status == 0 ){
                            alert(msg.msg);
                            t.val(msg.num);
                        }
                    }
                })

                GetCount();
            })


            $(".min").click(function () {
                var t = $(this).next();
                var goods_id = $(this).attr('goods_id');
                var cart_id = $(this).attr('cart_id');
                if(t.val()>1){
                    t.val(parseInt(t.val()) - 1);
                    var number = parseInt(t.val());
                    var data = {};
                    data.number = number;
                    data.cart_id = cart_id;
                    data.goods_id = goods_id;
                    var url = '/cart';
                    $.ajax({
                        url:url,
                        data:data,
                        type:"post",
                        dataType:"json",
                        success: function (msg) {
                            if( msg.status == 0 ){
                                alert(msg.msg);
                                t.val(msg.num);
                            }
                        }
                    })


                    GetCount();
                }
            })
        })

    </script>


    <script>

        // 全选
        $(".quanxuan").click(function () {
            if($(this).hasClass('current')){
                $(this).removeClass('current');

                $(".g-Cart-list .xuan").each(function () {
                    if ($(this).hasClass("current")) {
                        $(this).removeClass("current");
                    } else {
                        $(this).addClass("current");
                    }
                });
                GetCount();
            }else{
                $(this).addClass('current');

                $(".g-Cart-list .xuan").each(function () {
                    $(this).addClass("current");
                    // $(this).next().css({ "background-color": "#3366cc", "color": "#ffffff" });
                });
                GetCount();
            }


        });
        // 单选
        $(".g-Cart-list .xuan").click(function () {
            if($(this).hasClass('current')){


                $(this).removeClass('current');

            }else{
                $(this).addClass('current');
            }
            if($('.g-Cart-list .xuan.current').length==$('#cartBody li').length){
                $('.quanxuan').addClass('current');

            }else{
                $('.quanxuan').removeClass('current');
            }
            // $("#total2").html() = GetCount($(this));
            GetCount();
            //alert(conts);
        });
        // 已选中的总额
        function GetCount() {
            var conts = 0;
            var aa = 0;
            $(".g-Cart-list .xuan").each(function () {
                if ($(this).hasClass("current")) {
                    for (var i = 0; i < $(this).length; i++) {
                        conts += parseInt($(this).parents('li').find('input.text_box').val()) * parseInt($(this).parents('li').attr('price'));
                        // aa += 1;
                    }
                }
            });

            $(".total").html('<span>￥</span>'+(conts).toFixed(2));
        }
        GetCount();
    </script>
    <script type="text/javascript">

        //单删
        $(document).on('click' , '.z-del' , function(){
            var cart_id = $(this).attr('cart_id');
            var data = {};
            data.cart_id = cart_id;
            var url = 'cartDelete';
            $.ajax({
                url:url,
                data:data,
                dataType:'json',
                type:'post',
                success:function( msg ){
                    if( msg.status == 0 ){
                        alert( msg.msg );
                    }else{
                        alert( msg.msg );
                        window.location.reload();
                    }
                }
            });

        })


        //批删
        $(document).on('click' , '.remove' , function(){
            var arr = [];
            $(".g-Cart-list .xuan").each(function () {
                if ($(this).hasClass("current")) {
                    arr.push($(this).attr('cart_id'));
                }
            })
                var url = 'cartDeletes';
                $.ajax({
                    url:url,
                    type:'post',
                    data:{'arr':arr},
                    success:function( msg ){
                        if( msg.status == 0 ){
                            alert( msg.msg );
                        }else{
                            alert(msg.msg);
                            window.location.reload();
                        }
                    }
                });

            });

        //结算
        $(document).on('click','.close',function(){
            var arr = [];
            $(".g-Cart-list .xuan").each(function () {
                if ($(this).hasClass("current")) {
                    arr.push($(this).attr('cart_id'));
                }
            })
            var url = 'orderAdd';
            $.ajax({
                url:url,
                type:'post',
                data:{'arr':arr},
                success:function(msg){
                    if( msg.status == 0 ){
                        alert( msg.msg );
                        window.location.href ='/login';
                    }

                    if( msg.status == 3 ){
                        alert( msg.msg );
                    }

                    if( msg.status == 2 ){
                        alert( msg.msg );
                    }else{
                        alert( msg.msg );
                        window.location.href ='/orderList';
                    }

                }
            });
        });


    </script>
</body>
</html>
