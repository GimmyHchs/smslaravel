@extends('app')
@section('content')
<div class="row" >
<div class="col-md-12 col-md-offset-0" >
		<div class="panel panel-default">
       	<div class="panel-heading">訊息發送狀態</div>

       			 <div class="panel-body">
					<table class="table table-hover">
				 		  <tr>
						    <th>學生姓名</th>
						    <th>家長電話</th> 
						    <th>內容</th>
						    <th>發送狀態</th>
						  </tr>
						  @foreach($messages as $message)
						  @if($message->delivertype=='fail')
							<tr class="danger">
						  @else
						  	<tr class="active">
						  @endif
						  	<td>{{$students->where('id',$message->student_id)->first()->name}}</td>
						    <td>{{$message->to}}</td>
						    <td>{{$message->content}}</td> 
						    <td>{{$message->delivertype}}</td>
						  </tr>
						  @endforeach
						
					</table>
				</div>

		</div>
 </div>
 </div>
@stop