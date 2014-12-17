//NAVIGATIONS
nav=Array();
nav[0]='default';
/************************LOGIN FORM EVENT LISTENER********************************************* 
		
		$$("loginform").attachEvent("onitemclick",function(id){
           // log("onitemclick",arguments)
		   if(id=='enterbtn')
		   {
				//$$('listView').show();
				$$('tabview').show();
			   
		   }
        });
		
		
		
		
			
	/************************MODULES DATAVIEW EVENT LISTENER*********************************************/ 	
	
	
	
	
	
				function Deleter(){
						var t=window.t;
					  var rid=-5;
					  var  t=window.t;
					  var obj=$$(t+'form').getValues();
					  var dt=JSON.stringify(obj);
					 // $$(t+'form').load("./x/"+t+".php?id="+rid,"xml");
					 //CONFIRM DELETION
					 dhx.confirm({
									title: "Delete",
									message: "Are you sure you want to delete this Record?",
									position:"center",
									callback: function(result) {
										
										if (result) {
										 save(t,dt,rid);
										}
									}
							});

					}

	
		
		  function reloadgrid(){
				 var t=window.t;
                  $$(t+'grid').clearAll();
				  $$(t+'grid').load("./p/gridfile.php?id="+t,"xml");
				  
                }
				
					
				function dataSaver(){
					
					
					t=window.t;
					var obj=$$(t+'form').getValues();
					var dt=JSON.stringify(obj);
					
					setTimeout(function(){getval()},100); 
					function getval(){ var rid=$$('rid').getValue();  save(t,dt,rid);} 
					

				}
				
				
				
				function showNewform(){	
				 var t=window.t;
				 gridonclicklistener(t,nav);
				 
				  setTimeout(function(){loadme()},100); 
			function loadme(){ $$('FormviewContainer').show(); } 
			
				

				}
				
					
				function GetXmlHttpObject()
						{
							if (window.XMLHttpRequest)
							{
								return new XMLHttpRequest();
							}
							if (window.ActiveXObject)
							{
								return new ActiveXObject("Microsoft.XMLHTTP");
							}
							return null;
				}
				
				function save(t,dt,rid){
					//if(rid!=-5){
						//validate('leadsform');
						//exit();
						
						// }
					var myAjaxPostrequest=new GetXmlHttpObject();
				    //	var t = "dt="+ dt +"&ts=timesheet";
				    var parameters = "data="+ dt +"&id="+rid;
					//alert(parameters);
					myAjaxPostrequest.open("POST", "./s/"+t+".php", true);
					myAjaxPostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					myAjaxPostrequest.send(parameters);
					myAjaxPostrequest.onreadystatechange=function(){
						if(myAjaxPostrequest.readyState==4){
							if(myAjaxPostrequest.status==200){
								
								dhx.notice(myAjaxPostrequest.responseText);
								 reloadgrid();
							  $$('GridviewContainer').show();	

							}
						}
					}
				}


