<style>

</style>

<div class="span4">
	&nbsp;
</div>
<div class="span4">
	<div class="row-fluid" style="border:1px solid #e2e2e2;border-radius: 10px; margin-top: 45%">
		<div class="span12">
			<img src="<?=base_url()?>img/header/Logo.png" style="margin-left: 26%; margin-right: 5%; margin-top: 15px;  margin-bottom: 30px; width:52.5%"/>
			<form method="post" action="<?=base_url()?>admin/validate">
			<div class="row-fluid">
				<div class="span1 hidden-phone">
					&nbsp;
				</div>
				<!-- <div class="span4 hidden-phone" style="line-height: 30px">
					Username
				</div> -->
				<div class="span3" >
					<div style="line-height: 30px; margin-left: 5%; margin-right: 5%; width: 90%">
						Username
					</div>
				</div>
				<!-- <div class="span6 hidden-phone">
					<input type="text" class="span12" name="username"/>
				</div> -->
				<div class="span7" >
					<input required type="text" class="span12" name="username" style="margin-left: 5%; margin-right: 5%; width: 90%"/>
				</div>
				<div class="span1 hidden-phone">
					&nbsp;
				</div>
			</div>
			<div class="row-fluid">
				<div class="span1 hidden-phone">
					&nbsp;
				</div>
				<!-- <div class="span4 hidden-phone" style="line-height: 30px">
					Password
				</div> -->
				<div class="span3">
					<div style="line-height: 30px; margin-left: 5%; margin-right: 5%; width: 90%">
						Password
					</div>
				</div>
				<!-- <div class="span6 hidden-phone">
					<input type="password" class="span12" name="password"/>
				</div> -->
				<div class="span7">
					<input required type="password" class="span12" name="password" style="margin-left: 5%; margin-right: 5%; width: 90%"/>
				</div>
				<div class="span1 hidden-phone">
					&nbsp;
				</div>
			</div>
			<div class="row-fluid">
				<div class="span7 hidden-phone">
					&nbsp;
				</div>
				<div class="span4 hidden-phone">
					<div style="float:right; margin-left: 5%; margin-right: 9%; width: 90%">
						<button class="btn btn-inverse span12" type="submit">Login</button>
					</div>
				</div>
				<div class="span3 visible-phone" style="margin-left: 5%; margin-right: 5%; width: 90%">
					<button class="btn btn-inverse span12" type="submit">Login</button>
				</div>
				<div class="span1 hidden-phone">
					&nbsp;
				</div>
			</div>
			</form>
			<?php if($this->session->flashdata('error')) { ?>
				    <div class="alert alert-error" style="margin-left: 5%; margin-right: 5%">
				    <button type="button" class="close" data-dismiss="alert">&times;</button>
				    <strong>Error!</strong> Authorization failed: wrong combination of username/password
				    </div>
			<?php }?>
		</div>
	</div>
</div>
<div class="span4">
	&nbsp;
</div>