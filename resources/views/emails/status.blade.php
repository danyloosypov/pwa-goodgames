<!doctype html>
<html lang="{{ Lang::get() }}">
<?php $single = Single::get('emails')  ?>
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
                {{$single['email']['greetings']}} {{ $order->surname }} {{ $order->name }}!
                    <br> 
                    {{$single['email']['order_status']}}{{ $order->id }} - {{ $order->ordersStatus->title }}
                </div>

                <div style="margin-bottom: 20px; font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 25px;
                color: #242424;">
                    {{$single['email']['total']}}: <b>{{ Field::priceFormat($order->total_price).' ₸' }}</b>
                </div>

                @foreach ($order->ordersProducts as $product)
                    <a target="_blank" href="{{ route('product', ['category' => $product->product->category->slug, 'product' => $product->slug]) }}" style="margin-bottom: 10px; display: flex; align-items: center; text-decoration: none;">
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
                    {{$single['email']['email']}}: <b>{{ $order->email }}</b><br>
                </div>

                <div 
                    style="font-style: normal;
                            font-weight: 400;
                            font-size: 16px;
                            line-height: 25px;
                            color: #242424;
                            margin-bottom: 6px;"
                >
                {!! $single['email']['contacts'] !!}
                </div>

                @foreach ($single['email']['phones'] as $item)
                    <a href="tel:{{ $item['number'] }}" style="font-style: normal;
                    font-weight: 400;
                    font-size: 16px;
                    line-height: 26px;
                    letter-spacing: 0.02em;
                    display:flex;
                    align-items: center;
                    text-decoration: none;
                    color: #2E3B48;
                    margin-bottom: 3px;">     
                        <svg style="margin-right: 10px" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M10.9063 8.9524L9.34002 7.39269C8.78064 6.83565 7.82968 7.05849 7.60592 7.78262C7.43811 8.28397 6.87872 8.56249 6.37527 8.45106C5.2565 8.17254 3.74616 6.72424 3.46647 5.55446C3.29865 5.0531 3.63428 4.49606 4.13773 4.32897C4.86493 4.10616 5.08869 3.15919 4.5293 2.60215L2.96302 1.04245C2.51551 0.652518 1.84424 0.652518 1.45267 1.04245L0.38984 2.10082C-0.672994 3.2149 0.501718 6.1672 3.13083 8.78528C5.75995 11.4034 8.7247 12.6289 9.84347 11.5148L10.9063 10.4564C11.2979 10.0108 11.2979 9.34232 10.9063 8.9524Z" fill="#363636"/>
                        </svg>           
                        {{ $item['number'] }}
                    </a>
                @endforeach
                <a href="mailto:{{ $single['email']['contact_email'] }}" style="font-style: normal;
                font-weight: 400;
                font-size: 16px;
                line-height: 26px;
                letter-spacing: 0.02em;
                display:flex;
                align-items: center;
                text-decoration: none;
                color: #2E3B48;
                margin-bottom: 10px;">
                    <svg style="margin-right: 10px" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                        <path d="M0.25057 2.23022C1.89752 3.62501 4.78741 6.07887 5.63679 6.84398C5.75081 6.94725 5.87311 6.99975 6.00007 6.99975C6.12677 6.99975 6.24886 6.94774 6.36263 6.84497C7.21273 6.0791 10.1026 3.62501 11.7496 2.23022C11.8521 2.14355 11.8678 1.9912 11.7848 1.88524C11.5928 1.64039 11.3067 1.5 11.0001 1.5H1.00008C0.693445 1.5 0.407297 1.64039 0.215414 1.88527C0.132398 1.9912 0.148031 2.14355 0.25057 2.23022Z" fill="#363636"/>
                        <path d="M11.8548 2.9862C11.7661 2.94495 11.6619 2.95934 11.5882 3.02234C10.5095 3.93664 9.08841 5.14465 8.01663 6.06652C7.96024 6.11487 7.9285 6.18591 7.92972 6.26037C7.93094 6.3346 7.96537 6.40465 8.02347 6.45103C9.01933 7.24864 10.5201 8.34582 11.6038 9.1256C11.647 9.15685 11.6983 9.17271 11.7498 9.17271C11.7889 9.17271 11.8279 9.16369 11.8638 9.14513C11.9473 9.1024 11.9998 9.01646 11.9998 8.92271V3.213C11.9998 3.1156 11.9431 3.02698 11.8548 2.9862Z" fill="#363636"/>
                        <path d="M0.396 9.12527C1.47998 8.34548 2.98097 7.24832 3.97657 6.4507C4.03467 6.40431 4.0691 6.33424 4.07032 6.26003C4.07154 6.18557 4.0398 6.11453 3.98341 6.06618C2.91162 5.14431 1.49023 3.9363 0.411633 3.022C0.337406 2.959 0.232922 2.9451 0.145031 2.98586C0.0566484 3.02664 0 3.11526 0 3.21266V8.92239C0 9.01614 0.0525 9.10209 0.135984 9.14481C0.171867 9.16338 0.210938 9.1724 0.250008 9.1724C0.301523 9.1724 0.352781 9.15653 0.396 9.12527Z" fill="#363636"/>
                        <path d="M11.6946 9.80541C10.648 9.05663 8.72 7.66064 7.56912 6.72653C7.47537 6.65012 7.33962 6.65256 7.24735 6.73215C7.02153 6.92917 6.83255 7.0952 6.69851 7.21579C6.28688 7.58737 5.71559 7.58737 5.303 7.2153C5.16945 7.09495 4.9805 6.92842 4.75465 6.73213C4.66311 6.65204 4.52712 6.64961 4.43311 6.72651C3.28613 7.65742 1.35596 9.05513 0.307621 9.80539C0.249261 9.84739 0.211668 9.91208 0.204355 9.98361C0.197277 10.0551 0.220949 10.1262 0.270027 10.1789C0.459261 10.3828 0.725863 10.4998 1.00102 10.4998H11.001C11.2762 10.4998 11.5425 10.3828 11.7322 10.1789C11.7811 10.1264 11.805 10.0554 11.7979 9.98387C11.7906 9.91236 11.753 9.84741 11.6946 9.80541Z" fill="#363636"/>
                    </svg>              
                    {{ $single['email']['contact_email'] }}
                </a>

                <div 
                    style="font-style: normal;
                            font-weight: 400;
                            font-size: 16px;
                            line-height: 25px;
                            color: #242424;
                            margin-bottom: 10px;"
                >
                    {!! Field::enter_to_br($order->date) !!}
                </div>

                <div style="display: flex; align-items: center;">
                    @foreach ($single['email']['socials'] as $item)
                        <a href="{{ $item['link'] }}" target="_blank" style="width: 28px; height: 28px; margin-right: 10px;">
                            <img src="{{ env('APP_URL') }}{{ $item['icon'] }}" alt="" style="width: 28px; height: 28px;">
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- MAIN BODY -->
    </div>
    <!-- MAIN WRAP -->
</body>

</html>