@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					You are logged in!

				</div>
			</div>
		</div>
	</div>
</div> 
<script type="text/javascript">

    
  	
    

 </script>
 <?php
    $name = Auth::user()->name;
 	echo "<script>   webix.message(\"Welcome  $name\"); </script>";
 ?>


	

@endsection
