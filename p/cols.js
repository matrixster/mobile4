// JavaScript Document

			function getGridheaders(id){
				
				switch(id){
				case "customers":
				var colhead='Customer,phone';
				return colhead ;
				break;
				case "recruitment":
				var colhead='Post,Interview Date';
				return colhead ;
				break;
				case "leave":
				var colhead='Employee,Start Date';
				return colhead ;
				case "leave":
				var colhead='Employee,Start Date';
				return colhead ;
				case "casuals":
				var colhead='Casual Name,Speciality';
				return colhead ;
				case "timesheet":
				var colhead='From Date,To Date';
				return colhead ;
				break;
				case "suppliers":
				var colhead='Supplier,phone';
				return colhead ;
				break;
				case "employees":
				var colhead='Employee Code,Employee Name';
				return colhead ;
				break;
				case "campaigns":
				var colhead='Campaign Name,Start Date';
				return colhead ;
				break;
				case "leads":
				var colhead='Lead Name,Source';
				return colhead ;
				break;
				case "customers":
				var colhead='Customer No.,Customer Name';
				return colhead ;
				break;
				case "products":
				var colhead='Product Name.,Product Price';
				return colhead ;
				break;
				case "allocations":
				var colhead='Customer Name,Product(s)';
				return colhead ;
				break;
				case "lettersofoffer":
				var colhead='Quote No.,Amount';
				return colhead ;
				break;
				case "productspayments":
				var colhead='Receipt No.,Amount';
				return colhead ;
				break;
				case "activity":
				var colhead='Sales Person,Activity';
				return colhead ;
				break;
				case "items":
				var colhead='Item Name,Quantity';
				return colhead ;
				break;
				
				case "itemrequisitions":
				var colhead='Requisition No.,Status';
				return colhead ;
				break;
				case "issues":
				var colhead='Issue No.,Task';
				return colhead ;
				break;
				
				case "stockcount":
				var colhead='Count Date,Status';
				return colhead ;
				break;
				case "goodsreceived":
				var colhead='GRN No.,Supplier';
				return colhead ;
				break;
				case "paymentsplan":
				var colhead='Plan Name,';
				return colhead ;
				break;
				
				case "itemcategories":
				var colhead='Category Name,';
				return colhead ;
				break;

				case "stores":
				var colhead='Store Name,';
				return colhead ;
				break;
				
				case "employeedetails":
				var colhead='Employee,Basic Pay';
				return colhead ;
				break;
				
				case "casualsdetails":
				var colhead='Casual Name,Gender';
				return colhead ;
				break;
				
				case "loans":
				var colhead='Employee Name,Amount';
				return colhead ;
				break;
				
				case "processpay":
				var colhead='Payroll,Period';
				return colhead ;
				break;
				case "casualspay":
				var colhead='Start Date,End Date';
				return colhead ;
				break;
				
				case "banks":
				var colhead='Bank Name';
				return colhead ;
				break;
				case "branches":
				var colhead='Branch Name';
				return colhead ;
				break;
				case "payrolls":
				var colhead='Payroll Name';
				return colhead ;
				break;
				case "paycodes":
				var colhead='Paycode (Code)';
				return colhead ;
				break;
				case "incometax":
				var colhead='Tier (Rate)';
				return colhead ;
				break;
				
				case "healthinsurance":
				var colhead='Tier (Rate)';
				return colhead ;
				break;
				case "socialsecurity":
				var colhead='Tier (Rate)';
				return colhead ;
				break;
				
				case "purchaseorders":
				var colhead='LPO NO.,Supplier';
				return colhead ;
				break;
				
				
				case "directorders":
				var colhead='LPO NO.,Supplier';
				return colhead ;
				break;
				
				case "assetcategories":
				var colhead='Asset Category,Abbrev';
				return colhead ;
				break;
				
				case "assets":
				var colhead='Asset Category,Serial No. (Price)';
				return colhead ;
				break;
				
				case "adjustments":
				var colhead='Item Code - Name,Adjustment type - Qty';
				return colhead ;
				break;
				
				case "assetrequisitions":
				var colhead='Asset Name,Qty (status)';
				return colhead ;
				break;
				
				case "purchaserequests":
				var colhead='Asset Name,Date';
				return colhead ;
				break;
				
				case "assetissues":
				var colhead='Asset Name,Issued to';
				return colhead ;
				break;
				
				
				
				case "disposals":
				var colhead='Asset Name,Disposal Date';
				return colhead ;
				break;
				
				case "receipts":
				var colhead='Received From,Date (Amount)';
				return colhead ;
				break;
				
				case "payments":
				var colhead='Payee,Date (Amount)';
				return colhead ;
				break;
				
				case "journals":
				var colhead='Journal No.,Date (Amount)';
				return colhead ;
				break;
				case "banktransfers":
				var colhead='Source,Destination';
				return colhead ;
				break;
				
				case "reconciliation":
				var colhead='Reconciliation Date,Amount';
				return colhead ;
				break;
				
				case "agents":
				var colhead='Agent  Name';
				return colhead ;
				break;
				case "locations":
				var colhead='Location,Phase';
				return colhead ;
				break;
				
				case "projects":
				var colhead='Project,Started on';
				return colhead;
				break;
				case "tasks":
				var colhead='Task Name,Start date';
				return colhead;
				break;
				case "projectbudget":
				var colhead='Task Name,Amount';
				return colhead;
				break;
				case "phases":
				var colhead='Phases';
				return colhead;
				break;
				
				case "projectdepartments":
				var colhead='Departments';
				return colhead;
				break;
				
				
				case "currencies":
				var colhead='Currency';
				return colhead;
				break;
				
				case "paymentmodes":
				var colhead='Payment modes';
				return colhead;
				break;
				
				case "paymentterms":
				var colhead='Payment terms';
				return colhead;
				break;
				
				case "accountperiods":
				var colhead='Period';
				return colhead;
				break;
				case "bankaccounts":
				var colhead='Account Name';
				return colhead;
				break;
				
				case "paycodegl":
				var colhead='Pay code';
				return colhead;
				break;
				case "accountgroups":
				var colhead='Account group';
				return colhead;
				break;
				case "chartofaccounts":
				var colhead='Chart of Account';
				return colhead;
				break;
				
				case "openingbalances":
				var colhead='Opening Balances CR-DR';
				return colhead;
				break;
				case "departmentgl":
				var colhead='Department GL';
				return colhead;
				break;
				case "tabsetup":
				var colhead='Petty Cash Tab,Limit';
				return colhead;
				break;
				
				case "expensesetup":
				var colhead='Expense Name,Chart of Account';
				return colhead;
				break;
				
				case "assigncashtotab":
				var colhead='Petty Cash Tab,Amount assigned';
				return colhead;
				break;
				
				case "claimexpenses":
				var colhead='Expense to,Amount';
				return colhead;
				break;
				
				case "debitnotes":
				var colhead='Supplier Name,Amount';
				return colhead;
				break;
				
				case "purchaseinvoices":
				var colhead='Supplier Name,Amount';
				return colhead;
				break;
				case "salesorders":
				var colhead='Customer Name,Amount';
				return colhead;
				break;
				
				case "salesinvoices":
				var colhead='Customer Name,Amount';
				return colhead;
				break;
				case "creditnotes":
				var colhead='Customer Name,Amount';
				return colhead;
				break;
				
				case "supplierbalances":
				var colhead='Supplier Name,Opening Balance';
				return colhead;
				break;
				case "cheques":
				var colhead='Party Involved,Cheque No. (Date)';
				return colhead;
				break;
				case"consumablesquotations":
				var colhead='Item Name,Code (No. of Quotes)';
				return colhead;
				break;
				case"assetquotations":
				var colhead='Asset Name,No. of Quotes';
				return colhead;
				break;
				case "processconsumableorders":
				var colhead='Supplier Name';
				return colhead;
				break;
				case "processassetorders":
				var colhead='Supplier Name';
				return colhead;
				break;
				
				case"appraisaltypes":
				var colhead='Appraisal Type';
				return colhead;
				break;


				case"contracttypes":
				var colhead='Contract type';
				return colhead;
				break;

				case"departments":
				var colhead='Department';
				return colhead;
				break;

				case"endreasons":
				var colhead='End reason';
				return colhead;
				break;

				case "holidays":
				var colhead='Holiday';
				return colhead;
				break;

				case "leavetypes":
				var colhead='Leave type';
				return colhead;
				break;
				case "posts":
				var colhead='Post';
				return colhead;
				break;
				case "sections":
				var colhead='Sections';
				return colhead;
				break;

				case "relationtypes":
				var colhead='Relation type';
				return colhead;
				break;

				case "qualificationtypes":
				var colhead='Qualification type';
				return colhead;
				break;
				
				case "casualrates":
				var colhead='Type of Work (Rate)';
				return colhead;
				break;

				default:
				var colhead='Header 1,Header 2';
				return colhead ;
				break;	
					
				}
			}