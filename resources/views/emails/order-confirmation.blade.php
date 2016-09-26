@extends('emails/layouts/thebox')

@section('content')
<tr>
    <td valign="top">
        <h1 style="font-size:22px; font-weight:normal; line-height:22px; margin:0 0 11px 0;">{{ str_replace('%%name%%',$user->first_name.' '.$user->last_name,$settings->attigo__new_order_mail_headline__c) }}</h1>
        <p style="font-size:12px; line-height:16px; margin:0 0 10px 0;">
          {{$settings->attigo__new_order_mail_text_block_1__c}}
        </p>
        <p style="font-size:12px; line-height:16px; margin:0;">Nedan finns din orderbekräftelse. Tack för att du handlar hos Matilde & Co.</p>
    </td>
</tr>
<tr>
    <td>
        <h2 style="font-size:18px; font-weight:normal; margin:0;">Ditt ordernummer #{{ $orders->attigo__ecom_externalid_c__c }} <small></small></h2>
    </td>
</tr>

<tr>
  <td>
  <table cellspacing="0" cellpadding="0" border="0" width="650">
      <thead>
      <tr>
          <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Betalningsinformation:</th>
          <th width="10"></th>
          <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Betalningsmetod:</th>
      </tr>
      </thead>
      <tbody>
      <tr>
          <td valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">
             <table cellspacing="0" cellpadding="0" border="0" width="100%">
                @if($orders->billingstreet)
                <tr>
                  <td>Billing Street</td><td>{{$orders->billingstreet}}</td>
                </tr>
                @endif
                @if($orders->billingcity)
                <tr>
                  <td>Billing city</td><td>{{$orders->billingcity}}</td>
                </tr>
                 @endif
                @if($orders->billingstate)
                <tr>
                  <td>Billing State</td><td>{{$orders->billingstate}}</td>
                </tr>
                 @endif
                @if($orders->billingcountry)
                <tr>
                  <td>Billing Country</td><td>{{$orders->billingcountry}}</td>
                </tr>
                 @endif
                
              </table>
          </td>
          <td>&nbsp;</td>
          <td valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">
             
             {{ $orders->attigo__e_com_payment_type__c}}
          </td>
      </tr>
      </tbody>
  </table>
  <br/>
                   
  <table cellspacing="0" cellpadding="0" border="0" width="100%">
      <thead>
      <tr>
          <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Leveransinformation:</th>
          <th width="10"></th>
          <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Fraktsätt:</th>
      </tr>
      </thead>
      <tbody>
      <tr>
          <td valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">
             <table cellspacing="0" cellpadding="0" border="0" width="100%">
                @if($orders->shippingstreet)
                <tr>
                  <td>Shipping Street</td><td>{{$orders->shippingstreet}}</td>
                </tr>
                 @endif
                @if($orders->shippingcity)
                <tr>
                  <td>Shipping city</td><td>{{$orders->shippingcity}}</td>
                </tr>
                 @endif
                @if($orders->shippingstate)
                <tr>
                  <td>Shipping State</td><td>{{$orders->shippingstate}}</td>
                </tr>
                 @endif
                @if($orders->shippingcountry)
                <tr>
                  <td>Shipping Country</td><td>{{$orders->shippingcountry}}</td>
                </tr>
                 @endif
              </table>
          </td>
          <td>&nbsp;</td>
          <td valign="top" style="font-size:12px; padding:7px 9px 9px 9px; border-left:1px solid #EAEAEA; border-bottom:1px solid #EAEAEA; border-right:1px solid #EAEAEA;">
             {{ $orders->attigo__e_com_shipment__c }}
          </td>
      </tr>
      </tbody>
  </table>
  <br/>
  
  <table cellspacing="0" cellpadding="0" border="0" width="100%">
             <thead>  
              <tr>
                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Name</th>
                <th align="left" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">PCode</th>
                 <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Option</th>
                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Quantity</th>
                <th align="left"  bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Unit Price</th>
                <th align="left" width="325" bgcolor="#EAEAEA" style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Vat(%)</th>
                <th lign="left" width="325" bgcolor="#EAEAEA">Line total</th>
              </tr>
        </thead>
        <tbody>
          @foreach($orders->summary as $summary)
            @if($summary['product_name']!='Shipping cost')
            <tr>
              <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{$summary['product_name']}}</td>
               <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{!! $summary['product_code'] !!}</td>
              <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{!! $summary['language'] !!}</td>
              <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{$summary['quantity']}}</td>
               <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{ $summary['listprice']>0?number_format($summary['listprice'],2,'.','')." kr":'Free'}}</td>
               <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{$summary['vat_pc']}}</td>
               <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{$summary['listprice']*$summary['quantity']+($summary['listprice']*$summary['quantity'])*$summary['vat_pc']*.01 }} kr</td>
            </tr>
            @endif
          @endforeach
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Shipping</td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{number_format($orders->shipping_cost,2,'.','')}} kr</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Subtotal (excl Tax)</td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{number_format($orders->totalamount,2,'.','')}} kr</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Vat</td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{{number_format($orders->attigo__vat__c,2,'.','')}} kr</td>
          </tr>

          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">Grand Total</td>
            <td style="font-size:13px; padding:5px 9px 6px 9px; line-height:1em;">{!! number_format((float)$orders->totalamount+(float)$orders->attigo__vat__c,2,'.','') !!} kr</td>
          </tr>
      </tbody>
   </table>

  
  <p style="font-size:12px; margin:0 10px 10px 0"></p>
