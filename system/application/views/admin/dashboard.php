<style>
.dashboard_income
{
	font-size: 24px;
}
@media (min-width: 1200px)
{
	.dashboard_income
	{
		font-size: 24px;
	}
}
@media (max-width: 1200px)
{
	.dashboard_income
	{
		font-size: 21px;
	}
}
@media (max-width: 979px)
{
	.dashboard_income
	{
		font-size: 16px;
	}
	.dashboard_income1
	{
		font-size: 10px;
	}
}
</style>

<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

			<?php

			if($this->session->flashdata('no_result_search'))

			{

				echo $this->session->flashdata('no_result_search');

			}

			?>

			

			<!-- <a href="<?=base_url()?>/admin/order/update_order_detail2">Update Data</a> -->

			<div class="row-fluid" style="border: 4px solid #ccc; border-radius: 10px">

				<div class="span1">&nbsp;</div>

				<div class="span3">

					<div style="height: 10px"></div>

					<div>

						<span class="dashboard_income" style="font-weight: 700; height: 30px; line-height: 30px">$<?=number_format($order_detail['today_income'],2,'.',',')?></span> 

						<a class="dashboard_income1 pri_link" href="<?=base_url()?>admin/order/show_stat/today" >Today</a>

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

						<span class="dashboard_income" style="font-weight: 700; height: 30px; line-height: 30px">$<?=number_format($order_detail['this_month_income'],2,'.',',')?></span> 

						<a class="dashboard_income1 pri_link" href="<?=base_url()?>admin/order/show_stat/month" >Month</a>

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

						<span class="dashboard_income" style="font-weight: 700; height: 30px; line-height: 30px">$<?=number_format($order_detail['this_year_income'],2,'.',',')?></span> 

						<a class="dashboard_income1 pri_link" href="<?=base_url()?>admin/order/show_stat/year" >Year</a>

					</div>

					<div style="height: 20px; line-height: 20px">Prev. $ <?=number_format($order_detail['last_year_income'],2,'.',',')?></div>

					<div style="height: 10px"></div>

				</div>

			</div>

			<div style="height: 15px;"></div>

			<div class="row-fluid" style="border: 4px solid #ccc; border-radius: 10px">

				

				<div class="span6" style="padding-left: 10px; padding-right: 10px">

					<div style="height: 10px;"></div>

					<div style="color: #333333; font-size: 18px !important; font-weight: 700; margin-left: 7px">Latest Orders <a href="<?=base_url()?>admin/order/list_all" class="pri_link" style="font-weight: 400; font-size: 14px !important">List All</a></div>

					<div style="height: 10px;"></div>

					<table class="table table-hover">

						<thead>

							<tr>

								<th style="width: 22%">Date</th>

								<th style="width: 43%">Name</th>

								<th style="width: 30%">Total</th>

								<th style="width: 5%">&nbsp;</th>

							</tr>

						</thead>

						<tbody>

							<?php

								foreach($last5 as $l5)

								{

									$c = $this->Customer_model->identify($l5['customer_id']);

								?>

									<tr>

										<td><?=date('d/m/Y',strtotime($l5['order_time']))?></td>
										<?php
										$name = $c['firstname'].' '.$c['lastname'];
										if(strlen($name) >10)
										{
											$name = substr($name, 0,10).'...';
										}	
										?>
										<td><?=$name?></td>

										<td>$ <?=number_format($l5['total'],2,'.',',')?></td>

										<td>

											<a href="<?=base_url()?>admin/order/list_all/view/<?=$l5['id']?>">

												<i class="icon icon-search"></i>

											</a>

										</td>

									</tr>

								<?

								}

							?>

							<tr>

							</tr>

						</tbody>

					</table>

				</div>

				

				<div class="span6" style="padding-left: 10px; padding-right: 10px">

					<div style="height: 10px;"></div>

					<div style="color: #333333; font-size: 18px !important; font-weight: 700; margin-left: 7px">Latest Customers <a href="<?=base_url()?>admin/customer/list_all" class="pri_link" style="font-weight: 400;  font-size: 14px !important">List All</a></div>

					<div style="height: 10px;"></div>

					<table class="table table-hover">

						<thead>

							<tr>

								<th style="width: 10%">ID</th>

								<th style="width: 57%">Name</th>

								<th style="width: 33%">Type</th>

								<th style="width: 5%">&nbsp;</th>

							</tr>

						</thead>

						<tbody>

							<?php

								foreach($last5_c as $l5_c)

								{

									//$c = $this->Customer_model->identify($l5_c['customer_id']);

									//$u = $this->User_model->identify_cust_id($l5_c['id']);

									if($l5_c['level'] == 1)

									{

										$type = 'Retail';

									}

									else if($l5_c['level'] == 2)

									{

										$type = 'Trade';

									}

									else

									{

										$type = 'Admin';

									}

								?>

									<tr>

										<td><?=$l5_c['id']?></td>

										<td><?=$l5_c['firstname']?> <?=$l5_c['lastname']?></td>

										<td>

											<?=$type?>

										</td>

										<td>

											<a href="<?=base_url()?>admin/customer/list_all/edit/<?=$l5_c['u_id']?>">

												<i class="icon icon-search"></i>

											</a>

										</td>

									</tr>

								<?

								}

							?>

							<tr>

							</tr>

						</tbody>

					</table>

				</div>

				

			</div>

			



			

			<div style="height: 15px;"></div>

			<div class="row-fluid" style="border: 4px solid #ccc; border-radius: 10px">

				<div class="span12" style="height: 15px">

				</div>

				

				<div class="span12" style="line-height: 24px; margin: 0">

					<div class="row-fluid">

						<div class="span1" style="padding-left: 15px"><img  alt="" src="<?=base_url()?>img/dashboard_cat.png"/></div>

						<div class="span5">

							<div>

								<div style="font-size: 18px; font-weight: 700">Category Inventory</div>

								<div style="height: 5px;"></div>

								<table style="table" style="font-size: 14px">

									<tr>

										<td style="font-weight: 700; width: 93%">Total Categories:</td>

										<td><a class="pri_link" href="<?=base_url()?>admin/cms/category"><?=$c_cat?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 93%">Product Categories:</td>

										<td><a class="pri_link" href="<?=base_url()?>admin/cms/category"><?=$all_cat_prod?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 93%">Page Categories:</td>

										<td><a class="pri_link" href="<?=base_url()?>admin/cms/category"><?=$all_cat_page?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 93%">Galleries:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/galleries"><?=$all_galleries?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 93%">Banners:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/banner"><?=$all_banners?></a></td>

									</tr>

								</table>

							</div>

						</div>

						<div class="span1" >

							<div style="border-left: 1px solid #ccc; height: 160px; padding-left: 15px"><img  alt="" src="<?=base_url()?>img/dashboard_product.png"/></div>

						</div>

						<div class="span5">

							<div>

								<div style="font-size: 18px; font-weight: 700">Product Inventory</div>

								<div style="height: 5px;"></div>

								<table style="table" style="font-size: 14px">

									<tr>

										<td style="font-weight: 700; width: 90%">Total Products:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/product"><?=$all_prod?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 90%">In Stock:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/product/in_stock"><?=$all_prod_in_stock?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 90%">Out Of Stock:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/product/out_of_stock"><?=$all_prod_out_of_stock?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 90%">Inactive:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/product/inactive"><?=$all_prod_disable?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 90%">On Sale:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/cms/product/on_sale"><?=$all_prod_config?></a></td>

									</tr>

								</table>

							</div>

						</div>

					</div>

				</div>



				<!-- <div class="span12" style="line-height: 24px; margin: 0;">

					<div class="row-fluid">

						<div class="span6" style="border-top: 1px solid #ccc; margin-left: 15px">

						</div>

						<div class="span6" style="border-top: 1px solid #ccc; margin-left: 15px">

						</div>

					</div>

				</div> -->

				

				<div class="span12" style="height: 40px">

				</div>

				

				<div class="span12" style="line-height: 24px; margin: 0">

					<div class="row-fluid">

						<div class="span1" style="padding-left: 15px">

							<img  alt="" src="<?=base_url()?>img/dashboard_cust.png"/>

						</div>

						<div class="span5">

							<div>

								<div style="font-size: 18px; font-weight: 700">Your Customers</div>

								<div style="height: 5px;"></div>

								<table style="table" style="font-size: 14px">

									<tr>

										<td style="font-weight: 700; width: 96%">Australian Retail:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/customer/list_all_retail"><?=$all_retail_aus?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700;">International Retail:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/customer/list_all_retail"><?=$all_retail_int?></a></td>

									</tr>
									<!--
									<tr>

										<td style="font-weight: 700;">Trade Customers:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/customer/list_all_trade"><?=$all_trade?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 93%">News Subscribers:</td>

										<td style="color: #e6006e"><a style="color: #e6006e" href="<?=base_url()?>admin/customer/list_all_subcribe"><?=$all_subscribe?></a></td>

									</tr> -->

								</table>

							</div>

						</div>

						<div class="span1" >

							<div style="border-left: 1px solid #ccc; height: 107px; padding-left: 15px"><img  alt="" src="<?=base_url()?>img/dashboard_stats.png"/></div>

						</div>

						<div class="span5">

							<div>

								<div style="font-size: 18px; font-weight: 700">Quick Stats - This Month</div>

								<div style="height: 5px;"></div>

								<table style="table" style="font-size: 14px">

									<tr>

										<td style="font-weight: 700; width: 96%">Australian Retail Sign Ups:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/customer/list_all_retail"><?=$all_new_retail_aus?></a></td>

									</tr>

									<tr>

										<td style="font-weight: 700; width: 96%">International Retail Sign Ups:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/customer/list_all_retail"><?=$all_new_retail_int?></a></td>

									</tr>
									<!--
									<tr>

										<td style="font-weight: 700; width: 96%">Trade Customer Sign Ups:</td>

										<td class="pri_link"><a class="pri_link" href="<?=base_url()?>admin/customer/list_all_trade"><?=$all_new_trade?></a></td>

									</tr>

									 <tr>

										<td style="font-weight: 700; width: 96%">Subscribe Sign Ups:</td>

										<td style="color: #e6006e"><?=$all_new_subscribe?></td>

									</tr> -->

								</table>

							</div>

						</div>

					</div>

				</div>

				<div class="span12" style="height: 15px">

				</div>

			</div>

			

			<div style="height: 15px;"></div>
			<? $webstat = $this->System_model->get_webstat(1); ?>
			<div class="row-fluid" style="border: 4px solid #ccc; border-radius: 10px">

				<div class="span12" style="min-height: 10px">

				</div>
                <div class="span12" style="font-size: 18px; font-weight: 700;height:15px;margin-left: 17px;">
				Website Traffic
				</div>

				<div class="span12"style="margin-left: 0">

					<div class="span3" >

						<div style="margin-left: 10%">
                            <div style="height: 20px;font-size: 18px; font-weight: 700; line-height: 20px">Today </div>
                            <div><span style=" font-weight: 500; height: 30px; line-height: 30px">Unique Visitors : <?=number_format($webstat['today_unique'])?></span> </div>
                            
                        </div>

					</div>

					<div class="span3" style="border-left: 1px solid #ccc;">

						<div style="margin-left: 10%">
                            <div style="height: 20px;font-size: 18px; font-weight: 700; line-height: 20px">Yesterday </div>
                            <div><span style=" font-weight: 500; height: 30px; line-height: 30px">Unique Visitors : <?=number_format($webstat['yesterday_unique'])?></span> </div>
                            
                        </div>

					</div>

					<div class="span3" style=" border-left: 1px solid #ccc;">

						<div style="margin-left: 10%">
                            <div style="height: 20px;font-size: 18px; font-weight: 700; line-height: 20px">This Month </div>
                            <div><span style=" font-weight: 500; height: 30px; line-height: 30px">Unique Visitors : <?=number_format($webstat['thismonth_unique'])?></span> </div>
                            
                        </div>

					</div>

					<div class="span3" style=" border-left: 1px solid #ccc;">

						<div style="margin-left: 10%">
                            <div style="height: 20px;font-size: 18px; font-weight: 700; line-height: 20px">Last Month </div>
                            <div><span style=" font-weight: 500; height: 30px; line-height: 30px">Unique Visitors : <?=number_format($webstat['lastmonth_unique'])?></span> </div>

                        </div>

					</div>

				</div>

				<div class="span12" style="height: 15px; margin-left: 0">

				</div>

			</div>

			

			<!-- end here -->

		</div>

	</div>

</div>

		