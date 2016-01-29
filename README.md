# OMS Version 1.2.1.189 Changes
- During edit mode in item details popup window, show a notice for vendor account no saying it can be edited in vendors popup; 1/28/2016
- Add 'quantity' column to admin orders table; 1/28/2016
- Remove forward slash for the projects that have no number; 1/28/2016
- Change the order of the users in users popup window, showing the last registered user on top; 1/28/2016
- Add 'archived' and 'in concur' as order status; 1/28/2016
- Add redirect to the autorefresh if the session is invalid; 1/28/2016
- Make all the vendors visible to admin in add new item and item details popups (including non-approved ones); 1/28/2016
- **Bug Fix:** Upon update, the vendor name and the price are not updated in item details popup window; 1/28/2016
- **Bug Fix:** Vendor sort alphabetically doesn't work; 1/28/2016
- **Bug Fix:** Price decimals are not saved if they are 0; 1/28/2016


### Database Changes
##### **'orders'** table:  
- **'price'** field type was changed from *float* to *decimal(20,2)*
