<script src="<?=base_url()?>js/highcart/highcharts.js"></script>
<script src="<?=base_url()?>js/highcart/modules/exporting.js"></script>
<div class="span9">
	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">
		<div style="padding: 20px">
			<!-- start here -->
			<?php
			//echo "<pre>".print_r($listdate_month,true)."</pre>";
			
			?>
			<div style="float: left">
				<h1>Sales Reports</h1>
			</div>
			<div style="float: right; font-size: 24px; font-weight: 700; height: 30px; line-height: 30px; margin-top: 12px">
				Total Income : $<?=number_format($sales_all,2,'.',',')?>
			</div>
			<div style="clear: both"></div>
			<a href="<?=base_url()?>/admin/order/update_order_detail2">Update Data</a>
			<div style="height: 20px"></div>
			<div class="row-fluid" style="border: 4px solid #ccc; border-radius: 10px">
				<div class="span1">&nbsp;</div>
				<div class="span3">
					<div style="height: 10px"></div>
					<div>
						<span style="font-size: 24px; font-weight: 700; height: 30px; line-height: 30px">$<?=number_format($order_detail['today_income'],2,'.',',')?></span> 
						<a href="<?=base_url()?>admin/order/show_stat/today">Today</a>
					</div>
					<div style="height: 20px; line-height: 20px">Prev. $ <?=number_format($order_detail['yesterday_income'],2,'.',',')?></div>
					<div style="height: 10px"></div>
				</div>
				<div class="span1">
					<div style="height: 10px"></div>
					<div style="border-left: 1px solid #ccc; height: 50px;">&nbsp;</div>
					<div style="height: 10px"></div>
				</div>
				<div class="span3">
					<div style="height: 10px"></div>
					<div>
						<span style="font-size: 24px; font-weight: 700; height: 30px; line-height: 30px">$<?=number_format($order_detail['this_month_income'],2,'.',',')?></span> 
						<a href="<?=base_url()?>admin/order/show_stat/month">Month</a>
					</div>
					<div style="height: 20px; line-height: 20px">Prev. $ <?=number_format($order_detail['last_month_income'],2,'.',',')?></div>
					<div style="height: 10px"></div>
				</div>
				<div class="span1">
					<div style="height: 10px"></div>
					<div style="border-left: 1px solid #ccc; height: 50px;">&nbsp;</div>
					<div style="height: 10px"></div>
				</div>
				<div class="span3">
					<div style="height: 10px"></div>
					<div>
						<span style="font-size: 24px; font-weight: 700; height: 30px; line-height: 30px">$<?=number_format($order_detail['this_year_income'],2,'.',',')?></span> 
						<a href="<?=base_url()?>admin/order/show_stat/year">Year</a>
					</div>
					<div style="height: 20px; line-height: 20px">Prev. $ <?=number_format($order_detail['last_year_income'],2,'.',',')?></div>
					<div style="height: 10px"></div>
				</div>
			</div>
			<div style="height: 20px;"></div>
			<div class="row-fluid">
				<div class="span12">
					<?php
						if($this->session->userdata('stat_type'))
						{
							$type = $this->session->userdata('stat_type');
							if($type == 'month')
							{
							?>
								<div id="container_month" style="height: 400px; margin: 0 auto; "></div>
								<div>
									<form method="post" action="<?=base_url()?>admin/order/statistic">
										<input type="hidden" name="m_f" value="1"/>
										<h2>Filter</h2>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">State</div>
										<div style="float: left">
											<select name="mstate_f">
												<option value="-1">All States</option>
												<?php
												foreach($states as $state)
												{
												?>
													<option value="<?=$state['id']?>"><?=$state['name']?></option>
												<?
												}
												?>
											</select>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">Month</div>
										<div style="float: left">
											<?php
												$m = date('m');
											?>
											<select name="mmonth_f">
												<option <?php if($m == '01') {echo "selected = 'selected'";}?> value="01">January</option>
												<option <?php if($m == '02') {echo "selected = 'selected'";}?> value="02">February</option>
												<option <?php if($m == '03') {echo "selected = 'selected'";}?> value="03">March</option>
												<option <?php if($m == '04') {echo "selected = 'selected'";}?> value="04">April</option>
												<option <?php if($m == '05') {echo "selected = 'selected'";}?> value="05">May</option>
												<option <?php if($m == '06') {echo "selected = 'selected'";}?> value="06">June</option>
												<option <?php if($m == '07') {echo "selected = 'selected'";}?> value="07">July</option>
												<option <?php if($m == '08') {echo "selected = 'selected'";}?> value="08">August</option>
												<option <?php if($m == '09') {echo "selected = 'selected'";}?> value="09">September</option>
												<option <?php if($m == '10') {echo "selected = 'selected'";}?> value="10">October</option>
												<option <?php if($m == '11') {echo "selected = 'selected'";}?> value="11">November</option>
												<option <?php if($m == '12') {echo "selected = 'selected'";}?> value="12">December</option>
											</select>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">Year</div>
										<div style="float: left">
											
											<select name="myear_f">
												<?php
													$y = date('Y');
													for($i = $y-5; $i<=$y+5; $i++)
													{
														?>
														<option <?php if($y == $i) {echo "selected = 'selected'";}?> value="<?=$i?>"><?=$i?></option>
														<?
													}
												?>
												
											</select>
										</div>
										<div style="clear: both"></div>
										<div>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
							<?
							}
							if($type == 'year')
							{
							?>
								<div id="container_year" style="height: 400px; margin: 0 auto; "></div>
								<div>
									<form method="post" action="<?=base_url()?>admin/order/statistic">
										<input type="hidden" name="y_f" value="1"/>
										<h2>Filter</h2>
										
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">Year</div>
										<div style="float: left">
											
											<select name="yyear_f">
												<?php
													$y = date('Y');
													for($i = $y-5; $i<=$y+5; $i++)
													{
														?>
														<option <?php if($y == $i) {echo "selected = 'selected'";}?> value="<?=$i?>"><?=$i?></option>
														<?
													}
												?>
												
											</select>
										</div>
										<div style="clear: both"></div>
										<div>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
							<?
							}
							if($type == 'today')
							{
							?>
								<div id="container_today" style="height: 400px; margin: 0 auto;">
									<div style="font-size: 16px; font-weight: 400; text-align: center;">Today's Income</div>
									<table class="table table-hover">
										<thead>
											<tr>
												<th style="width: 20%">ID</th>
												<th style="width: 50%">Customer Name</th>
												<th style="width: 30%">Total Order</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($list_order_today as $list)
											{
												$cust = $this->Customer_model->identify($list['customer_id']);
												$user = $this->User_model->identify_cust_id($list['customer_id']);
												?>
												<tr>
													<td><a href="<?=base_url()?>admin/order/list_all/view/<?=$list['id']?>"><?=$list['id']?></a></td>
													<td><a href="<?=base_url()?>admin/customer/list_all/edit/<?=$user['id']?>"><?=$cust['firstname']?> <?=$cust['lastname']?></a></td>
													<td>$ <?=number_format($list['total'],2,'.',',')?></td>
												</tr>
												<?
											}
											?>
										</tbody>
									</table>
								</div>
							<?
							}
							if($type == 'customer')
							{
							?>
								<div id="container_today" style="height: 400px; margin: 0 auto;">
									<div style="font-size: 16px; font-weight: 400; text-align: center;">Best Customers<?=$h_cust?></div>
									<table class="table table-hover">
								    	<thead>
								    		<tr>
								    			<th style="width: 10%">Id</th>
								    			<th style="width: 60%">Customer Name</th>
								    			<th style="width: 30%">Total Spend</th>
								    		</tr>
								    	</thead>
								    	<tbody>
								    		<?php
								    		foreach($best_customers as $bc)
											{
												$cust = $this->Customer_model->identify($bc['customer_id']);
												?>
												<tr>
													<td><?=$bc['customer_id']?></td>
													<td><?=$cust['firstname']?> <?=$cust['lastname']?></td>
													<td>$<?=number_format($bc['total'],2,'.',',')?></td>
												</tr>
												<?
											}
								    		?>
								    	</tbody>
								    </table>
								</div>
								<div>
									<form method="post" action="<?=base_url()?>admin/order/statistic">
										<input type="hidden" name="filter_cust" value="1">
										<h2>Filter</h2>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">From Date</div>
										<div style="float: left">
											<div id="datetimepicker3" class="input-append">
											    <input data-format="dd-MM-yyyy" type="text" name="from_date_cust" required></input>
											    <span style="cursor: pointer" class="add-on">
											      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
											      </i>
											    </span>
											  </div>
											<script type="text/javascript">
											  $(function() {
											    $('#datetimepicker3').datetimepicker({
											      pickTime: false
											    });
											  });
											</script>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">To Date</div>
										<div style="float: left">
											<div id="datetimepicker31" class="input-append">
											    <input data-format="dd-MM-yyyy" type="text" name="to_date_cust" required></input>
											    <span style="cursor: pointer" class="add-on">
											      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
											      </i>
											    </span>
											  </div>
											<script type="text/javascript">
											  $(function() {
											    $('#datetimepicker31').datetimepicker({
											      pickTime: false
											    });
											  });
											</script>
										</div>
										<div style="clear: both"></div>
										<div>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
							<?
							}
							if($type == 'cat')
							{
							?>
								<div id="container_month_category" style="height: 400px; margin: 0 auto;"></div>
								<div>
									<form method="post" action="<?=base_url()?>admin/order/statistic">
										<input type="hidden" name="filter_bcat" value="1">
										<h2>Filter</h2>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">From Date</div>
										<div style="float: left">
											<div id="datetimepicker1" class="input-append">
											    <input data-format="dd-MM-yyyy" type="text" name="from_date_bcat" required></input>
											    <span style="cursor: pointer" class="add-on">
											      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
											      </i>
											    </span>
											  </div>
											<script type="text/javascript">
											  $(function() {
											    $('#datetimepicker1').datetimepicker({
											      pickTime: false
											    });
											  });
											</script>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">To Date</div>
										<div style="float: left">
											<div id="datetimepicker11" class="input-append">
											    <input data-format="dd-MM-yyyy" type="text" name="to_date_bcat" required></input>
											    <span style="cursor: pointer" class="add-on">
											      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
											      </i>
											    </span>
											  </div>
											<script type="text/javascript">
											  $(function() {
											    $('#datetimepicker11').datetimepicker({
											      pickTime: false
											    });
											  });
											</script>
										</div>
										<div style="clear: both"></div>
										<div>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
							<?
							}
							if($type == 'prod')
							{
							?>
								<div id="container_best_prod" style="height: 400px; margin: 0 auto;"></div>
								<div>
									<form method="post" action="<?=base_url()?>admin/order/statistic">
										<input type="hidden" name="filter_prod" value="1">
										<h2>Filter</h2>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">From Date</div>
										<div style="float: left">
											<div id="datetimepicker2" class="input-append">
											    <input data-format="dd-MM-yyyy" type="text" name="from_date_prod" required></input>
											    <span style="cursor: pointer" class="add-on">
											      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
											      </i>
											    </span>
											  </div>
											<script type="text/javascript">
											  $(function() {
											    $('#datetimepicker2').datetimepicker({
											      pickTime: false
											    });
											  });
											</script>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">To Date</div>
										<div style="float: left">
											<div id="datetimepicker21" class="input-append">
											    <input data-format="dd-MM-yyyy" type="text" name="to_date_prod" required></input>
											    <span style="cursor: pointer" class="add-on">
											      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
											      </i>
											    </span>
											  </div>
											<script type="text/javascript">
											  $(function() {
											    $('#datetimepicker21').datetimepicker({
											      pickTime: false
											    });
											  });
											</script>
										</div>
										<div style="clear: both"></div>
										<div>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
							<?
							}
							if($type == 'lmonth')
							{
							?>
								<div id="container_best_prod_lmonth" style="height: 400px; margin: 0 auto;"></div>
							<?
							}
							
						}
						else 
						{
						?>
							<div id="container_month" style="height: 400px; margin: 0 auto; "></div>
								<div>
									<form method="post" action="<?=base_url()?>admin/order/statistic">
										<input type="hidden" name="m_f" value="1"/>
										<h2>Filter</h2>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">State</div>
										<div style="float: left">
											<select name="mstate_f">
												<option value="-1">All States</option>
												<?php
												foreach($states as $state)
												{
												?>
													<option value="<?=$state['id']?>"><?=$state['name']?></option>
												<?
												}
												?>
											</select>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">Month</div>
										<div style="float: left">
											<?php
												$m = date('m');
											?>
											<select name="mmonth_f">
												<option <?php if($m == '01') {echo "selected = 'selected'";}?> value="01">January</option>
												<option <?php if($m == '02') {echo "selected = 'selected'";}?> value="02">February</option>
												<option <?php if($m == '03') {echo "selected = 'selected'";}?> value="03">March</option>
												<option <?php if($m == '04') {echo "selected = 'selected'";}?> value="04">April</option>
												<option <?php if($m == '05') {echo "selected = 'selected'";}?> value="05">May</option>
												<option <?php if($m == '06') {echo "selected = 'selected'";}?> value="06">June</option>
												<option <?php if($m == '07') {echo "selected = 'selected'";}?> value="07">July</option>
												<option <?php if($m == '08') {echo "selected = 'selected'";}?> value="08">August</option>
												<option <?php if($m == '09') {echo "selected = 'selected'";}?> value="09">September</option>
												<option <?php if($m == '10') {echo "selected = 'selected'";}?> value="10">October</option>
												<option <?php if($m == '11') {echo "selected = 'selected'";}?> value="11">November</option>
												<option <?php if($m == '12') {echo "selected = 'selected'";}?> value="12">December</option>
											</select>
										</div>
										<div style="clear: both"></div>
										<div style="float: left; width: 100px; height: 30px; line-height: 30px">Year</div>
										<div style="float: left">
											
											<select name="myear_f">
												<?php
													$y = date('Y');
													for($i = $y-5; $i<=$y+5; $i++)
													{
														?>
														<option <?php if($y == $i) {echo "selected = 'selected'";}?> value="<?=$i?>"><?=$i?></option>
														<?
													}
												?>
												
											</select>
										</div>
										<div style="clear: both"></div>
										<div>
											<button type="submit" class="btn btn-primary">Update</button>
										</div>
									</form>
								</div>
						<?
						}
					?>
					
					
					
					
				</div>
			</div>
			<!-- <h2>Sales Stats</h2>
			<div class="well">
				<div style="width: 20%; float: left; font-weight: 700">
					Sales Total
				</div>
				<div style="width: 80%; float: left;">
					$<?=$this->Order_model->sales_total()?>
				</div>
				<div style="clear: both; height: 15px"></div>
				<div style="width: 20%; float: left; font-weight: 700">
					<?=date('F')?> sales
				</div>
				<div style="width: 80%; float: left;">
					$<?=$this->Order_model->sales_month(date('Y-m'))?>
				</div>
				<div style="clear: both; height: 15px"></div>
				<div style="width: 20%; float: left; font-weight: 700">
					Weekly Sales
				</div>
				<div style="width: 80%; float: left;">
					$<?=$this->Order_model->sales_week()?>
				</div>
				<div style="clear: both; height: 15px"></div>
				<div style="width: 20%; float: left; font-weight: 700">
					Today Sales
				</div>
				<div style="width: 80%; float: left;">
					$<?=$this->Order_model->sales_date(date('Y-m-d'))?>
				</div>
				<div style="clear: both"></div>
			</div> -->
			<div style="height: 40px;"></div>
			<h2>Quick Facts</h2>
			<div class="well">
				<div style="width: 20%; float: left; font-weight: 700">
					Best Products
				</div>
				<div style="width: 80%; float: left;">
					<!-- <div style="cursor: pointer;" onclick="$('#categoryModal').modal('show');">show chart</div> -->
					<a href="<?=base_url()?>admin/order/show_stat/prod"><?=$order_detail['best_product']?></a>
				</div>
				<div style="clear: both; height: 15px"></div>
				<div style="width: 20%; float: left; font-weight: 700">
					Best Categories
				</div>
				<div style="width: 80%; float: left; cursor: pointer">
					<!-- <div style="cursor: pointer;" onclick="$('#categoryModal').modal('show');">show chart</div> -->
					<a href="<?=base_url()?>admin/order/show_stat/cat"><?=$order_detail['best_category']?></a>
				</div>
				<div style="clear: both; height: 15px"></div>
				<div style="width: 20%; float: left; font-weight: 700">
					Best Customers
				</div>
				<div style="width: 80%; float: left; cursor: pointer">
					<!-- <div style="cursor: pointer;" onclick="$('#categoryModal').modal('show');">show chart</div> -->
					<a href="<?=base_url()?>admin/order/show_stat/customer"><?=$order_detail['best_customer']?></a>
				</div>
				<div style="clear: both; height: 15px"></div>
				<div style="width: 20%; float: left; font-weight: 700">
					What's Selling
				</div>
				<div style="width: 80%; float: left; cursor: pointer">
					<a href="<?=base_url()?>admin/order/show_stat/lmonth">View</a>
				</div>
				<div style="clear: both; height: 15px"></div>
			</div>
			
			
			



			<!-- end here -->
			
			
			
		</div>
	</div>
