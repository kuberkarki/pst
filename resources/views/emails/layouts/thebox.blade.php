<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<div style="background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px; margin:0; padding:0;">
<table cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
    <td align="center" valign="top" style="padding:20px 0 20px 0">
        <!-- [ header starts here] -->
        <table bgcolor="#FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #E0E0E0;">
            <tr>
                <td valign="top" align="center"><a href="{{ url('/')}}"><img src="{{ $settings->attigo__storefront_logo_link__c }}" alt="{{ $settings->attigo__store_name__c}}"  style="margin-bottom:10px;" border="0"/></a></td>
            </tr>
        <!-- [ middle starts here] -->
            @yield('content')
            <tr>
                <td bgcolor="#EAEAEA" align="center" style="background:#EAEAEA; text-align:center;"><center><p style="font-size:12px; margin:0;">{{$settings->attigo__new_order_mail_footer__c}}</p></center></td>
            </tr>
        </table>
    </td>
</tr>
</table>
</div>
</body>
</html>




