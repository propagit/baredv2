SimpleXMLElement Object ( [timeStamp] => 2014-07-21 13:17:31 [employeeID] => 35 [discountID] => 2 [completed] => true [customerID] => 37453 [shopID] => 1 [registerID] => 1 [taxCategoryID] => 1 [ShipTo] => SimpleXMLElement Object ( [shipped] => false [timeStamp] => 2014-07-21 13:17:31 [shipNote] => SimpleXMLElement Object ( ) [firstName] => Maddy [lastName] => Cameron [Contact] => SimpleXMLElement Object ( [timeStamp] => 2014-07-21 13:17:31 [Addresses] => SimpleXMLElement Object ( [ContactAddress] => SimpleXMLElement Object ( [address1] => 13 Doolan Street [city] => Invermay [state] => 5 [zip] => 7248 [country] => 13 ) ) [Phones] => SimpleXMLElement Object ( [ContactPhone] => SimpleXMLElement Object ( [number] => SimpleXMLElement Object ( ) [useType] => Home ) ) ) ) [SaleLines] => SimpleXMLElement Object ( [SaleLine] => Array ( [0] => SimpleXMLElement Object ( [unitQuantity] => 1 [unitPrice] => 249.00 [tax] => false [customerID] => 37453 [itemID] => 3157 ) [1] => SimpleXMLElement Object ( [unitQuantity] => 1 [unitPrice] => 0.00 [tax] => false [customerID] => 37453 [Note] => SimpleXMLElement Object ( [noteID] => 10868 [note] => Shipping Cost [isPublic] => false [timeStamp] => 2014-07-21 13:17:31 [employeeID] => 35 ) ) ) ) [SalePayments] => SimpleXMLElement Object ( [SalePayment] => SimpleXMLElement Object ( [amount] => 249 [paymentTypeID] => 13 [registerID] => 1 ) ) ) 

