<!doctype html>
<html lang="en">
<script src="./js/qrcodejs-master/qrcode.js"></script>
<script src="./js/qrcodejs-master/jquery.min.js"></script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div id="qrcode"></div>
</body>
</html>
<script>
    // 设置参数方式
    var qrcode = new QRCode('qrcode', {
        text: '{{$code}}',
        width: 256,
        height: 256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });

</script>