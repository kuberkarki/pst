@extends('emails/layouts/default')

@section('content')
<p>Hello {!! $user->first_name !!},</p>

<p>Welcome to Attigo One! Please click on the following link to confirm your Attigo One account:</p>

<p>Best regards,</p>

<p>@lang('general.site_name') Team</p>
@stop
