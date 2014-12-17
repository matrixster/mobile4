<script>

		
		{//OPEN THE ASSETS  GRIDVIEW
				
											id:"Suppliersgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadsuppliersgrid()", inputWidth:100},
																			{view:"button", label:"Add Supplier", click:"addsuppliers()", inputWidth:150,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
															{
																view:"toolbar", type:"toolbar", elements:[
																 {
																		//supplierfilter
																	   id: "supplierfilter",
																	   view: "text",
																	   inputWidth:500,
																	   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 2px 0'></div></div>", 
																 }]
															
															},
														
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"suppliersgrid",
																select:true,
																datatype:"xml",
																url:"suppliers.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"supplier",
																				width:250,
																				label:"Supplier",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"tel",
																				label:"Phone",
																				width:250
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  ASSETS GRIDVIEW					
										
								{//OPEN THE MESSAGING  GRIDVIEW
				
											id:"Messaginggrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadmessaginggrid()", inputWidth:100},
																			{view:"button", label:"New Message", click:"addMessaging()", inputWidth:150,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"messaginggrid",
																select:true,
																datatype:"xml",
																//url:"messaging.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"itemrid",
																				width:250,
																				label:"Message-Status.",
																				template:"#category# <span style='color:#919191'>#itemrid#</span>",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"send_date",
																				label:"Date Sent",
																				width:250
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  MESSAGING GRIDVIEW		
							{//OPEN THE PRODUCTS GRIDVIEW
				
											id:"Itemsgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadproductsgrid()", inputWidth:100},
																			{view:"button", label:"Add Product", click:"addProduct()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
															{
																view:"toolbar", type:"toolbar", elements:[
																 {
																		//supplierfilter
																	   id: "productsfilter",
																	   view: "text",
																	   inputWidth:500,
																	   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 2px 0'></div></div>", 
																 }]
															
															},
														
														    {//OPENING OF THE GRIDVIEW 
																									
																view:"grid",
																id:"productsgrid",
																select:true,
																datatype:"xml",
																url:"products.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"productsid",
																				width:250,
																				label:"Product  (Code).",
																				template:"#product_name# <span style='color:#919191'>(#item_code#)</span>",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"price",
																				label:"Price",
																				width:250
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  MESSAGING GRIDVIEW		
							{//OPEN THE BILLING GRIDVIEW
				
											id:"Billinggrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadbillinggrid()", inputWidth:100},
																			{view:"button", label:"New Billing", click:"addBilling()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
															{
																view:"toolbar", type:"toolbar", elements:[
																 {
																	   id: "billingfilter",
																	   view: "text",
																	   inputWidth:500,
																	   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 2px 0'></div></div>", 
																 }]
															
															},
														
														
														    {//OPENING OF THE GRIDVIEW 
																									
																view:"grid",
																id:"billinggrid",
																select:true,
																datatype:"xml",
																url:"billing.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"customer",
																				width:350,
																				label:"Bill To ",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"amount",
																				label:"Amount",
																				width:250
																				
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  BILLING GRIDVIEW		
							{//OPEN THE PURCHASES GRIDVIEW
				
											id:"Purchasesgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadpurchasesgrid()", inputWidth:100},
																			{view:"button", label:"New Purchase", click:"addPurchases()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
																{
																view:"toolbar", type:"toolbar", elements:[
																 {
																	   id: "purchasesfilter",
																	   view: "text",
																	   inputWidth:750,
																	   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 2px 0'></div></div>", 
																 }]
															
															},
														
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"purchasesgrid",
																//select:true,
																datatype:"xml",
																url:"purchases.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"supplier",
																				width:350,
																				label:"Supplier",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																				{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"purchasesdate",
																				width:150,
																				label:"Date",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"total",
																				label:"Amount",
																				width:250
																				
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  PURCHASES GRIDVIEW	
							{//OPEN THE PURCHASES GRIDVIEW
				
											id:"Salesgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadsalesgrid()", inputWidth:100},
																			{view:"button", label:"New Sale", click:"addSales()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
															{
																view:"toolbar", type:"toolbar", elements:[
																 {
																	   id: "salesfilter",
																	   view: "text",
																	   inputWidth:750,
																	   label: "<div class='dhx_el_icon'><div class='dhx_el_icon_search' style='margin: 2px 0'></div></div>", 
																 }]
															
															},
															
															
														
														    {//OPENING OF THE GRIDVIEW 
																
																
																view:"grid",
																id:"salesgrid",
																select:true,
																datatype:"xml",
																url:"sales.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"customer",
																				width:350,
																				label:"Customer",
																				type:"custom"
																			},//CLOSE FIRST COLUMN DESCRIPTION
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"receiptdate",
																				label:"Date",
																				width:250
																				
																			},//CLOSE SECOND COLUMN DESCRIPTION
																			{//DESCRIPTION FOR THE THIRD COLUMN OF THE GRID
																				id:"amount",
																				label:"Amount",
																				width:250
																				
																			}//CLOSE THIRD COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  SALES GRIDVIEW		
							{//OPEN THE ITEM CATEGORIESGRIDVIEW
				
											id:"Itemcategoriesgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadcategoriesgrid()", inputWidth:100},
																			{view:"button", label:"Add Category", click:"addItemcategories()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														
														    {//OPENING OF THE  GRIDVIEW 
																
																
																view:"grid",
																id:"itemcategoriesgrid",
																select:true,
																datatype:"xml",
																url:"itemcategories.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"category",
																				label:"Category",
																				width:450,
																				type:"custom"
																			}//CLOSE FIRST COLUMN DESCRIPTION
																			
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  ITEM CATEGORIES GRIDVIEW		
							{//OPEN THE ITEM PAYMENT MODES GRIDVIEW
				
											id:"Paymentmodesgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadpaymentmodesgrid()", inputWidth:100},
																			{view:"button", label:"New Payment Mode", click:"addpaymentmodes()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														
														    {//OPENING OF THE  GRIDVIEW 
																
																
																view:"grid",
																id:"paymentmodesgrid",
																select:true,
																datatype:"xml",
																url:"paymentmodes.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"paymode",
																				label:"Payment Mode",
																				width:400,
																				type:"custom"
																			}//CLOSE FIRST COLUMN DESCRIPTION
																			
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  PAYMENT MODES GRIDVIEW		
							{//OPEN THE ITEM PAYMENT TERMS GRIDVIEW
				
											id:"Paymenttermsgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button",type:"prev",  label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadpaymenttermsgrid()", inputWidth:100},
																			{view:"button", label:"New Payment Terms", click:"addpaymentterms()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														
														    {//OPENING OF THE  GRIDVIEW 
																
																
																view:"grid",
																id:"paymenttermsgrid",
																select:true,
																datatype:"xml",
																url:"paymentterms.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{ //DESCRIPTION FOR THE FIRST COLUMN OF THE GRID
																				id:"payterms",
																				label:"Payment Terms",
																				width:400,
																				type:"custom"
																			}//CLOSE FIRST COLUMN DESCRIPTION
																			
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  PAYMENT TERMSGRIDVIEW		
							{//OPEN THE CAMPAIGNS GRIDVIEW
				
											id:"Currenciesgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button",type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button", label:"Refresh", click:"reloadcurrenciesgrid()", inputWidth:100},
																			{view:"button", label:"Add Currency", click:"addcurrencies()", inputWidth:200,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"currenciesgrid",
																select:true,
																datatype:"xml",
																url:"currencies.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																																						
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"currency",
																				label:"Currency",
																				width:450
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  CAMPAIGNS GRIDVIEW	
							
			
							{//OPEN THE BANK ACCOUNTS GRIDVIEW
				
											id:"Bankaccountsgrid",
													rows:[
															
														   {//OPEN THE GRIVIEW TOOLBAR
																view:"toolbar",
																elements:[
																			{view:"button", id:"accprev", type:"prev", label:"Back", click:"$$('tabview').show()", inputWidth:100},
																			{view:"button",id:"accref", label:"Refresh", click:"reloadbankaccountsgrid()", inputWidth:100},
																			{view:"button", id:"accadd", label:"Add Bank Account", click:"addbankaccounts()", inputWidth:250,align:"right"}
																		  ]
															},//CLOSE THE GRIDVIEW TOOLBAR
														
														    {//OPENING OF THE GRIDVIEW 
																view:"grid",
																id:"bankaccountsgrid",
																select:true,
																datatype:"xml",
																//url:"bankaccounts.php",
																fields:[//OPEN GRID FIELDS DESCRIPTION CONTAINER
																			{//DESCRIPTION FOR THE SECOND COLUMN OF THE GRID
																				id:"bank",
																				label:"Bank Account",
																				width:450
																			}//CLOSE SECOND COLUMN DESCRIPTION
																	],//CLOSE FIELDS DESCRIPTION
																
													      	}//CLOSE THE GRIDVIEW
												
													]//CLOSE THE GRID VIEW CONTAINER
							},//CLOSE THE  CAMPAIGNS GRIDVIEW	






</script>