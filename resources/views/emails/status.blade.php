<!doctype html>
<html lang="{{ Lang::get() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body style="font-family: 'Arial';">
    <div class="main_wrap" style="max-width: 700px;
        width: 100%;
        margin: 0 auto;
        padding: 35px 25px;">
        <div class="main_body" style="position: relative;">

            <div class="header" style="background: #2E3B48; padding: 5px 100px; text-align: center;">
                <div class="logo" style="display: flex;">
                    <a href="{{ route('home', [], true) }}" target="_blank">
                        <img src="{{ env('APP_URL') }}/images/logo.png" alt="" style="vertical-align: middle; width: 150px; height: 40px; object-fit: contain;">
                    </a>
                </div>
            </div>

            <div class="content" style="background: #FFFFFF; padding: 25px 100px;">
                
                <div 
                    style="font-style: normal;
                            font-weight: 400;
                            font-size: 16px;
                            line-height: 25px;
                            color: #242424; 
                            margin-bottom: 30px;"
                >
                    Вітаємо: {{ $order->surname }} {{ $order->name }}!
                    <br> 
                    Статус Вашого замовлення №{{ $order->id }} - {{ $order->orderStatus->title }}
                </div>

                <div style="margin-bottom: 20px; font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 25px;
                color: #242424;">
                    Тотал: <b>{{ $order->total_price .' грн.' }}</b>
                </div>

                @foreach ($order->orderProducts as $product)
                    <a target="_blank" href="{{ route('product', ['product' => $product->product->slug]) }}" style="margin-bottom: 10px; display: flex; align-items: center; text-decoration: none;">
                        <img src="{{ env('APP_URL') }}/{{ $product->image }}" alt="" style="width: 80px; height: 80px; margin-right: 12px; object-fit: contain;">
                        <div style="font-style: normal;
                        font-weight: 700;
                        font-size: 13px;
                        line-height: 18px;
                        letter-spacing: 0.02em;
                        text-transform: uppercase;
                        color: #2E3B48; width:250px;">{{ $product->title }}</div> 
                    </a>
                @endforeach

                <div 
                    style="font-style: normal;
                            font-weight: 400;
                            font-size: 16px;
                            line-height: 25px;
                            color: #242424; 
                            margin-top: 10px;
                            margin-bottom: 45px;"
                >                    
                    <br>
                    Емейл: <b>{{ $order->email }}</b><br>
                </div>

                <div 
                    style="font-style: normal;
                            font-weight: 400;
                            font-size: 16px;
                            line-height: 25px;
                            color: #242424;
                            margin-bottom: 10px;"
                >
                    {!! $order->date !!}
                </div>
            </div>
        </div>
        <!-- MAIN BODY -->
    </div>
    <!-- MAIN WRAP -->
</body>

</html>