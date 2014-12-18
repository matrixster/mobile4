<?php 
include('combo.php');
require_once('config.php');
?>
<script>

function getForm(id){


	switch (id){
		case 'items':
		
		formConfig={
					 view:"form",
					 id:"itemsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
								{ gravity:1},
								{ view:"text", label:"Title", labelWidth: 120, name:"title" },
								{ view:"text", label:"Customer", labelWidth: 120,   name:"customer" },
								{ view:"text", label:"Customer No.",labelWidth: 120,  name:"code" },
								{ view:"text", label:"Status",labelWidth: 120,  name:"status" },
								{ view:"text", label:"Telephone",labelWidth: 120,  name:"tel" },
								{ view:"text", label:"Email",labelWidth: 120,  name:"email" },
								{ view:"text", label:"Address",labelWidth: 120,  name:"address" },
								{ view:"text", label:"City",labelWidth: 120,  name:"city" },
								{ gravity:2},
								
											
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		case 'campaigns':
		
		formConfig={
					 view:"form",
					 id:"campaignsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
								{ gravity:0},
								{ view:"text", label:"Record Id", labelWidth: 120, value:-1,id:"rid", hidden:true,name:"rid" },
								{ view:"text", label:"Campaign Name", labelWidth: 120, name:"cname" },
								{ view:"text", label:"Venue", labelWidth: 120,   name:"venue" },
								{ view:"datepicker", id:"sdate", label:"Start Date", dateFormat:"%d-%M-%Y",externalDateFormatStr:"%Y-%m-%d", externalDateFormat:"%Y-%m-%d %H:%i:%s",labelAlign:"left",labelWidth:120 },
								{ view:"datepicker", id:"edate", label:"Start Date", dateFormat:"%d-%M-%Y",externalDateFormatStr:"%Y-%m-%d", externalDateFormat:"%Y-%m-%d %H:%i:%s",labelAlign:"left",labelWidth:120 },
								{ view:"text", label:"Status",labelWidth: 120,  name:"status" },
								{ view:"text", label:"Memo",labelWidth: 120,  name:"memo" },
								{ gravity:2},
								
											
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		
		
		
		case 'employees':
		
		formConfig={
					 view:"form",
					 id:"employeesform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
								{ gravity:1},
								{ view:"text", label:"Title", labelWidth: 120, name:"title" },
								{ view:"text", label:"Surname", labelWidth: 120,   name:"surname" },
								{ view:"text", label:"Other Name", labelWidth: 120,   name:"othername" },
								{ view:"text", label:"Employee No.",labelWidth: 120,  name:"code" },
								{ view:"text", label:"Post",labelWidth: 120,  name:"post" },
								{ view:"text", label:"Telephone",labelWidth: 120,  name:"tel" },
								{ view:"text", label:"Email",labelWidth: 120,  name:"email" },
								{ view:"text", label:"Address",labelWidth: 120,  name:"address" },
								{ view:"text", label:"City",labelWidth: 120,  name:"city" },
								{ gravity:2},
								
											
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
			
		case 'casuals':
		
		formConfig={
					 view:"form",
					 id:"casualsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
								{ gravity:1},
								{ view:"text", label:"Title", labelWidth: 120, name:"title" },
								{ view:"text", label:"Surname", labelWidth: 120,   name:"surname" },
								{ view:"text", label:"Other Name", labelWidth: 120,   name:"othername" },
								{ view:"text", label:"Id No.",labelWidth: 120,  name:"idno" },
								{ view:"text", label:"Post",labelWidth: 120,  name:"post" },
								{ view:"text", label:"startdate",labelWidth: 120,  name:"startdate" },
								{ view:"text", label:"NHIF No.",labelWidth: 120,  name:"nhif" },
								{ view:"text", label:"NSSF No.",labelWidth: 120,  name:"nssf" },
								{ gravity:2},
								
											
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		case 'campaigns':
		
		formConfig={
					 view:"form",
					 id:"campaignsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
								{ gravity:1},
								{ view:"text", label:"Name", labelWidth: 120, name:"title" },
								{ view:"text", label:"Surname", labelWidth: 120,   name:"surname" },
								{ view:"text", label:"Other Name", labelWidth: 120,   name:"othername" },
								{ view:"text", label:"Id No.",labelWidth: 120,  name:"idno" },
								{ view:"text", label:"Post",labelWidth: 120,  name:"post" },
								{ view:"text", label:"startdate",labelWidth: 120,  name:"startdate" },
								{ view:"text", label:"NHIF No.",labelWidth: 120,  name:"nhif" },
								{ view:"text", label:"NSSF No.",labelWidth: 120,  name:"nssf" },
								{ gravity:2},
								
											
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		case 'leads':
		formConfig={
					 view:"form",
					 id:"leadsform",
					 datatype:"xml",
					// url:"../x/customers.php?id=1",
					 elements:[
								{ gravity:0},
								{ view:"text", label:"Record Id", labelWidth: 120,id:"rid", hidden:true,name:"rid" },
								{ view:"text", label:"Title", labelWidth: 120, name:"title" },
								{ view:"text", label:"Lead", labelWidth: 120, value:"",  id:"lead" },
								{ view:"text", label:"Campaign", labelWidth: 120,value:"",  id:"campaign", name:"campaign",hidden:true },
								{ view:"richselect", id:"campaigncom", label: 'Source',labelWidth: 120,  yCount:"5", options:[ <?php echo getCombo('campaign'); ?>]},
								{ view:"text", label:"Telephone",labelWidth: 120,  name:"tel" },
								{ view:"text", label:"Email",labelWidth: 120,  name:"email" },
								{ view:"text", label:"Address",labelWidth: 120,  name:"address" },
								{ view:"text", label:"City",labelWidth: 120,  name:"city" },
								{ gravity:2},
								{rules:[{ lead:dhx.rules.isNotEmpty}]}
								
											
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		case 'products':
		
		formConfig={
					 view:"form",
					 id:"productsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
							{ gravity:0},
						    { view:"text", label:"Product Name",labelWidth: 120, name:"product_name" },
							{ view:"richselect", id:"catid", label: 'Type',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							{ view:"text", label:"Product Code",labelWidth: 120, name:"item_code" },
							{ view:"text", label:"Price.",labelWidth: 120, name:"price" },
							{ gravity:1},
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		
		case 'allocations':
		
		
		formConfig={
					 view:"form",
					 id:"allocationsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
							{ gravity:0},
						    { view:"richselect", id:"customer", label: 'Customer',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							{ view:"richselect", id:"product", label: 'Product',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							{ view:"richselect", id:"catid", label: 'Type',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							{ view:"date", label:"Allocation Date",labelWidth: 120, name:"allocdate" },
							{ view:"text", label:"Price.",labelWidth: 120, name:"price" },
							{ gravity:1},
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		
		case 'lettersofoffer':
		
		formConfig={
					 view:"form",
					 id:"lettersofofferform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
							 { gravity:0},
						     { view:"richselect", id:"customer", label: 'Customer',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							 { view:"richselect", id:"product", label: 'Product',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							 { view:"text", label:"Letter No.",labelWidth: 120, name:"letter_no" },
							 { view:"text", label:"Date Issued",labelWidth: 120, name:"dateissued" },
							 { gravity:1},
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER


		return  formConfig;
		break;
		
		case 'productspayments':
		
		formConfig={
					 view:"form",
					 id:"productspaymentsform",
					 datatype:"xml",
					 url:"../x/customers.php?id=1",
					 elements:[
							 { gravity:0},
						     { view:"richselect", id:"customer", label: 'Customer',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							 { view:"richselect", id:"product", label: 'Product',labelWidth: 120, value: "1", yCount:"5", options:[	]},
							 { view:"text", label:"Receipt No.",labelWidth: 120, name:"receiptno" },
							 { view:"text", label:"Amount",labelWidth: 120, name:"amount" },
							 { view:"text", label:"Date Paid",labelWidth: 120, name:"datepaid" },
							 { gravity:1},
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
			  }//CLOSE FORMVIEW CONTAINER
		return  formConfig;
		break;
		
		default:
		formConfig={
					 view:"form",
					 id:t+"form",
					 datatype:"xml",
					 url:"defaultform",
					 elements:[
							 { gravity:0},
							 { gravity:1},
							  ]//END OF THE FORMVIEW ELEMENTS CONTAINER
					
			  }//CLOSE FORMVIEW CONTAINER
		return  formConfig;
		break;
	
	}
	

	
	
}





	function getValues(id){
		
		
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
				
					var myAjaxPostrequest=new GetXmlHttpObject();
				    var parameters = "id="+id;
					myAjaxPostrequest.open("POST","combo.php", true);
					myAjaxPostrequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					myAjaxPostrequest.send(parameters);
					myAjaxPostrequest.onreadystatechange=function(){
						if(myAjaxPostrequest.readyState==4){
							if(myAjaxPostrequest.status==200){
								
							}
						}

					}
						
		
	}
	
	

</script>