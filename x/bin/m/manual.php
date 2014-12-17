<?php
session_start();
require_once('../../bin/w_init.php');

$oVIP->selfurl = '#';
$oVIP->selfname = 'User Manual';
$_SESSION[QHR]['site_name'] = $oVIP->selfname;

include('../../header.php');
?>
<table width="100%" border="0" class="ta ta_t" cellpadding="0">
  <tr>
  	<td class="td_t td_t_tit1"><b><u>USER MANUAL</u></b></td>
  </tr>
  <tr>
  	<td class="td_t td_t_tit1">
    <u>Table of contents</u>
    <ol style="line-height:inherit">
    	<li>Introduction
        <li>Modules
        <li>Opening new accounts</li>
        <li>Human Resource</li>
        <li>Inventory</li>
        <li>Procurement</li>
        <li>Accounting</li>
        <li>Payroll</li>
        <li>Fixed Assets</li>
        <li>Project Management</li>
    
    </td>
  </tr>
  <tr>
    <td class="td_t td_t_tit1">
    1. Introduction<br />
The information in this document is for referesnce purposes only. All information provided here is correct. Wavuh Ltd shall not be held liable for any errors contained herein or 
Accessing the software
Wavuh can be loaded by entering the URL www.wavuh.com into your browser.<br /><br />
2. Modules<br />
These are the various components that the software is divided into. They are 8 in total which cover the full functionality of the application. Each module then contains forms which help to determine up to what point the role assignment can be determined.
As such the following are the various modules on Wavuh
<ul style="list-style-type:disc;" >
<li>Human Resource – to manage all member of staff</li>
<li>CRM – to manage all your customers and customer relationships</li>
<li>Payroll – to manage your staffer payments</li>
<li>Accounts – to manage your finances</li>
<li>Inventory Management – to manage your inventory</li>
<li>Procurement – to ensure</li>
<li>Project Management – to manage your projects</li>
<li>Fixed Assets – to manage your assets</li>
</ul>
3. Using Wavuh<br />
<i>Opening a new  account</i><br />
An account can be opened by simply  clicking on the ‘Don't have a Wavuh Account? Get one here’ from your Wavuh homepage. Once this is done, you will need to fill a form with your details such as the organization name, industry, email, username and a password. Once this is done you will get a confirmation email of the status of the Wavuh account.<br />
<i>Login</i><br />
In the case you already have a Wavuh account, you will be able to log into your account by simply entering your username and password once you have accessed www.wavuh.com
<i>Homepage</i><br />
Once you are logged into your Wavuh account you will be able to view your homepage which contains various summary information such as the latest items in your various modules  and any issues that require your immediate action
<i>User Manager</i><br />
Wavuh allows for multiple access per company. A company that is registered on Wavuh can have mant users registered such that they are able to perform several functions in the system<br />
<i>Profiles</i><br />
All users are categorized into profiles. These profiles help in determining what a specific role has access to in the system. The software comes with a default ‘Sys Admin’ which is for the person who created the Wavuh account. The Sys Admin then has to create various profiles/roles depending on what functions he intends his users to perform.<br />
<i>Users</i><br />
Once the profiles are in place the Sys Admin can then create the users (username  and password) and then assign each of the users to a specific profile depending on what their role in the business operations are.<br /><br />
4. Human Resource<br />
This module contains several sub-modules which in turn contain various forms in them
<ul style="line-height:inherit">
<li>Setup – this contains all the parent data without which the system may not function correctly. These include the organizational setup, departments, sections, posts/positions, leave types, stations, employment types, relation types, qualification types, end-of-contract reason and appraisal types. To add any of the items above, simple visit the corresponding tab. Click on the Add [item] link and then enter the respective details of the same and save. To edit, you simply click on the item, make your changes and save.</li>
<li>Employees – this is the management of the employees on Wavuh. It contains the various information that is collected and stored about the employees and the functions that can be performed to employee data. This information includes bio data, employment history, kin members, referees, awards, appraisal, promotion, disciple, qualifications, training and safety items.</li>
<li>To add employees, simply click on the add employee link under the Employees Tab. Once the employee is added you can then add other data by clicking on the Add [item] link and then entering the respective details of the same and save. To edit, you simply click on the item, make your changes and save.</li>
<li>Leave – this module helps to manage the leave the employee has. Depending on the leave types as defined on the setup, the number of days are deducted/added as the leave are approved/rejected respectively. To add a new leave, click on the Add Leave link, select the employee and leave type to display the outstanding leave types and then add the leave the employee intends to take. Once this is done, the corresponding supervisors will then review and approve the leave in order to reduce the leave days. In the case of reversals, the supervisors can unapproved.</li>
<li>Interviews – this is in order to facilitate the filling up of positions in the organization. The first step is to schedule the interview by assigning the panel and the job title/post/position. Once this is done the various applicants are captured in the system. These are then shortlisted and once the interviews are done and there’s mutual satisfaction about a candidate then he/she is moved into the employees.</li>
</ul>
5. Inventory<br />
This module is for managing all the stocks items that are in use by the registered organization. It contains several sub modules are shown below:<ul style="line-height:inherit">
<li>Setup – this contains all the parent data without which the module may not function correctly.  These include stores in which to store the stock items, Units of measurement used to purchase and/or sell/dispense/dispose the items, item categories. To add any of the items above, simple visit the corresponding tab. Click on the Add [item] link and then enter the respective details of the same and save. To edit, you simply click on the item, make your changes and save.</li>
<li>Items – this is sub module that deals with the actual stock items.  To add an items, simply click on the Add item link and then enter stock item details and then save. To edit, you simply click on the item, make your changes and save.</li>
<li>Item request – these are the requisitions raised for the various items accesible via the Item Request tab. To add a requisition, go to 'Add Requisition' link. Gets started by clicking on the provided button after which you can now start adding items to the requistion via the 'Add items' link then clicking on the 'Back to requisition' link. A requisition data entry is done, one is able to have it reviewed and approved by the supervisor(s) before it can be ready to be issued.</li>
<li>Issues – approved requisitions are issued from the stores by the store manager. In order to create issue an approved requisition click on the 'issue' link under the requisitions and then saving the newly <i>proposed</i> issue. After saving an issue, the stock items are reduced from stock. There’s also a link to return items into stock if this is deemed necessary. This is done by clicking on the 'return to store' link for every corresponding item to be returned from the issue.</li>
<li>Goods received – in this module goods are received into the system. To create a new Goods Received Note (GRN)  click on the 'Receive goods' tab (from where you view all GRNs), then clicking on the 'Receive Goods' link. Add the Delivery Number, Date, supplier, LPO Number and reference number (invoice/receipt) then clicking the 'Click to get started' button. Details of the items to be receive are entered. Once an item is received/saved it is added into stock. You can return to the GRN by clicking on the 'Done with line input' link. It is also possible to return items to the suppliers by reversing a GRN line. This will in turn reduce the items in stock.</li>
<li>Stock Transfers  - this is the movement of stock items from one store to another. You perform a transfer by clicking on the 'Stock Transfer' tab to view the list of all transfers to date, then the 'Perform Transfer' link, enter the details such as the dispensing store, the date of transfer, clicking on the 'Click to get started' button and then entering the items that are being transferred and the store they shall be in. This, once approved and posted, will reduce the amount of stock of the items in the stores respectively.</li>
<li>Stock adjustments – this sub-module makes direct adjustments in the stock numbers, for instance, in the case the physical and the actual stock counts are not matching in the system. To perform an adjustment, click the 'Stock Adjustments' tab to view the list of adjustments performed to date then clicking on the 'Perform Adjustment' link. You shall then select item to adjust, the store being adjusted, whether it is an increment or decrease adjustment, number being adjusted, reason for adjustment and notes if necessary then saving the details. To perform actual stock adjustment in the system post the adjustment. You can edit the details of the adjustment before posting by clicking on the corresponding adjustment and editing and saving the changes.</li>
<li>Stock count – this is to check on the particular stock levels/number of stock items at any particular moment. You view the current state of the stock levels by clicking on the 'Stock count' tab. To perform a stock count, simply click on the 'Perform stock count' link. To view the previous stock counts done in the same click on the 'View past counts' link.</li>
</ul>
6. Procurement<br />
This is the module that facilitates the ordering of stock items and fixed assets to be bought from the various suppliers in the system (that the organization deals with). It contains the following modules.<ul style="line-height:inherit">
<li>Suppliers – this manages all the suppliers that the organization deals with one way or another. In order to add a supplier, click on the Add supplier link, enter all the supplier details and save. In order to edit, simply click on the supplier as listed, make changes and save.</li>
<li>Quotations – this is the direct connection between suppliers and item products. All the various quotations from the suppliers per item are saved in this sub-module. This is so as to rank as to what price is on offer per item. One supplier(price) is locked per item and this is the default supplier/item that will be used to order the item. To enter a quotation for an item, click on the 'Quotations' tab then the item you'd like to add quotations to. Select the supplier, price and any comments. The 'Primary' field indicates that they given quotation has been selected as the supplier to deliver the said item. You can add as many quotes per item as you want.</li>
<li>Processing of POs – depending shortlisted price/supplier per item, in the case stock items are running low at the stores and LPO is raised per supplier to facilitate the accounts department to pay for the items and the store manager to order them</li>
<li>LPOS – this is simply a listing of the processed LPOs.</li>
</ul>
7. Accounting<br />
This is the module that deals with the organization’s finances. Indicates what cash is flowing, what cash is going out, what budgets were made, where needs improvement; in a word, this module indicates the profits/losses of the organization.<ul style="line-height:inherit">
<li>Setup  – this contains all the parent data without which the module may not function correctly.  These include the various tax bracket/rates applicable, banks, payment modes, payment terms, schemes, accounting groups and the chart of accounts. To add any of the items above, simple visit the corresponding tab. Click on the Add [item] link and then enter the respective details of the same and save. To edit, you simply click on the item, make your changes and save.</li>
<li>General ledger – this is the setup, at a higher level, that determines the accounting information essential to running accounting functions in the organization. This includes the bank account(s) that will be paying out/receiving monies, the GL setup which determines what chart of account is relevant per function so that any postings done from the other system modules are automatically allocated to the corresponding chart of accounts, the periods (monthly) that have had accounting data posted in them and the various balances in the chart of accounts.</li>
<li>Budget – this helps to determine what amount of money is expected to be spent per cost center of the organization. This is important so as to check the expenditure. To save the budget simply select the account (chart) and enter the amounts expected to be spent per month during the year.</li>
<li>Sales – This is directly linked to the CRM and helps to determine what sales orders and invoices have been generated from the customers and making receipt entries against them.</li>
<li>Purchases – this is directly linked to the procurement module and helps to determine what purchase orders have been generate from the suppliers and making payment entries against them.</li>
<li>Cashbook – this is the actual payments and receipts of monies. IT also handles the entries entered in Sales and Purchases by posting them in order to reflect the movement of funds appropriately.</li>
<li>Banking – this contains the handling of banking functions such as direct deposits (in the case the receipts are not directly received into the bank account, conducting bank reconciliation (in the case there’s a difference between monies expected in the bank from the system and what is actually available in the bank) and transfers which facilitates movement of monies between bank accounts or from bank accounts to suspense accounts.</li>
<li>Journals – these are used to reverse any transactions that were conducted in the system that may need to be revoked or reversed. To perform a journal simply click on the Create Journal link, enter the account (chart) which you’d like to reverse, then enter the account into which the reversal amount must be returned, the amount in question and an option narrative to explain the reversal. Then save. This will reverse the transaction completely.</li>
</ul>
    
    </td>
  </tr>
</table>
<?php
include('../../footer.php');
?>