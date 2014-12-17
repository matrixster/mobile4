
      <?php include('./p/forms.php');
	  	 include('./p/comboInit.php'); 

	 ?>

<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="./codebase/touchui.css" type="text/css" media="screen" charset="utf-8">
		<script src="./codebase/touchui.js" type="text/javascript" charset="utf-8"></script>
        <script src="./p/home_views.js" type="text/javascript" charset="utf-8"></script>
     <script src="./p/listeners.js" type="text/javascript" charset="utf-8"></script>

		<title>Wavuh Touch</title>
		<style>
			.plus{
				color:green;
			}
			.minus{
				color:red;
			}
			.borderBottom{
				border-bottom: 1px solid gray !important;
			}
			.listbg{
				background-color:#F3F3F3;
			}
		</style>
		<script>
			var curActiveId = "";
		//RUN APP
			dhx.attachEvent("onReady", dhx.ui.fullScreen );
			
			dhx.ready(function(){
					
				dhx.debug = false;
				dhx.ui({
					id:"top_view",
					rows:[
						
						{view:"multiview", id:"top_view", cells:[
							mv_multiview,
						]}
					]});
					
				myEvents();	
				
			});
			
			//MULTI VIEW DEFINITION
	
			var mv_multiview = {view:"multiview", id:"multiview", animate:{type:"flip", subtype:"vertical"}, cells:[
				{ view:"layout",
					id:"multiview_view",
					rows:[	 
						{view:"multiview", id:"multiview_all", animate:{type:"slide", subtype:"horizontal"},
							 cells:[
								mv_moduleslistview,//CLOSE THE LISTVIEW	
								mv_chart,
								mv_calendar,
								//mv_settings,
								mv_itemslistview,
								gridView,
								formView,
								
								 ]
						},
								bottom_tabbar
							 ]
				}
			]}
			
		
	</script>
  <!--  <script src="p/myFunctions.js" type="text/javascript" charset="utf-8"></script>-->
      <script src="p/cols.js" type="text/javascript" charset="utf-8"></script>

	<body>
  
	</body>
</html>		