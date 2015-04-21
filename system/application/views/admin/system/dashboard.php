<script type="text/javascript" src="<?=base_url()?>js/popup.js"></script>
<link href="<?=base_url()?>css/popup.css" rel="stylesheet" type="text/css" />
<script>
$j(document).ready(function(){
	$j("#background-popup").click(function(){ disablePopup(); });
	$j(document).keypress(function(e){ if(e.keyCode==27 && popupStatus==1){ disablePopup(); } });
});
function mostsearch() {
	$j.ajax({
		url: '<?=base_url()?>admin/store/mostpopular/',
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
		}
	})	
}
function bestproduct() {
	$j.ajax({
		url: '<?=base_url()?>admin/store/bestproduct/',
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
		}
	})	
}
function worstproduct() {
	$j.ajax({
		url: '<?=base_url()?>admin/store/worstproduct/',
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
		}
	})	
}
function bestcategory() {
	$j.ajax({
		url: '<?=base_url()?>admin/store/bestcategory/',
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
		}
	})	
}
function bestcustomer() {
	$j.ajax({
		url: '<?=base_url()?>admin/store/bestcustomer/',
		success: function(html) {
			$j('#popup-content').html(html);
			centerPopup();
			loadPopup();
		}
	})	
}
function export_csv() {
	if (confirm('This will export the order list to a csv file. Do you want to continue?')) {
		window.location = '<?=base_url()?>admin/store/exportstock/';
	}
}
</script>
    	<div class="left">
        	<h1>Store Management</h1>
            <div class="bar">

            	<div class="text">Dashboard</div>
            	<div class="cr"></div>
            </div>
            <div class="box">
            	<div class="box-1 rounded">
                	<h3>Recent Sales</h3>
                    <div class="row-title">
                    	<div class="customer-name">Customer name</div>
                        <div class="cat-func">View</div>
                        <div class="total">Total</div>
                    </div>
                    
                </div>
                <div class="box-2 rounded">
                	<h3>Sales Stats</h3>
                    <p class="desc">Click word for quick search</p>
                    <a href="<?=base_url()?>admin/store/order/search/total"><dl><dt>Sales total</dt><dd></dd></dl></a>
                    <a href="<?=base_url()?>admin/store/order/search/month"><dl><dt><?=date('F')?> sales</dt><dd></dd></dl></a>
                    <a href="<?=base_url()?>admin/store/order/search/week"><dl><dt>Week sales</dt><dd></dd></dl></a>
                    <a href="<?=base_url()?>admin/store/order/search/day"><dl><dt>Today sales</dt><dd></dd></dl></a>                  
                </div>
                <div class="box-1 rounded">
                	<h3>Quick Facts</h3>
                    <a href="javascript:bestproduct()"><dl><dt>Best product</dt><dd></dd></dl></a>
                    <a href="javascript:worstproduct()"><dl><dt>Worst product</dt><dd></dd></dl></a>
                    <a href="javascript:bestcategory()"><dl><dt>Best category</dt><dd></dd></dl></a>
                    <a href="javascript:bestcustomer()"><dl><dt>Best customer</dt><dd></dd></dl></a>
                    <a href="javascript:mostsearch()"><dl><dt>Most popular search</dt><dd></dd></dl></a>
                </div>
                <div class="box-2 rounded">
                	<h3>Quick Facts</h3>
                    <dl><dt>Main Categories</dt><dd></dd></dl>
                    <dl><dt>Sub Categories</dt><dd></dd></dl>
                    <dl><dt>Total products</dt><dd></dd></dl>
                    <dl><dt>Active products</dt><dd></dd></dl>
                    <dl><dt>Customers</dt><dd></dd></dl>
                </div>
                <dl></dl>
            	<table width="100%">
                <tr><td>
                <p>This is the dashboard of store management system (<b>SimplyShopping V2.01</b>).</p>
                <p>Please <a href="mailto:team@propagate.com.au">contact us</a> for support and to hear about other web products we have</p>
                </td>
                <td valign="top" align="right"><!--<a onclick="export_csv();" style="cursor:pointer;">Export Stock</a>--></td>
                </table>
            </div>
        </div>
        

<div id="popup-box">
	<div id="popup-content">
    	
    </div>
</div>
<div id="background-popup"></div>