SimpleXMLElement Object ( [timeStamp] => 2014-07-22 12:41:10 [employeeID] => 35 [discountID] => 2 [completed] => true [customerID] => 37447 [shopID] => 1 [registerID] => 1 [taxCategoryID] => 1 [ShipTo] => SimpleXMLElement Object ( [shipped] => false [timeStamp] => 2014-07-22 12:41:10 [shipNote] => SimpleXMLElement Object ( ) [firstName] => Kayla [lastName] => Megan [Contact] => SimpleXMLElement Object ( [timeStamp] => 2014-07-22 12:41:10 [Addresses] => SimpleXMLElement Object ( [ContactAddress] => SimpleXMLElement Object ( [address1] => 2/29 Denman St [city] => Alderley [state] => 3 [zip] => 4051 [country] => 13 ) ) [Phones] => SimpleXMLElement Object ( [ContactPhone] => SimpleXMLElement Object ( [number] => SimpleXMLElement Object ( ) [useType] => Home ) ) ) ) [SaleLines] => SimpleXMLElement Object ( [SaleLine] => Array ( [0] => SimpleXMLElement Object ( [unitQuantity] => 1 [unitPrice] => 229.00 [tax] => false [customerID] => 37447 [itemID] => 152 ) [1] => SimpleXMLElement Object ( [unitQuantity] => 1 [unitPrice] => 0.00 [tax] => false [customerID] => 37447 [Note] => SimpleXMLElement Object ( [noteID] => 10866 [note] => Shipping Cost [isPublic] => false [timeStamp] => 2014-07-22 12:41:10 [employeeID] => 35 ) ) ) ) [SalePayments] => SimpleXMLElement Object ( [SalePayment] => SimpleXMLElement Object ( [amount] => 229 [paymentTypeID] => 7 [registerID] => 1 ) ) ) SimpleXMLElement Object ( [httpCode] => 500 [httpMessage] => Internal Server Error [message] => Invalid foreign keys for Note: 10866 File: /web/cloud/includes/data/io/sql/query/Generalist.class.php Line: 118 (/web/cloud/includes/controller/Master.class.php on line 69) [backtrace] => #0 /web/cloud/includes/api/entry_point.php(111): controller_Master::dispatch(Object(RestRequest), Object(Badge)) #1 /web/cloud/www/API/index.php(3): include('/web/cloud/incl...') #2 {main} [errorClass] => Exception ) 




<?xml version='1.0'?>
				<Sale>
				  <timeStamp>2014-07-22 13:18:18</timeStamp>
				  <employeeID>35</employeeID>
				  <discountID>2</discountID>
				  
				  <completed>true</completed>
				  <customerID>37447</customerID>	
				  <shopID>1</shopID>		  
				  <registerID>1</registerID>
				  <taxCategoryID>1</taxCategoryID>
				  <ShipTo>
					<shipped>false</shipped>
					<timeStamp>2014-07-22 13:18:18</timeStamp>
					<shipNote></shipNote>
					<firstName>Kayla</firstName>
					<lastName>Megan</lastName>				
					<Contact>
					  <timeStamp>2014-07-22 13:18:18</timeStamp>
					  <Addresses>
						<ContactAddress>
						  <address1>2/29 Denman St</address1>					 
						  <city>Alderley</city>
						  <state>3</state>
						  <zip>4051</zip>
						  <country>13</country>
						</ContactAddress>
					  </Addresses>
					  <Phones>
						<ContactPhone>
						  <number></number>
						  <useType readonly='true'>Home</useType>
						</ContactPhone>
					  </Phones>
					</Contact>
				  </ShipTo>
				  <SaleLines>
				  
					<SaleLine>
					  <unitQuantity>1</unitQuantity>
					  <unitPrice>229.00</unitPrice>					  
					  <tax>false</tax>  					  
  					  <customerID>37447</customerID>
					  <itemID>152</itemID>	  					  
					</SaleLine>
				 
					<SaleLine>
					  <unitQuantity>1</unitQuantity>
					  <unitPrice>0.00</unitPrice>					  
					  <tax>false</tax>  					  
  					  <customerID>37447</customerID>
					  <Note>
    					<noteID>10866</noteID>
    					<note>Shipping Cost</note>
    					<isPublic>false</isPublic>
    					<timeStamp>2014-07-22 13:18:18</timeStamp>
						<employeeID>35</employeeID>
  						</Note>
		
					</SaleLine>
				
				  </SaleLines>
				  <SalePayments>
					<SalePayment>
					  <amount currency='AUD'>229</amount>
					  <paymentTypeID>7</paymentTypeID>
					  <registerID>1</registerID>
					</SalePayment>
				  </SalePayments>
				</Sale>



A PHP Error was encountered

Severity: Notice

Message: Undefined variable: si

Filename: controllers/lightspeed.php

Line Number: 566

A PHP Error was encountered

Severity: Notice

Message: Undefined variable: si

Filename: controllers/lightspeed.php

Line Number: 567

A PHP Error was encountered

Severity: Warning

Message: Cannot modify header information - headers already sent by (output started at /home/baredcom/public_html/system/application/controllers/lightspeed.php:523)

Filename: helpers/url_helper.php

Line Number: 541



Array
(
    [0] => Array
        (
            [id] => 877
            [customer_id] => 1202
            [session_id] => e228e0c9ac370eaa899bab7630aeefbc
            [order_time] => 2014-07-20 20:11:44
            [subtotal] => 208.18
            [gift_card] => 0.00
            [lightspeed_order_id] => 22915
            [lightspeed_date] => 2014-07-20 20:15:06
            [coupon_code] => SPRINGFEVER
            [promotion_code] => 
            [discount] => 0.00
            [member_discount] => 0.00
            [tax] => 20.82
            [shipping_cost] => 0.00
            [shipping_method] => 2
            [shipping_weight] => 15.00
            [shipping_weight_method] => 2
            [weight] => 5
            [cost_weight] => 3.00
            [cost_flat] => 0
            [total] => 229.00
            [firstname] => Jonathan
            [lastname] => Choi
            [address] => Unit 323B, 2B Help Street
            [address2] => 
            [city] => Chatswood
            [state] => 2
            [country] => 13
            [postcode] => 2067
            [email] => jcnchoi@gmail.com
            [message] => 
            [cardname] => 
            [cardtype] => 
            [cardnumber] => 
            [expmonth] => 
            [expyear] => 
            [cvv] => 
            [status] => successful
            [order_status] => processed
            [msg] => Paypal
            [txn_id] => 963019980T738212A
            [txn_type] => cart
            [payment_date] => 03:11:27 Jul 20, 2014 PDT
            [payment_gross] => 
            [payment_status] => Completed
            [gift] => N
            [gift_bg] => 0
            [gift_sender] => 
            [receipt_name] => -
            [receipt_email] => -
            [send_on] => 0000-00-00
            [gift_notes] => -
            [tracking_number] => 
            [admin] => 0
            [admin_id] => 0
            [export] => 0
        )

)

Error [MySQL]: 
Error 1064 : You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'AND transaction_line.parent_trans_line_uid = refund_line.transaction_line_id' at line 1

SQL = [SELECT DISTINCT transaction_line.transaction_id FROM transaction_line, transaction_line as refund_line WHERE refund_line.transaction_id =  AND transaction_line.parent_trans_line_uid = refund_line.transaction_line_id]





[Backtrace]
0: file:/web/cloud/includes/database/database.inc.php line:515 function:include 
-args:
2: file:/web/cloud/includes/database/database.inc.php line:342 function:db_query 
-args:    0 = [SELECT DISTINCT transaction_line.transaction_id FROM transaction_line, transaction_line as refund_line WHERE refund_line.transaction_id =  AND transaction_line.parent_trans_line_uid = refund_line.transaction_line_id]
    1 = [user]
3: file:/web/cloud/includes/gui_defs/transaction/views/transaction.class.php line:456 function:db_execute 
-args:    0 = [SELECT DISTINCT transaction_line.transaction_id FROM transaction_line, transaction_line as refund_line WHERE refund_line.transaction_id =  AND transaction_line.parent_trans_line_uid = refund_line.transaction_line_id]
4: file:/web/cloud/includes/gui_defs/transaction/views/transaction.class.php line:285 function:add_has_refunds 
-args:    0 = [details]
    1 = [0]
5: file:/web/cloud/includes/gui_defs/view_base.class.php line:584 function:add_tab_fields 
-args:    0 = [details]
6: file:/web/cloud/includes/forms/gen/view.php line:28 function:loadTab 
-args:    0 = [payments]
    1 = [10866]
    2 = []
7: file:/web/cloud/includes/process_forms.php line:177 function:include 
-args:    0 = [/web/cloud/includes/forms/gen/view.php]
8: file:/web/cloud/includes/startup.php line:256 function:require_once 
-args:    0 = [/web/cloud/includes/process_forms.php]
9: file:/web/cloud/www/index.php line:3 function:include 
-args:    0 = [/web/cloud/includes/startup.php]
[Session]
    location_num = []
    user_db = [cust61853]
    user_dbhost = [mylocaldb6]
    cust_customer_id = [61853]
    modules = [
        61853 = [Array of length 12]]
    user_type = [0]
    authorized = [1]
    cust_user_id = [130611]
    owner = [1]
    cust_customer_status = [customer]
    api_client_hash = [WebPOSAPIClient]
    cust_customer_name = [Bared Footwear]
    full_catalog = [1]
    open_user_slots = [7]
    employee_id = [1]
    rights = [
        allow_login = [1]
        register = [1]
        register_refund = [1]
        register_open = [1]
        register_withdraw = [1]
        register_close = [1]
        register_price = [1]
        register_reopen = [1]
        register_catalogs = [1]
        register_layaway = [1]
        register_line_discount = [1]
        register_transaction_discount = [1]
        inventory = [1]
        reports = [1]
        workbench = [1]
        change_password = [1]
        messages_read = [1]
        messages_send = [1]
        customers = [1]
        customers_credit_limit = [1]
        admin = [1]
        admin_shops = [1]
        admin_employees = [1]
        admin_purchases = [1]
        admin_void_sale = [1]
        admin_inventory = [1]
        owner = [1]]
    smarty_assigned = [
        timeout_delay = [60]]
    employee_name = [Anna Baird]
    login_name = [anna@bared.com.au]
    messages_off = [0]
    shop_id = [1]
    tax_rate = [0.000000000]
    shop_name = [Bared Pty Ltd]
    service_rate = [0.00]
    tax_category_id = [0]
    tax_labor = [0]
    time_zone = [Australia/Sydney]
    default_payment_type_id = [1]
    register_id = [1]
    register_name = [Register 1]
    industry_ids = ['35']
    catalog_ids = ['1570','2284','31003','43241','93385','95607','95613','95663','95665','95667','95671','95699','95807','96745','96767','96823','96845','96861','96867','97909','97913','97951','98059','98074','98285']
    auto_needpin_delay = [0]
    auto_logout_delay = [60]
    limit_to_shop_id = [0]
    last_session_db_write = [1406001944]
    last_lockout_check = [1406002599]
    lasttime = [1406002599]
    merchantos_always_last = [1405994171]
    recent = [
        customer = [Array of length 5]]
[Included Files]
    0 = [/web/cloud/www/index.php]
    1 = [/web/includes/include_config.php]
    2 = [/web/cloud/includes/startup.php]
    3 = [/web/cloud/includes/config.php]
    4 = [/web/cloud/includes/local_config.php]
    5 = [/web/cloud/includes/config/cloud.config.php]
    6 = [/web/cloud/includes/SmartyBikeSoft.class.php]
    7 = [/web/cloud/includes/Smarty.class.php]
    8 = [/web/cloud/includes/bs_datetime.class.php]
    9 = [/web/cloud/includes/bs_date_range.class.php]
    10 = [/web/cloud/includes/utils.inc.php]
    11 = [/web/cloud/includes/bikesoft_ids.php]
    12 = [/web/cloud/includes/helpers/Configuration.class.php]
    13 = [/web/cloud/includes/data/Access.class.php]
    14 = [/web/cloud/includes/helpers/mb_functions.php]
    15 = [/web/cloud/includes/data/access/Foreign.class.php]
    16 = [/web/cloud/includes/business/Process.class.php]
    17 = [/web/cloud/includes/business/Component.class.php]
    18 = [/web/cloud/includes/business/process/Data.class.php]
    19 = [/web/cloud/includes/business/process/Base.class.php]
    20 = [/web/cloud/includes/data/access/Tag.class.php]
    21 = [/web/cloud/includes/data/Primitive.class.php]
    22 = [/web/cloud/includes/data/primitive/Money.class.php]
    23 = [/web/cloud/includes/services/Service.class.php]
    24 = [/web/cloud/includes/helpers/APIErrors.class.php]
    25 = [/web/cloud/includes/helpers/Errors.class.php]
    26 = [/web/cloud/includes/helpers/Airbrake.class.php]
    27 = [/web/cloud/includes/api/includes/RestRequest.class.php]
    28 = [/web/cloud/includes/helpers/XML.class.php]
    29 = [/web/cloud/includes/helpers/JSON.class.php]
    30 = [/web/cloud/includes/api/includes/RestUtilities.class.php]
    31 = [/web/cloud/includes/data/Base.class.php]
    32 = [/web/cloud/includes/data/FieldSet.class.php]
    33 = [/web/cloud/includes/data/MetaData.class.php]
    34 = [/web/cloud/includes/helpers/Validation.class.php]
    35 = [/web/cloud/vendor/autoload.php]
    36 = [/web/cloud/vendor/composer/autoload_real.php]
    37 = [/web/cloud/vendor/composer/ClassLoader.php]
    38 = [/web/cloud/vendor/composer/include_paths.php]
    39 = [/web/cloud/vendor/composer/autoload_namespaces.php]
    40 = [/web/cloud/vendor/composer/autoload_psr4.php]
    41 = [/web/cloud/vendor/composer/autoload_classmap.php]
    42 = [/web/cloud/includes/database/bs_table.class.php]
    43 = [/web/cloud/includes/helpers/EventQueue.class.php]
    44 = [/web/cloud/includes/database/database.inc.php]
    45 = [/web/cloud/includes/database/db_shard_connection.class.php]
    46 = [/web/cloud/includes/login_state.class.php]
    47 = [/web/cloud/includes/api/rateLimit.class.php]
    48 = [/web/cloud/includes/mos_memcache.class.php]
    49 = [/web/cloud/includes/db_session.php]
    50 = [/web/cloud/includes/helpers/SessionCache.class.php]
    51 = [/web/cloud/includes/helpers/KVP_Cache.class.php]
    52 = [/web/cloud/includes/lib/aws/sdk.class.php]
    53 = [/web/cloud/includes/.aws/sdk/config.inc.php]
    54 = [/web/cloud/includes/lib/aws/utilities/credentials.class.php]
    55 = [/web/cloud/includes/lib/aws/services/dynamodb.class.php]
    56 = [/web/cloud/includes/lib/aws/utilities/utilities.class.php]
    57 = [/web/cloud/includes/lib/aws/utilities/credential.class.php]
    58 = [/web/cloud/includes/process_forms.php]
    59 = [/web/cloud/includes/database/bs_cust_customer.class.php]
    60 = [/web/cloud/includes/database/bs_cust_user.class.php]
    61 = [/web/cloud/includes/forms/always_process.php]
    62 = [/web/cloud/includes/forms/module_always/merchantos.php]
    63 = [/web/cloud/includes/database/bs_employee.class.php]
    64 = [/web/cloud/includes/database/bs_shop.class.php]
    65 = [/web/cloud/includes/helpers/LabelTitle.class.php]
    66 = [/web/cloud/includes/forms/gen/gen.php]
    67 = [/web/cloud/includes/gui_defs/ajax_msgs.class.php]
    68 = [/web/cloud/includes/gui_defs/gui_component.class.php]
    69 = [/web/cloud/includes/gui_defs/rights_checker.class.php]
    70 = [/web/cloud/includes/forms/gen/view.php]
    71 = [/web/cloud/includes/gui_defs/transaction/views/transaction.class.php]
    72 = [/web/cloud/includes/gui_defs/generic/views/attach_customer.class.php]
    73 = [/web/cloud/includes/gui_defs/view_base.class.php]
    74 = [/web/cloud/includes/gui_defs/field_base.class.php]
    75 = [/web/cloud/includes/gui_defs/form_base.class.php]
    76 = [/web/cloud/includes/database/bs_transaction.class.php]
    77 = [/web/cloud/includes/database/bs_transaction_line.class.php]
    78 = [/web/cloud/includes/helpers/Print.class.php]
    79 = [/web/cloud/includes/error_helper_functions.php]
    80 = [/web/cloud/includes/forms/report_error.php]
[Get Vars]
    name = [transaction.views.transaction]
    form_name = [view]
    id = [10866]
    tab = [payments]
[Post Vars]

[Server Vars]
    SCRIPT_URL = [/]
    SCRIPT_URI = [https://east6.merchantos.com/]
    HTTPS = [on]
    SSL_TLS_SNI = [east6.merchantos.com]
    SSL_SERVER_S_DN_OU = [Domain Control Validated]
    SSL_SERVER_S_DN_CN = [*.merchantos.com]
    SSL_SERVER_I_DN_C = [US]
    SSL_SERVER_I_DN_ST = [Arizona]
    SSL_SERVER_I_DN_L = [Scottsdale]
    SSL_SERVER_I_DN_O = [GoDaddy.com, Inc.]
    SSL_SERVER_I_DN_OU = [http://certs.godaddy.com/repository/]
    SSL_SERVER_I_DN_CN = [Go Daddy Secure Certificate Authority - G2]
    SSL_VERSION_INTERFACE = [mod_ssl/2.2.15]
    SSL_VERSION_LIBRARY = [OpenSSL/1.0.1e-fips]
    SSL_PROTOCOL = [TLSv1.2]
    SSL_SECURE_RENEG = [true]
    SSL_COMPRESS_METHOD = [NULL]
    SSL_CIPHER = [DHE-RSA-AES128-GCM-SHA256]
    SSL_CIPHER_EXPORT = [false]
    SSL_CIPHER_USEKEYSIZE = [128]
    SSL_CIPHER_ALGKEYSIZE = [128]
    SSL_CLIENT_VERIFY = [NONE]
    SSL_SERVER_M_VERSION = [3]
    SSL_SERVER_M_SERIAL = [74ED04941899]
    SSL_SERVER_V_START = [Apr 10 04:09:03 2014 GMT]
    SSL_SERVER_V_END = [Apr  1 02:18:02 2019 GMT]
    SSL_SERVER_S_DN = [/OU=Domain Control Validated/CN=*.merchantos.com]
    SSL_SERVER_I_DN = [/C=US/ST=Arizona/L=Scottsdale/O=GoDaddy.com, Inc./OU=http://certs.godaddy.com/repository//CN=Go Daddy Secure Certificate Authority - G2]
    SSL_SERVER_A_KEY = [rsaEncryption]
    SSL_SERVER_A_SIG = [sha256WithRSAEncryption]
    SSL_SESSION_ID = [E71A96E7FE4953185CAD004DBB82E94123D484F4C23DE46142EB668EF12A7C67]
    HTTP_HOST = [east6.merchantos.com]
    HTTP_CONNECTION = [keep-alive]
    HTTP_ACCEPT = [text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8]
    HTTP_USER_AGENT = [Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/36.0.1985.125 Safari/537.36]
    HTTP_ACCEPT_ENCODING = [gzip,deflate,sdch]
    HTTP_ACCEPT_LANGUAGE = [en-US,en;q=0.8]
    HTTP_COOKIE = [PHPSESSID=7f0agmm4njef6a7otq40kuq8i3; _mkto_trk=id:470-XOQ-769&token:_mch-merchantos.com-1405902152882-33219]
    PATH = [/sbin:/usr/sbin:/bin:/usr/bin]
    SERVER_SIGNATURE = [
Apache/2.2.15 (CentOS) Server at east6.merchantos.com Port 443

]
    SERVER_SOFTWARE = [Apache/2.2.15 (CentOS)]
    SERVER_NAME = [east6.merchantos.com]
    SERVER_ADDR = [192.168.12.108]
    SERVER_PORT = [443]
    REMOTE_ADDR = [101.187.16.53]
    DOCUMENT_ROOT = [/web/cloud/www]
    SERVER_ADMIN = [admin@merchantos.com]
    SCRIPT_FILENAME = [/web/cloud/www/index.php]
    REMOTE_PORT = [51844]
    GATEWAY_INTERFACE = [CGI/1.1]
    SERVER_PROTOCOL = [HTTP/1.1]
    REQUEST_METHOD = [GET]
    QUERY_STRING = [name=transaction.views.transaction&form_name=view&id=10866&tab=payments]
    REQUEST_URI = [/?name=transaction.views.transaction&form_name=view&id=10866&tab=payments]
    SCRIPT_NAME = [/index.php]
    PHP_SELF = [/index.php]
    REQUEST_TIME_FLOAT = [1406002599.206]
    REQUEST_TIME = [1406002599]


