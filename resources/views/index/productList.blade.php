@foreach($product as $list)
    <li>
        <a href="javascript:;" class="g-pic">
                <img class="lazy" name="goodsImg" src="{{$list -> goods_img}}" data-original="https://img.1yyg.net/GoodsPic/pic-200-200/20161103170504456.jpg" width="136" height="136">
        </a>
        <p class="g-name">{{$list -> goods_name}}</p>
        <ins class="gray9">价格：￥{{$list -> goods_selfprice}}</ins>
        <div class="Progress-bar">
            <p class="u-progress">
            <span class="pgbar" style="width: 96.43076923076923%;">
                <span class="pging"></span>
            </span>
            </p>
        </div>
        <div class="btn-wrap" name="buyBox" limitbuy="0" surplus="58" totalnum="1625" alreadybuy="1567">
            <a href="/particulars?goods_id={{$list -> goods_id}}" class="buy-btn" codeid="12751965" >立即潮购</a>
            <div class="gRate" codeid="12751965" canbuy="58">
                <a href="javascript:;"  style="margin-left: 33px;"></a>
            </div>
        </div>
    </li>
@endforeach