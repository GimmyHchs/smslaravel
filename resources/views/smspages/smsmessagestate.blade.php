@extends('app')
@section('content')
<div class="row" >
<div class="col-md-10 col-md-offset-1" >
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
						  <tr class="active">
						    <td>測試學生A</td>
						    <td>0912345678</td>
						    <td>親愛的家長您好，貴子弟元祺亞太在2015-04-21 09:40:02已抵達元祺文理補習班，請家長放心</td> 
						    <td>成功送達</td>
						  </tr>
						  <tr class="danger">
						    <td>測試學生B</td>
						    <td>0922222222</td>
						    <td>親愛的家長您好，貴子弟元祺亞太在2015-04-21 09:40:02已抵達元祺文理補習班，請家長放心</td> 
						    <td>訊息傳送失敗</td>
						  </tr>
						  <tr class="active">
						    <td>測試學生A</td>
						    <td>0912345678</td>
						    <td>親愛的家長您好，貴子弟元祺亞太在2015-04-21 09:40:02已抵達元祺文理補習班，請家長放心</td> 
						    <td>成功送達</td>
						  </tr>
						  <tr class="active">
						    <td>測試學生A</td>
						    <td>0912345678</td>
						    <td>親愛的家長您好，貴子弟元祺亞太在2015-04-21 09:40:02已抵達元祺文理補習班，請家長放心</td> 
						    <td>成功送達</td>
						  </tr>
					</table>
				</div>

		</div>
 </div>
 </div>
@stop