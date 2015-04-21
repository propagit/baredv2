<style type="text/css">
#page-analtyics {
  clear: left;
}
#page-analtyics .metric {
  background: #fefefe; /* Old browsers */
    background: -moz-linear-gradient(top, #fefefe 0%, #f2f3f2 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefefe), color-stop(100%,#f2f3f2)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top, #fefefe 0%,#f2f3f2 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top, #fefefe 0%,#f2f3f2 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top, #fefefe 0%,#f2f3f2 100%); /* IE10+ */
    background: linear-gradient(top, #fefefe 0%,#f2f3f2 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefefe', endColorstr='#f2f3f2',GradientType=0 ); /* IE6-9 */
  border: 1px solid #ccc;
  float: left;
  font-size: 12px;
  margin: -4px 0 1em -1px;
  padding: 10px;
  width: 125px;
}
#page-analtyics .metric:hover {
  background: #fff;
  border-bottom-color: #b1b1b1;
}
#page-analtyics .metric .legend {
  background-color: #058DC7;
  border-radius: 5px;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
  font-size: 0;
  margin-right: 5px;
  padding: 10px 5px 0;
}
#page-analtyics .metric strong {
  font-size: 16px;
  font-weight: bold;
}
#page-analtyics .range {
  color: #686868;
  font-size: 11px;
  margin-bottom: 7px;
  width: 100%;
}
</style>
<script>

function save_web()
{
	var email = $('#web_email').val();
	var password = $('#web_password').val();
	var profile_id = $('#profile_id').val();

	jQuery.ajax({

		url: '<?=base_url()?>admin/system/set_webstat',

		type: 'POST',

		data: ({email:email,password:password,profile_id:profile_id}),

		dataType: "html",

		success: function(html) {

			jQuery('#any_message').html("Your web stat details has been successfully updated");

			$('#anyModal').modal('show');

			

		}

	})

	//alert(val);

}

</script>
<div class="span9">

	<div style="min-height: 365px; border: 1px solid #d6d6d6; border-radius: 5px; margin-right: 19px;">

		<div style="padding: 20px">

			<!-- start here -->

			<h1>

				Web Stats Setting

			</h1>

			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">

				Email

			</div>

			<div style="width: 80%; float: left;">
				<div style="float: left" >                  	
					<input style="width: 190px;" class="span2" id="web_email" type="text" value="<?=$webstat['web_email']?>">
				</div>
			</div>

			<div style="clear: both; height: 15px"></div>

			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">

				Password

			</div>

			<div style="width: 80%; float: left;">

				<div style="float: left">

					<input style="width: 190px;" class="span2" id="web_password" type="text" value="<?=$webstat['web_password']?>">

				</div>

				

			</div>

			<div style="clear: both; height: 15px"></div>

			<div style="width: 20%; float: left; font-weight: 700; height: 30px; line-height: 30px">

				Profile ID

			</div>

			<div style="width: 80%; float: left;">

				<div style="float: left">

					<input style="width: 190px;" class="span2" id="profile_id" type="text" value="<?=$webstat['profile_id']?>">

				</div>

				

			</div>

			<div style="clear: both; height: 15px"></div>

			

			<button onclick="save_web()" class="btn btn-primary" type="button" >Update</button>
            
            <a target="_blank" href="https://accounts.google.com/ServiceLogin?service=analytics&passive=true&nui=1&hl=en&continue=https%3A%2F%2Fwww.google.com%2Fanalytics%2Fweb%2F%3Fhl%3Den&followup=https%3A%2F%2Fwww.google.com%2Fanalytics%2Fweb%2F%3Fhl%3Den"><button class="btn btn-primary" type="button" >Log In to Google Analytics</button></a>

			

			<div style="clear: both; height:30px;"></div>

			<!-- end here -->
           <? 
            
			echo '<div id="page-analtyics" class="metric">';
            
              echo '<div class="metric"><span><b>Today</b> <br />Unique Visitors</span><br><strong>'.number_format($webstat['today_unique']).'</strong></div>';
              echo '<div class="metric"><span><b>Yesterday</b> <br />Unique Visitors</span><br><strong>'.number_format($webstat['yesterday_unique']).'</strong></div>';
              echo '<div class="metric"><span><b>This month</b> <br> Unique Visitors</span><br><strong>'.number_format($webstat['thismonth_unique']).'</strong></div>';
			  echo '<div class="metric"><span><b>Last month</b> <br>Unique Visitors</span><br><strong>'.number_format($webstat['lastmonth_unique']).'</strong></div>';
              //echo '<div class="metric"><span>Bounce rate</span><br /><strong>'.round($webstat['today_pageview'], 2).'%</strong></div>';
              //echo '<div class="metric"><span>Exit rate</span><br /><strong>'.round($webstat['today_pageview'], 2).'%</strong></div>';
              echo '<div style="clear: left;"></div>';
            
            echo '</div>';
			?>
		</div>

	</div>

</div>

<div id="anyModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

<div class="modal-header">

<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

<h3 id="myModalLabel">Message</h3>

</div>

<div class="modal-body">

    <p id="any_message"></p>

</div>

<div class="modal-footer">

<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Close</button>



</div>

</div>
