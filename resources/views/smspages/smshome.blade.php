@extends('app')
@section('content')
<link href='//fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>
	<style>
		 .container{
			text-align: center;
			vertical-align: middle;

		 }
		 .quote{
			font-family: 'Lato';
		 	font-size: 32px;
		 }
	     .title{
	     	margin-top: 175px;
			font-size: 96px;
			font-family: 'Lato';
			margin-bottom: 40px;
	     }
	     
	</style>>
	
		
		<div class="container">
			<div class="content">
			@if(empty($subdomain))
				<div class="title">SMS Service with Laravel</div>
				<div class="quote">www.mynet.com.tw</div>
			@else
				<div class="title">{{$subdomain}}1 SMS Service with Laravel</div>
				<div class="quote">{{$subdomain}}.mynet.com.tw</div>
			@endif

				
			</div>
		</div>
	
@stop