function logout(){
	
window.location="index.php?a=out";
	
}

	function myEvents(){
		

				
	/************************MODULES DATAVIEW EVENT LISTENER*********************************************/ 	
		
		$$("moduleslist").attachEvent("onItemClick",function(id,ev,trg){
					$$('subm_dataview').clearAll();
 					var capt = id.split("|"); 
					moduleid=capt[0];
					caption=capt[1];
					$$("SUBM_dataView").show();
					
					var path=caption.replace(" ","");
					path=path.toLowerCase(); 
		
					 setTimeout(function(){loadme()},200); //CALL FUNCTION TO  SAVE THE DATA AND SET A TIME DELAY TO ALLOW SAVING OF DATA
					  function loadme(){	
					  $$('subm_dataview').load("./data/submodules.php?id="+moduleid,"xml");
					  }
						
						window.moduleid=moduleid;
						window.modulecaption=caption;
						window.modulestripped=path;
                });
				
			
/**************************SUB DATA VIEW ON CLICK EVENT LISTENER************************************/


			$$("subm_dataview").attachEvent("onItemClick",function(id,ev,trg){
					var t="";
					var itemtype;
			     	var capt = id.split("|"); 
					moduleid=capt[0];
					itemcaption=capt[1];
					itemtype=capt[2];
					for(i=0; i<10; i++){
					var itemcaption=itemcaption.replace(" ","");
					}
					var itemcaption2=itemcaption;
					itemcaption2=itemcaption2.toLowerCase();
					 window.t=itemcaption2;
				     t=window.t;
					var navindex=nav.length;
					window.navindex=navindex;
					 
					var n = t.indexOf("#");   //Determines whether the item is a Submenu container  eg Setup or Report
					window.itemtype=itemtype;
					
					//alert(itemtype);
					/**Only save the Navigation if its the Mainitem or the Setup item that was visited******/
					switch(itemtype){
						case 'Setupitem':
						nav[navindex]=t;
						break;
						case 'mainitem':
						nav[navindex]=t;
						break;
						case 'other':
						nav[navindex]=t;
						break;
						default:
						break;
					}
					
					if(n==-1){			//Executes code if an item is not a sub Item container when # Symbol is not found
						
						//alert(t);
						 itemtype=window.itemtype;
						 showgridonclick(t,itemtype,nav);
						 gridonfilterlistener(t,itemtype,nav);//FILTER EVENT LISTENER FUNCTION
					}
					
			});
					
		
	
	
			function gridonclicklistener(t,nav){
				var ln=nav.length;
				oldt=ln-2;
				ln=ln-1;
				nt=nav[ln];
				var t=nt;
				
				 formConfig=getForm(t);
				var formtype=formConfig["url"]; 
				
						 setTimeout(function(){loadme()},100); 
							 function loadme(){
								dhx.ui(formConfig,$$('FormviewContainer'),nav[oldt]+"form");
						 }
						
						/****************Grids On click events listener******************/
								$$(t+'grid').attachEvent("onItemClick", function(id){ 
								var T=t.charAt(0).toUpperCase()+ t.slice(1).toLowerCase();	
								
								 setTimeout(function(){loadForm()},100);
								function loadForm(){
									$$(t+'form').clear();
									$$(t+'form').load("./x/"+t+".php?id="+id,"xml");
									 $$('FormviewContainer').show(); 
										setCombo(t);
										
									 switch(formtype){
									 case 'defaultform':
									 $$('GridviewContainer').show(); 
									 break;
									 default:
									 break;
										 }
								}
						
							});	
							
			}
		
		
		
			$$('add').attachEvent("onItemClick", function(id){
								 var t=window.t; 
						    	 setTimeout(function(){loadnewForm()},100);
								function loadnewForm(){
								   var rid=-1;
								   formConfig=getForm(t);
									var Newformtype=formConfig["url"]; 
									$$(t+'form').clear();
									 $$('FormviewContainer').show(); 
										setCombo(t);
									
										 switch(Newformtype){
										 case 'defaultform':
										 $$('GridviewContainer').show(); 
										 break;
										 default:
						            $$(t+'form').load("./x/"+t+".php?id="+rid,"xml");
										 break;
										 }
								}
				});	
		
		
		 function gridonfilterlistener(t,itemtype,nav){
			/*adds keyevents support to "filter" view*/
			var t=window.t;
			  dhx.extend($$('filter'),dhx.KeyEvents);   
			  /*sets a function that is called on keypress with delay*/
			 $$('filter').attachEvent("onTimedKeyPress", function(){

				var  filt=Array();
				var text = $$('filter').getValue();
				
				myfilters=getGridheaders(t);
				filt=myfilters.split(",");
				var colsize=filt.length;
				var n=1;
				do{
				//alert(t);
				var ln=nav.length;
				ln=ln-1;
				nt=nav[ln];
				
			   $$(nt+"grid").filter("#field"+n+"#",text);
				 rows=$$(nt+"grid").dataCount();
				n++;
				}while(rows==0 && n<=colsize);
			 
			});	
		}
			
			
			function showgridonclick(t,itemtype,nav){
				var T=t.charAt(0).toUpperCase()+ t.slice(1).toLowerCase();
				
				
				 setTimeout(function(){loadme()},100); 
			
			function loadme(){loadgrid(t,itemtype,nav); } 
			$$("GridviewContainer").show(); 	
			}
			
			
			
			
			function loadgrid(t,itemtype,nav){
				//GETTING THE HEADERS
				
				switch(itemtype){
							case 'mainitem':
							myfilters=getGridheaders(t);
							filt=myfilters.split(",");
							var head1=filt[0];
							var head2=filt[1];
							 break;
							 case 'other':
							myfilters=getGridheaders(t);
							filt=myfilters.split(",");
							var head1=filt[0];
							var head2=filt[1];
							 break;
							 default:
							 myfilters=getGridheaders(t);
							 filt=myfilters.split(",");
							var head1=filt[0];
							 break;
				}

				
				 singlecol_grid={//OPENING OF THE GRIDVIEW 
							view:"grid",
							select:true,
							id:t+"grid",
							datatype:"xml",
							url:"./p/gridfile.php?id="+t,
							fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
										{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
											id:"field1",
											width:350,
											label:head1,
											type:"custom"
										}//CLOSE FIRST COLUMN DESCRIPTION
										
								],//CLOSE FIELDS DESCRIPTION
							
						}//CLOSE THE GRIDVIEW
						
				//GRID CONSTRUCTOR
				 doublecol_grid={//OPENING OF THE GRIDVIEW 
							view:"grid",
							select:true,
							id:t+"grid",
							datatype:"xml",
							url:"./p/gridfile.php?id="+t,
							fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
										{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
											id:"field1",
											width:250,
											label:head1,
											type:"custom"
										},//CLOSE FIRST COLUMN DESCRIPTION
										
										{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
											id:"field2",
											label:head2,
											width:250
										}//CLOSE SECOND COLUMN DESCRIPTION
								],//CLOSE FIELDS DESCRIPTION
							
						}//CLOSE THE GRIDVIEW
						
						switch(itemtype){
							case 'mainitem':
							var grid_val=doublecol_grid;
							break;
							case 'other':
							var grid_val=doublecol_grid;
							break;
							default:
							var grid_val=singlecol_grid;
							break;
							
						}
						
				var oldt=window.navindex;
				oldt=oldt-1;
				if(t=='processconsumableorders' || t=='processassetorders' ){var grid_val=singlecol_grid;}
			 setTimeout(function(){loadme()},100); 
			function loadme(){dhx.ui(grid_val, $$('GridviewContainer'),nav[oldt]+"grid");
			 gridonfilterlistener(t,itemtype,nav);//FILTER EVENT LISTENER FUNCTION
				 gridonclicklistener(t,nav);//GRID EVENT LISTENER FUNCTION	
			}
	
				
			}
			
			

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	