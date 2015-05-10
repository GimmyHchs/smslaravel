@extends('app')



@section('content')
<!DOCTYPE html>
<html>
	<style type="text/css">
		.webix_message_area{

				margin-top: 65px;
				
		}	
		.panel-body{
			padding: 0px;
			margin: 15px;
		}
	</style>
	
	<head>
		<link rel="stylesheet" href="{{ asset('/webix/codebase/webix.css')}}" type="text/css" media="screen" charset="utf-8">
		<script src="{{ asset('/webix/codebase/webix.js') }}" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="{{  asset('/webix/samples/common/testdata.js')  }}"></script>
		<title>Disabling Components</title>
	</head>
	<body>
				<div class="col-md-9 col-md-offset-1" >
					<div class="panel panel-default">
			     	  	<div class="panel-heading">系統設定</div>
			     	  	<div class="panel-body" id="layout_div"></div>
		     	  	</div>
		     	 </div>
				<script>

				    webix.ui({
				        container:"layout_div",
				        id:"app",
				        margin:5,
				        rows:[
				           
				            {view:"segmented", options:["Add", "Delete", "Mark"]},
				            {
				                view:"form",
				                id:"myform",
				                elements:[
				                    {view:"richselect", name:"rank", options:["1", "2", "3"]},
				                    {view:"text", name:"title"},
				                    {view:"text", name:"year"},
				                    {view:"text", name:"votes"},
				                    {view:"counter", name:"rating"},
				                ],
				                data:small_film_set[0]
				            },
				            {height:45},
				            { cols:[
				                { view:"button", value:"Reload with Progress Bar", click:function(){ show_progress_bar(2000); }},
				                { view:"button", value:"Reload with Progress Icon", click:function(){ show_progress_icon(2000); }}
				            ]}
				        ]

				    });

				    //adding ProgressBar functionality to layout
				    webix.extend($$("app"), webix.ProgressBar);


				    function show_progress_bar(delay){
				        $$("app").disable();
				        $$("app").showProgress({
				            type:"top",
				            delay:delay,
				            hide:true
				        });
				        setTimeout(function(){
				            $$("myform").parse(small_film_set[1]);
				            $$("app").enable();
				        }, delay);
				    }

				    function show_progress_icon(delay){
				        $$("app").disable();
				        $$("app").showProgress({
				            type:"icon",
				            delay:delay
				        });
				        setTimeout(function(){
				            $$("myform").parse(small_film_set[2]);
				            $$("app").enable();
				            $$("app").hideProgress();
				        }, delay);
				    }

				</script>
		
		
				<div class="col-md-9 col-md-offset-1" >
					<div class="panel panel-default">
			     	  	<div class="panel-heading">簡訊測試</div>
			     	  	<div class="panel-body">
			     	  		{!!Form::open(['url'=>'/smstest','method'=>'GET'])!!}
			     	  		{!!Form::submit('發送一則測試簡訊',['class'=>'btn btn-primary'])!!}
			     	  		{!!Form::close()!!}

			     	  	</div>
		     	  	</div>
		     	 </div>

	</body>
</html>
@stop