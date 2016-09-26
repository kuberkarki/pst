@extends('emails/layouts/default')

@section('content')
<tr>
    <td valign="top">
        {!! $content !!}
       
    </td>
</tr>
@stop


@section('content_old')
<p>Hello {!! $user->first_name !!},</p>

<p>Welcome to {{ $settings->attigo__store_name__c or 'AttigoOne' }}! Please click on the following link to confirm your {{ $settings->attigo__store_name__c or 'AttigoOne' }} account:</p>
<p>Your username:{!! $user->email !!} and password:{!! $password !!}</p>
<p><a href="{!! $activationUrl !!}">{!! $activationUrl !!}</a></p>

<p>Best regards,</p>

<p>{{ $settings->attigo__store_name__c or 'AttigoOne' }} Team</p>
@stop
