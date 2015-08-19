<head>
<link rel="stylesheet" media="all" type="text/css" href="jquery-ui.css" />
		<link rel="stylesheet" media="all" type="text/css" href="jquery-ui-timepicker-addon.css" />
		
	</head> 
	<body>
	<div class="example-container">
		
		<div>
	 		<input type="text" name="basic_example_1" id="basic_example_1" value="" />
		</div>					
<pre>
<script>$('#basic_example_1').datetimepicker();</script>
</pre>
	</div>
<script type="text/javascript" src="jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="jquery-ui.min.js"></script>
		<script type="text/javascript" src="jquery-ui-timepicker-addon.js"></script>
		<script type="text/javascript" src="jquery-ui-sliderAccess.js"></script>

		<script type="text/javascript">
			
			$(function(){
				$('#tabs').tabs();
		
				$('.example-container > pre').each(function(i){
					eval($(this).text());
				});
			});
			
		</script>

		<script type="text/javascript" src="api_buttons.js"></script>
	</body>