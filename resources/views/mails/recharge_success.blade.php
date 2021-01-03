<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;width:600px;border-collapse:collapse;background-color:#ffffff">
    <tbody>
        <tr>
            <td colspan="2" style="padding:0px 10px">
                <table border="0" cellpadding="0" cellspacing="0" style="width:100%;border-collapse:collapse">
                    <tbody>
                        <tr>
                            <td style="padding:0px 25px;color:#333333;font-family:Arial;border-top:1px solid #cbcbcb">
                                <p
                                    style="font-size:16px;font-weight:bold;color:#333333;font-family:Arial;text-align:center">
                                    Thông tin nạp tiền vào tài khoản</p>
                                <p
                                    style="font-size:15px;line-height:180%;margin:10px 0px;color:#333333;font-family:Arial">
                                    Xin chào <a href="mailto:{{$owner->email}}"
                                        target="_blank">{{$owner->email}}</a>,</p>
                                <p
                                    style="font-size:14px;line-height:180%;margin:10px 0px;color:#333333;font-family:Arial">
                                    Cảm ơn quý khách đã sử dụng dịch vụ của <a href="{{config('app.url')}}"
                                        target="_blank"
                                        >{{config('app.name')}}</a>.
                                    Thông tin giao dịch nạp tiền của quý khách như sau:</p>
                                <table border="0"
                                    style="width:100%;border-collapse:collapse;border:none;font-size:14px;line-height:180%;margin:10px 0px;color:#333333;font-family:Arial">
                                    <tbody>
                                        <tr>
                                            <td style="width:40%">
                                                Mã giao dịch:</td>
                                            <td style="text-align:right">
                                                <b>{{$bill->bill_code}}</b>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Thời gian giao dịch:</td>
                                            <td style="text-align:right">
                                                {{\Carbon\Carbon::parse($bill->updated_at)->format('d-m-y H:i:s A')}}</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Phương thức thanh toán:</td>
                                            <td style="text-align:right">
                                                {{$payment_type}}</td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                &nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <b>Số tiền đã nạp:</b>
                                            </td>
                                            <td style="text-align:right">
                                                <b>{{number_format($bill->amount_of_money,0,'.', '.')}} đ</b>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p
                                    style="font-size:14px;line-height:180%;margin:10px 0px;color:#333333;font-family:Arial">
                                    Nếu Quý khách cần hỗ trợ, vui lòng liên hệ hotline <a href="tel:{{$theme_options['Số_điện_thoại']}}"
                                        style="font-size:14px;color:#333333;font-family:Arial;text-decoration:none"
                                        target="_blank">{{$theme_options['Số_điện_thoại']}}</a> hoặc email <a
                                        href="mailto:{{$theme_options['Email_công_ty']}}"
                                        target="_blank">{{$theme_options['Email_công_ty']}}</a> để được trợ giúp.</p>
                                <p
                                    style="font-size:14px;line-height:180%;margin:10px 0px;color:#333333;font-family:Arial">
                                    Trân trọng cảm ơn,<br>
                                    <a href="{{config('app.url')}}"
                                        style="font-size:14px;color:#333333;font-family:Arial;text-decoration:none"
                                        target="_blank"
                                       >{{config('app.name')}}</a>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="border-top:2px solid #055699">
                <p style="font-size:16px;color:#333333;font-family:Arial;text-align:center;font-weight:bold">
                    Công ty Cổ phần PropertyGuru Việt Nam</p>
                <p style="font-size:12px;color:#333333;font-family:Arial;text-align:center">
                    Tầng 31, Keangnam Hanoi Landmark Tower, Hà Nội<br>
                    hotline <a href="tel:19001881"
                        style="font-size:12px;color:#333333;font-family:Arial;text-decoration:none" target="_blank">1900
                        1881</a>.<br>
                    <a href="mailto:hotro@batdongsan.com.vn"
                        style="font-size:12px;color:#333333;font-family:Arial;text-decoration:none"
                        target="_blank">hotro@batdongsan.com.vn</a>
                </p>
            </td>
        </tr>
    </tbody>
</table>