</div>

<div id="categoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

<h3 id="myModalLabel">Best Categories</h3>

</div>

<div class="modal-body">
	<!-- <?php echo "<pre>".print_r($listincome_arr,true)."</pre>";?> -->
    <!-- <div id="container_month_category" style="min-width: 530px; height: 400px; margin: 0 auto"></div> -->

</div>

<div class="modal-footer">

<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>



</div>

</div>



<div id="bestcustModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

<h3 id="myModalLabel">Best Customers</h3>

</div>

<div class="modal-body">
	
    

</div>

<div class="modal-footer">

<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>



</div>

</div>

<script type="text/javascript">
<?php

if(!$this->session->userdata('stat_type'))
{
	$type = 'month';
}

?>


<?php
if($type == 'month'){
?>
$(function () {
        $('#container_month').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: "<?=$mfilter_header?><?=$mstate_f?>",
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: <?=$listdate_month?>
            },
            yAxis: {
                title: {
                    text: 'Sales ($)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valuePrefix: '$'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Income This Month',
                data: <?=$listincome_month?>
            }]
        });
        
        
    });
<?php }?>
  
<?php
if($type == 'cat'){
?>
$(function () {
        $('#container_month_category').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
            },
            title: {
                text: 'Best Categories<?=$h_bcat?>',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: <?=$listdate_month_bcat?>
            },
            yAxis: {
                title: {
                    text: 'Sales ($)'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                valuePrefix: '$'
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [
            <?php
            $cc = 0;
            foreach($listincome_arr as $la)
			{
				if($cc == 0)
				{
				?>
				{
					name: '<?=$la['cat_title']?>',
	                data: <?=$la['income']?>
				},
				<?	
				}
				else 
				{
				?>
				
				 {
					name: '<?=$la['cat_title']?>',
	                data: <?=$la['income']?>
				},
				<?
				}
			}
			$cc++;
            ?>
            
            
            ]
        });
        
        
    });
