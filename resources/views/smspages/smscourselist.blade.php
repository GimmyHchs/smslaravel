@extends('app')
@section('content')

<div class="row" >
  <div class="col-md-10 col-md-offset-1" >
  <div class="panel panel-default">
<div class="panel-heading">課程列表</div>
</div>
	<table class="table table-bordered">
		  <tr>
		    <th>課程名稱</th>
		    <th>上課日</th> 
		    <th>上課時間</th>
		    <th>下課時間</th>
		  </tr>
		  <tr>
		    <td>測試課程A</td>
		    <td>星期一、星期二</td>
		    <td>2000-01-01 18:00:00 UTC</td> 
		    <td>2000-01-01 21:00:00 UTC</td>
		  </tr>
		  <tr>
		    <td>測試課程B</td>
		    <td>星期三、四</td>
		    <td>2000-01-01 18:00:00 UTC</td> 
		    <td>2000-01-01 18:00:00 UTC</td>
		  </tr>
	</table>

  </div>
</div>

@stop