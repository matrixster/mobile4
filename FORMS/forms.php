 <script>
 {//OPEN THE FROM VIEW CONTAINER
							
                            			id:"Suppliersform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('Suppliersgrid').show()", inputWidth:100},
																{view:"button", label:"Save", click:"suppliers_saver()", inputWidth:100,align:"center"},
																{view:"button", label:"Delete",id:"suppdel",  click:"suppliers_deleter()", inputWidth:100,align:"right"}
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
									
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"suppliersform",
													 elements:[
													 
								 
																{ gravity:1},
																{ view:"text", label:"Suppliers", labelWidth: 140, name:"supplier" },
																{ view:"text", label:"Contact Person.",labelWidth: 140, name:"cperson" },
																{ view:"text", label:"Phone",labelWidth: 140, name:"tel" },
																{ view:"text", label:"Email",labelWidth: 140, name:"email" },
																{ view:"text", label:"Memo",labelWidth: 140, name:"comments" },
																{ gravity:2},
																{//window.myvar=true;
																	
																	id:"suppliersfetcher", 
																	hidden:true,
																	template:function(obj){
																	 window.suppvals="";
																	 window.suppvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	//return  window.assetvals;
																	}
																}
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },
						   
						   
						     {//OPEN THE MESSAGING FORM  VIEW CONTAINER
							
                            			id:"Messagingform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", type:"prev",label:"Back", click:"$$('Messaginggrid').show()", inputWidth:100,align:"left"},
																{view:"button", label:"Send", id:"msg_save", click:"message_saver()", inputWidth:150,align:"center"},
																{view:"button", label:"Compose",id:"msgcmp",  hidden:true, click:"messaging_composer()", inputWidth:150,align:"right"},
																{view:"button", label:"Done Composing",id:"msgcmp_done",  click:"messaging_composer_done()", inputWidth:150,align:"right"}
																//{view:"button", label:"Delete",id:"msgdel",  click:"messaging_deleter()", inputWidth:100,align:"center"},
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
									
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"messagingform",
													 gravity:0,
													 elements:[
																{ view:"textarea", id:"message",label:"Message", labelWidth: 120,height:150, name:"message"}
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }, //CLOSE FORMVIEW CONTAINER
											 
											 					
							{//OPEN THE CUSTOMERS GRIDVIEW
				
											id:"msgoption",
											gravity:0,
													rows:[
											  {	  
													id:"msgoptiongrid",
													view:"list",
													url:"msglist.xml",
													datatype:"xml",
													 gravity:2,
													template:"<div style='float:left'><div class='title'>#option#</div></div>",
													type:{
														height: 20
													},
													select:1
							
												 }]
						},
											  
											
												
							{//OPEN THE CUSTOMERS GRIDVIEW
				
											id:"msgCustomersgrid",
											// hidden:true,
											gravity:0,
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																id:"msgtoolbar",
																elements:[
																			{view:"button", label:"Select All", click:"msgcustomers_select()", inputWidth:150,align:"left"},
																			{view:"button", label:"Refresh", click:"reloadmsgcustomersgrid()", inputWidth:100,align:"center"},
																			{view:"button", label:"Unselect All", click:"msgcustomers_unselect()", inputWidth:150,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"msgcustomersgrid",
																//select:true,
																select:"multiselect",
																datatype:"xml",
																url:"customers.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"customer",
																				width:250,
																				label:"Customers",
																				template:"#title# <span> #customer#</span>",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"code",
																				label:"Code",
																				width:100
																			},//CLOSE SECOND COLUMN DESCRIPTION
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"tel",
																				label:"Phone",
																				width:250
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },
						    {//OPEN THE FROM VIEW CONTAINER
                            			id:"Productsform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('Itemsgrid').show()", inputWidth:100},
																{view:"button", label:"Save", click:"products_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"proddel",label:"Delete", click:"products_deleter()", inputWidth:100,align:"right"},
																
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"productsform",
													 elements:[
																{ gravity:1},
																{ view:"text", label:"Product Name",labelWidth: 120, name:"product_name" },
																{ view:"richselect", id:"catid", label: 'Type',labelWidth: 120, value: "1", yCount:"5", options:[	
																<?php
																	$mysize=sizeof($catid);
																	if($mysize>0)
																	{ for($p=0; $p<$mysize; $p++)
																		{
																		 echo '{ value:"'.$catid[$p].'", label:"'.$catname[$p].'" },';
																		}
																}
																?>
																]},
																{ view:"text", label:"Product Code",labelWidth: 120, name:"item_code" },
																{ view:"text", label:"Price.",labelWidth: 120, name:"price" },
																{ view:"text", label:"Commision",labelWidth: 120, name:"commision"},
																{ gravity:2},
																{//window.myvar=true;
																	
																	id:"productsfetcher", 
																	hidden:true,
																	template:function(obj){
																	 window.prodvals="";
																	 window.prodvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	//return  window.assetvals;
																	}
																}
																
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },
						   
						     {//OPEN THE BILLING FORM VIEW CONTAINER
							
                            			id:"Billingform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('Billinggrid').show()", inputWidth:100},
																{view:"button", id:"billdel",label:"Delete", click:"billing_deleter()", inputWidth:100,align:"center"},
																{view:"button", label:"Save", click:"billing_saver()", inputWidth:100,align:"right"}
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"billingform",
													 elements:[
																{ gravity:1},
																
																{ view:"richselect", id:"billingcustid", value:"custid", label: 'Customer',labelWidth: 120,  yCount:"5", options:[	
																<?php
																	$custsize=sizeof($custid);
																	if($custsize>0)
																	{ for($p=0; $p<$custsize; $p++)
																		{
																		 echo '{ value:"'.$custid[$p].'", label:"'.$custname[$p].'" },';
																		}
																}
																?>
																]},
																
															
																{ view:"richselect", id:"billingprodid", label: 'Product',labelWidth: 120,  yCount:"5", options:[	
																<?php
																	$itemsize=sizeof($itemid);
																	if($itemsize>0)
																	{ for($p=0; $p<$itemsize; $p++)
																		{
																		 echo '{ value:"'.$itemid[$p].'", label:"'.$itemname[$p].'" },';
																		}
																}
																?>
																]},
																
																{ view:"text", label:"Price.",labelWidth: 120, name:"amount" },
																{ view:"datepicker", id:"close_date", label:'Close Date', timeSelect:true, labelAlign:"left", labelWidth:120 },
																{ view:"text", label:"Status",labelWidth: 120, name:"status"},
														        { gravity:2},
																{
																	id:"billingfetcher", 
																	hidden:true,
																	template:function(obj){
																	 window.billvals="";
																	 window.billvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },
						   
						     {//OPEN THE PURCHASES FORM VIEW CONTAINER
							
                            			id:"Purchasesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[//
																{view:"button", label:"Back", type:"prev", click:"purchases_back()", inputWidth:100},
																{view:"button", label:"Save", click:"purchases_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"purchdel",label:"Delete", click:"purchases_deleter()", inputWidth:100,align:"right"}
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"purchasesform",
													 elements:[
																{ gravity:0.5},
															{ view:"richselect", id:'purchasessupplier', label: 'Supplier', labelWidth: 120, yCount:"10", options:[
															<?php
															
																$suppsize=sizeof($suppid);
																if($suppsize>0)
																{
																	for($n=0; $n<$suppsize; $n++)
																	{
																		echo '{ value:"'.$suppid[$n].'", label:"'.$suppname[$n].'" },';
																	}
																}
															?>
														    ]},
																{ view:"datepicker", id:"purchasesdate", label:"Date", dateFormat:"%d-%M-%Y",externalDateFormatStr:"%Y-%m-%d", externalDateFormat:"%Y-%m-%d %H:%i:%s",labelAlign:"left",labelWidth:120 },
																{ view:"text", label:"Total",labelWidth: 120,id:"purchasestotal", readonly:true,  name:"total" },
																
																{//window.myvar=true;
																	 id:"purchasesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.purchvals="";
																	 window.purchvals= ""+JSON.stringify(obj).replace(/,/g,",")+"";
																	}
																}
																
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  },//CLOSE FORMVIEW CONTAINER
											   {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													gravity:0.5,
													elements:[//
																{view:"button",id:"subpurchasesadd", label:"Add", click:"addSubPurchases()", inputWidth:100},
																{view:"button", id:"subpurchasesrefresh",label:"Refresh", click:"reloadsubpurchasesgrid()", inputWidth:100},
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												
											  
											   {//OPENING OF THE GRIDVIEW 
																view:"grid",
																 gravity:2.5,
																id:"subpurchasesgrid",
																select:true,
																datatype:"xml",
																//url:"purchases.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"item",
																				width:350,
																				label:"Item",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																				{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"price",
																				width:100,
																				label:"Price",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"qty",
																				label:"Quantity",
																				width:150
																			},//CLOSE SECOND COLUMN DESCRIPTION
																			
																			
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"amount",
																				label:"Amount",
																				width:150
																			}//CLOSE SECOND COLUMN DESCRIPTION
																			
																			
																	],//CLOSE FIELDS DESCRIPTION
																
													      	},//CLOSE THE GRIDVIEW
															
																	
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },											


						     {//OPEN THE SUB PURCHASES FORM VIEW CONTAINER
							
                            			id:"SubPurchasesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Back", type:"prev", click:"$$('Purchasesform').show()", inputWidth:100},
																{view:"button", id:"subpurchsave", label:"Save", click:"subpurchases_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"subpurchdel", label:"Delete", click:"subpurchases_deleter()", inputWidth:100,align:"right"}
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												
									
											


										{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"subpurchasesform",
													 gravity:4,
													 elements:[
																
																//{ view:"text", label:"Item", labelWidth: 120, name:"item" },
																{ view:"richselect", id:"subpurchitemid",  label: 'Product',labelWidth: 120,  yCount:"5", options:[	
																<?php
																	$itemsize=sizeof($itemid);
																	if($itemsize>0)
																	{ for($p=0; $p<$itemsize; $p++)
																		{
																		 echo '{ value:"'.$itemid[$p].'", label:"'.$itemname[$p].'" },';
																		}
																}
																?>
																]},
																{ view:"text", label:"Price",labelWidth: 120, id:"purchaseprice", readonly:true,name:"price" },
																{ view:"text", label:"Quantity",labelWidth: 120, name:"qty" },
																//{ view:"text", label:"Amount",labelWidth: 120, name:"amount" },
																
														       // { gravity:0},
																{//window.myvar=true;
																	 id:"subpurchasesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.subpurchvals="";
																	 window.subpurchvals= ""+JSON.stringify(obj);
																	}
																}
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }
												
							      ]
				             },
						     {//OPEN THE SALES FORM VIEW CONTAINER
							
                            			id:"Salesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Back", type:"prev", click:"sales_back()", inputWidth:100},
																{view:"button", label:"Save", click:"sales_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"salesdel", label:"Delete", click:"sales_deleter()", inputWidth:100,align:"right"},
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"salesform",
													 elements:[
																{ gravity:1},
																//{ view:"text", label:"Customer", labelWidth: 120, name:"customer" },
																
																{ view:"richselect", id:"salescustid", value:"salescustid", label: 'Customer',labelWidth: 120,  yCount:"5", options:[	
																<?php
																	$custsize=sizeof($custid);
																	if($custsize>0)
																	{ for($p=0; $p<$custsize; $p++)
																		{
																		 echo '{ value:"'.$custid[$p].'", label:"'.$custname[$p].'" },';
																		}
																}
																?>
																]},
																{ view:"datepicker", id:"formreceiptdate", label:"Date", dateFormat:"%d-%M-%Y",externalDateFormatStr:"%Y-%m-%d", externalDateFormat:"%Y-%m-%d %H:%i:%s",labelAlign:"left",labelWidth:120 },
																{ view:"text", label:"Total",labelWidth: 120,readonly:true, name:"amount" },
															    { gravity:2},
																{//window.myvar=true;
																	 id:"salesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.salesvals="";
																	 window.salesvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  },//CLOSE FORMVIEW CONTAINER
											  
											  
											   {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													gravity:0.5,
													elements:[//
																{view:"button",id:"subsalessadd", label:"Add", click:"addSubSales()", inputWidth:100},
																{view:"button", id:"subsalesrefresh",label:"Refresh", click:"reloadsubsalesgrid()", inputWidth:100},
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
											   {//OPENING OF THE GRIDVIEW 
																view:"grid",
																 gravity:2.5,
																id:"subsalesgrid",
																datatype:"xml",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"item",
																				width:350,
																				label:"Product",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																				{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"price",
																				width:100,
																				label:"Price",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"qty",
																				label:"Quantity",
																				width:150
																			},//CLOSE SECOND COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"amount",
																				label:"Amount",
																				width:150
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	},//CLOSE THE GRIDVIEW
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 
                           },											
						     {//OPEN THE SUB PURCHASES FORM VIEW CONTAINER
                            			id:"SubSalesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", id:"sback", label:"Back", type:"prev", click:"$$('Salesform').show()", inputWidth:100},
																{view:"button", id:"subsalesave", label:"Save", click:"subsales_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"subsalesdel", label:"Delete", click:"subsales_deleter()", inputWidth:100,align:"right"}
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
										{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"subsalesform",
													 gravity:4,
													 elements:[
																{ view:"richselect", id:"salesprodid", label: 'Product',labelWidth: 120,  yCount:"5", options:[	
																<?php
																	$itemsize=sizeof($itemid);
																	if($itemsize>0)
																	{ for($p=0; $p<$itemsize; $p++)
																		{
																		 echo '{ value:"'.$salesitemid[$p].'", label:"'.$itemname[$p].'" },';
																		}
																}
																?>
																]},
																{ view:"text", label:"Price",labelWidth: 120, id:"subsalesprice", name:"price" },
																{ view:"text", label:"Quantity",labelWidth: 120, name:"qty" },
																{
																	 id:"subsalesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.subsalesvals="";
																	 window.subsalesvals= ""+JSON.stringify(obj);
																	}
																}
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },											
						     {//OPEN THE P ITEM CATEGORIESFORM VIEW CONTAINER
							
                            			id:"Itemcategoriesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('Itemcategoriesgrid').show()", inputWidth:100},
																	{view:"button", label:"Save", click:"itemcategories_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"catdel",label:"Delete", click:"itemcategories_deleter()", inputWidth:100,align:"right"}
															
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"itemcategoriesform",
													 elements:[
																{ gravity:1},
																{ view:"text", label:"Category", labelWidth: 120, name:"category" },
																{ gravity:2},
																{
																	 id:"itemcategoriesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.itemcategoriesvals="";
																	 window.itemcategoriesvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },	
						     {//OPEN THE P ITEM CATEGORIESFORM VIEW CONTAINER
							
                            			id:"Paymentmodesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('Paymentmodesgrid').show()", inputWidth:100},
																{view:"button", label:"Save", click:"paymentmodes_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"modedel",label:"Delete", click:"paymentmodes_deleter()", inputWidth:100,align:"right"}
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"paymentmodesform",
													 elements:[
																{ gravity:1},
																{ view:"text", label:"Payment Mode", labelWidth: 120, name:"paymode" },
																{ gravity:2},
																{
																	 id:"paymentmodesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.paymentmodesvals="";
																	 window.paymentmodesvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },	
						     {//OPEN THE P ITEM CATEGORIESFORM VIEW CONTAINER
							
                            			id:"Paymenttermsform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", label:"Cancel", click:"$$('Paymenttermsgrid').show()", inputWidth:100},
																{view:"button", label:"Save", click:"paymentterms_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"termsdel",label:"Delete", click:"paymentterms_deleter()", inputWidth:100,align:"right"}
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
												
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"paymenttermsform",
													 elements:[
																{ gravity:1},
																{ view:"text", label:"Payment Terms", labelWidth: 120, name:"payterms" },
																{ gravity:2},
																{
																	 id:"paymenttermsfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.paymenttermsvals="";
																	 window.paymenttermsvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },
						   
						   	{//OPEN THE CAMPAIGNS FORM VIEW CONTAINER
							
                            			id:"Currenciesform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button", id:"currcancel",label:"Cancel", click:"$$('Currenciesgrid').show()", inputWidth:100},
																{view:"button", id:"currsave",label:"Save", click:"currencies_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"currdel", label:"Delete", click:"currencies_deleter()", inputWidth:100,align:"right"}
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
										
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"currenciesform",
													 elements:[
																{ gravity:1},
																{ view:"text", label:"Currency", labelWidth: 120, name:"currency" },
																{ view:"text", label:"Symbol",labelWidth: 120, name:"symbol" },
																{ view:"text", label:"Rate",labelWidth: 120, name:"rate" },
																{ gravity:2},
																{
																	 id:"currenciesfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.currenciesvals="";
																	 window.currenciesvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           },
						   
						   	{//OPEN THE CAMPAIGNS FORM VIEW CONTAINER
							
                            			id:"Bankaccountsform",
                           			 	rows:[//OPENING THE FORMVIEW CONTAINER
										        {//OPENING THE TOOLBAR IN FORMVIEW	
													view:"toolbar",
													elements:[
																{view:"button",id:"acccancel", label:"Cancel", click:"$$('Bankaccountsgrid').show()", inputWidth:100},
																{view:"button", id:"accsave",label:"Save", click:"bankaccounts_saver()", inputWidth:100,align:"center"},
																{view:"button", id:"accdel",label:"Delete", click:"bankaccounts_deleter()", inputWidth:100,align:"right"}
																
															  ]
												},//CLOSING THE TOOLBAR IN FORMVIEW
										
									
												{//OPENING THE FORM IN THE FORMVIEW
													 view:"form",
													 id:"bankaccountsform",
													 elements:[
																{ gravity:1},
																															
																
															   { view:"text", label:"Bank",labelWidth: 120, name:"bank" },
															   { view:"text", label:"Branch Name", labelWidth: 120, name:"branch" },
																{ view:"text", label:"Account No.",labelWidth: 120, name:"accountnumber" },
																
																
																{ gravity:2},
																{
																	 id:"bankaccountsfetcher", 
																	 hidden:true,
																	 template:function(obj){
																	 window.bankaccountsvals="";
																	 window.bankaccountsvals= ""+JSON.stringify(obj).replace(/,/g,"\n,")+"";
																	}
																}
																
                                    	   					  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
                               				  }//CLOSE FORMVIEW CONTAINER
                            ]//END OF TOOLBAR AND FORM VIEW CONTAINER IN ROWS FASHION 

                           }
						   
						   
						   </script>