<?php }?>

<?php
if($type == 'prod'){
?>
$(function () {
        $('#container_best_prod').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: '<?=$ttl_prod?> Best Products <?=$h_prod?>'
            },
            subtitle: {
                
            },
            xAxis: {
                categories: [
                    <?=$prod_list?>
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total Purchased'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Total Purchased',
                data: [<?=$prod_count?>]
    
            }]
        });
    });
<?php }?>

<?php
if($type == 'year'){
?>
    $(function () {
        $('#container_year').highcharts({
            chart: {
                zoomType: 'x',
                spacingRight: 20
            },
            title: {
                text: "<?=$header_year_f?>"
            },
            subtitle: {
                text: document.ontouchstart === undefined ?
                    'Click and drag in the plot area to zoom in' :
                    'Drag your finger over the plot to zoom in'
            },
            xAxis: {
                type: 'datetime',
                maxZoom: 14 * 24 * 3600000, // fourteen days
                title: {
                    text: null
                }
            },
            yAxis: {
                title: {
                    text: 'Income in AU$'
                }
            },
            tooltip: {
                shared: true
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                area: {
                    fillColor: {
                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    lineWidth: 1,
                    marker: {
                        enabled: false
                    },
                    shadow: false,
                    states: {
                        hover: {
                            lineWidth: 1
                        }
                    },
                    threshold: null
                }
            },
    
            series: [{
                type: 'area',
                name: 'Income',
                pointInterval: 24 * 3600 * 1000,
                pointStart: Date.UTC(<?=$yyear_f?>, 0, 1),
                data: [
                   <?=$all_income?>
                ]
            }]
        });
    });
<?php }?>  


<?php
if($type == 'lmonth'){
?>
    $(function () {
        $('#container_best_prod_lmonth').highcharts({
            chart: {
                type: 'spline'
            },
            title: {
                text: "What's Selling"
            },
            subtitle: {
                
            },
            xAxis: {
                categories: [<?=$list_date_lmonth?>]
            },
            yAxis: {
                title: {
                    text: 'Sold'
                },
                labels: {
                    formatter: function() {
                        return '$'+this.value
                    }
                }
            },
            tooltip: {
                crosshairs: true,
                shared: true
            },
            plotOptions: {
                spline: {
                    marker: {
                        radius: 4,
                        lineColor: '#666666',
                        lineWidth: 1
                    }
                }
            },
            series: [
            
            <?php
            $cc = 0;
            foreach($list_lmonth_income_arr as $la)
			{
				if($cc<20)
				{
					if($cc == 0)
					{
					?>
					{
						name: '<?=$la['prod_title']?>',
		                data: <?=$la['income']?>
					},
					<?	
					}
					else 
					{
					?>
					
					 {
						name: '<?=$la['prod_title']?>',
		                data: <?=$la['income']?>
					},
					<?
					}
				}
				$cc++;
			}
			
            ?>
            
            ]
        });
    });
<?php }?>  

		</script>




