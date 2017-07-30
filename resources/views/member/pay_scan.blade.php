<!DOCTYPE html>
<html>
<head>
    <title>扫码支付</title>
    <link rel="stylesheet" href="{{ asset('/web/css/index1.css') }}">
    <script src="{{ asset('/web/js/jquery-2.1.3.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/web/js/base64.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/web/js/jquery.qrcode.js') }}"></script>
    <script type="text/javascript">
        function generateQrcode(url) {
            var options = {
                render: 'image',
                text: url,
                size: 180,
                ecLevel: 'M',
                color: '#222222',
                minVersion: 1,
                quiet: 1,
                mode: 0
            };
            $("#qrcode").empty().qrcode(options);
        }

        $(function(){
            var base64=$('#base64').text();
            generateQrcode(base64);

        })
    </script>
    <style>
        #qrcode img{
            margin: 0 auto;
        }
    </style>
</head>
<body>
<p class="textCenter" style="margin: 100px 0">@if($typeId == 1)请使用支付宝扫描二维码@else请使用微信扫描二维码@endif</p>
<a id="base64" style="display: none">{{ $base64 }}</a>
<div id="qrcode"></div>








</body>
</html>