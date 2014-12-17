// JavaScript Document


	var dataset_colors = [
			{ id:1, sales:20, year:"2002", color: "#ee4339"},
			{ id:2, sales:55, year:"2003", color: "#ee9336"},
			{ id:3, sales:40, year:"2004", color: "#eed236"},
			{ id:4, sales:78, year:"2005", color: "#d3ee36"},
			{ id:5, sales:61, year:"2006", color: "#a7ee70"},
			{ id:6, sales:35, year:"2007", color: "#58dccd"},
			{ id:7, sales:80, year:"2008", color: "#36abee"},
			{ id:8, sales:50, year:"2009", color: "#476cee"},
			{ id:9, sales:65, year:"2010", color: "#a244ea"},
			{ id:10, sales:59, year:"2011", color: "#e33fc7"}
		];

		var bottom_tabbar={view:"toolbar", height:50,
							cols:[
								{ view: 'tabbar', 
										id:"viewstabs",
										selected:"v11",
										multiview:"multiview_all",
										inputWidth:270,
										options:[ 
											{ label: 'Menu', src: 'imgs/tabbar/list.png', value: 'listView'},
											{ label: 'Chart',src: 'imgs/tabbar/graph.png', value: 'chart'},
											{ label: 'Calendar', src: 'imgs/tabbar/calendar.png', value: 'mycalendar'},
											{ label: 'Settings', src: 'imgs/tabbar/settings.png', value: 'settings'}
										]
								}
							]
						}
				


			var mv_moduleslistview= { //OPEN THE LISTVIEW LIST
																		 id:"listView",
																		 
																		 
																				rows:[//OPEN THE LISTVIEW ELEMENTS CONTAINER
																						
																						{//OPEN THE LISTVIEW TOOLBAR
																			view:"toolbar",
																			elements:[
																						{view:"button",type:"prev", id:"setup",hidden:"true", label:"Back", align:"left", click:"listreloader()", inputWidth:100},
																						{view:"button", label:"Log out", click:"logout()", inputWidth:100,align:"right"}
																					  ]
																				 },//CLOSE THE LISTVIEW TOOLBAR
																						
																						
																						{
																							 cols:[	//OPEN DATAVIEW CONTAINER IN COLUMNS
																									{view:"dataview", 
																									id:"moduleslist",
																									url:"./p/modules.php",
																									datatype:"xml",
																									xCount:2,
																									select:false, 
																									 type:{
									template:"<div><img src=\"./imgs/main/#module#.jpg\" ><br/>#module#</div>",
																										height:80,
																										css:"kingdomButton"
																									}}
																									
										
																									
																					
																								] //CLOSE DATA VIEW CONTAINER IN COLUMNS
																					  
																					  }
																				]//CLOSE THE LIST VIEW ROW ITEMS CONTAINER
																			
																			
																		
																		 }
																		 
																		 


										 
																	var mv_chart={   id:"chart",
																			cols:[
																					{
																						view:"chart",
																						type:"bar",
																						value:"#sales#",
																						//color:"#color#",
																						barWidth:30,
																						radius:0,
																						tooltip:{
																							template:"#sales#"
																						},
																						xAxis:{
																							template:"'#year#",
																							title:"Year"
																						},
																						yAxis:{
																							title:"Profit"
																						},
																						data: dataset_colors
																					}
																					]
																		}
																		
																		
																		
																		var mv_calendar=	{	id:"mycalendar",
																			
																			rows:[
																				{
																						id:"eventcalendar",
																						view:"calendar",
																					},
																						{
																								id:"parenteventlist",
																								cols:[
																								{
																										width:300,
																										rows:[{
																														
																														view:"toolbar", type:"SubBar", elements:[
																														{
																														   id: "filter",
																														   view: "text",
																														   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 5px 0'></div></div>",
																														   labelWidth: 30
																														}]
																											
																													},
																													//CLOSE FIRST ROW
																													{
																													  id:"eventlist",
																													  cols:[
																														{
																															 view:"list",
																															 height:200,
																															 id:"activitylist",
																															 url:"activity.php",
																															 datatype:"xml",
																															template:"<div style='float:left'><div class='title'>#actagent#</div> <div class='author'>(#acttype#)</div></div><div class='price'>#actamount#</div>",
																															 select:true
																														}]
																													}
																										 ]//CLOSE THE ROWS
																									 }//
																							]//CLOSE THE COLS B
																				}//CLOSE COL 2A
																			]//CLOSE THE COLS FOR MY CALENDAR
																		}
						
						
						
						
						
						
					var mv_itemslistview=	 { //OPEN THE LISTVIEW LIST
																		 id:"SUBM_dataView",
																		 
																		 
																				rows:[//OPEN THE LISTVIEW ELEMENTS CONTAINER
																						
																						{//OPEN THE LISTVIEW TOOLBAR
																			view:"toolbar",
																			elements:[
																						{view:"button",type:"prev", label:"Back", align:"left", click:"$$('listView').show();", inputWidth:100}
																						
																					  ]
																				 },//CLOSE THE LISTVIEW TOOLBAR
																						
																						
																						{
																							 cols:[	//OPEN DATAVIEW CONTAINER IN COLUMNS
																									
																								{ view:"grouplist", 
																								  id:"subm_dataview", 
																							      datatype:"xml",
																								  templateItem:"#submodule#",
																								  templateGroup:"#submodule#",
																								  templateBack:"#submodule#",
																								 // width: 500,
																								  //height: 500,
																								  //animate:true,
																								  animate:{type:"slide", subtype:"in"}
																										}
																								] //CLOSE DATA VIEW CONTAINER IN COLUMNS
																					  
																					  }
																				]//CLOSE THE LIST VIEW ROW ITEMS CONTAINER
																			
																			
																		
																		 }//CLOSE THE LISTVIEW	
																		 
																		 
																		 
																		 
																		 
																		 
var gridView={//OPEN THE CUSTOMERS GRIDVIEW
				
											id:"GridviewContainer",
													rows:[

														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('SUBM_dataView').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadgrid()", inputWidth:100},
																			{view:"button", label:"Add", id:"add", inputWidth:100,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
															{
																view:"toolbar", type:"toolbar", elements:[
																 {
																	   id: "filter",
																	   view: "text",
																	   inputWidth:600,
																	   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 2px 0'></div></div>", 
																 }]
															
															},
														
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"defaultgrid",
																select:true,
																datatype:"xml",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"header1",
																				width:250,
																				label:"Column 1",
																				template:"#title# <span> #customer#</span>",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"header2",
																				label:"Column 2",
																				width:250
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							}//CLOSE THE  CUSTOMERS GRIDVIEW	
			
			


var formView=		{//OPEN THE CUSTOMERS FORM VIEW CONTAINER
							
                            			id:"FormviewContainer",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('GridviewContainer').show()", inputWidth:100},
																{view:"button", label:"Save", click:"dataSaver()", inputWidth:100,align:"center"},
																{view:"button", id:"custdel", label:"Delete", click:"Deleter()", inputWidth:100,align:"right"}
																
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
										
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"defaultform",
													 elements:[
																{ gravity:1},
																{ gravity:2}
																			
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           }