</td>
</tr>
@stop








@section('old_content')

<p>Hello {!! $user->first_name !!},</p>


<h4> Your Attigo One Order Confirmation</h4>
  @if(count($orders)==1)
  <table class="table">
    <tr>
      <td>Date</td>
      <td>{{$orders->createddate}}</td>
    </tr>
    <tr>
      <td>Order Number</td>
      <td>{{$orders->ordernumber}}</td>
    </tr>
    
    <tr>
      <td>Amount</td>
      <td>{{number_format($orders->totalamount,2,'.','')}}</td>
    </tr>
    <tr>
      <td>Vat</td>
      <td>{{number_format($orders->vat__c,2,'.','')}}</td>
    </tr>
    <tr>
      <td>Total</td>
      <td>{!! number_format((float)$orders->totalamount+(float)$orders->vat__c,2,'.','') !!}</td>
    </tr>

  </table>
    <h3>Products</h3>
   
      <table class="table">
          <tr>
            <td>Name</td>
            <td>Quantity</td>
            <td>Price</td>
          </tr>
        @foreach($orders->summary as $summary)
          @if($summary['product_name']!='Shipping cost')
          <tr>
            <td><a href="{{url('products/details/'.$summary['product_id'])}}">{{$summary['product_name']}}</a></td>
            <td>{{$summary['quantity']}}</td>
             <td>{{$summary['listprice']}}</td>
          </tr>
          @endif
        @endforeach
     </table>
    
    <h3>Shipping Address</h3>
    <table class="table">
      <tr>
        <td>Shipping Street</td><td>{{$orders->shippingstreet}}</td>
      </tr>
      <tr>
        <td>Shipping city</td><td>{{$orders->shippingcity}}</td>
      </tr>
      <tr>
        <td>Shipping State</td><td>{{$orders->shippingstate}}</td>
      </tr>
      <tr>
        <td>Shipping Country</td><td>{{$orders->shippingcountry}}</td>
      </tr>
    </table>
    <h3>Billing Address</h3>
    <table class="table">
      <tr>
        <td>Billing Street</td><td>{{$orders->billingstreet}}</td>
      </tr>
      <tr>
        <td>Billing city</td><td>{{$orders->billingcity}}</td>
      </tr>
      <tr>
        <td>Billing State</td><td>{{$orders->billingstate}}</td>
      </tr>
      <tr>
        <td>Billing Country</td><td>{{$orders->billingcountry}}</td>
      </tr>
    <table>

  @endif

<p>Best regards,</p>

<p>@lang('general.site_name') Team</p>
@stop
