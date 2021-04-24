<?php include("application/views/instagram_reply/comment_reply/comment_reply_css.php"); ?>
<section class="section section_custom">
	<div class="section-header">
		<h1><i class="fab fa-instagram"></i> <?php echo $page_title; ?></h1>
		<div class="section-header-breadcrumb">
			<div class="breadcrumb-item"><a href="<?php echo base_url("instagram_reply") ?>"><?php echo $this->lang->line("Instagram Reply");?></a></div>
			<div class="breadcrumb-item"><?php echo $page_title; ?></div>
		</div>
	</div>

	<div class="section-body">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-12 ">
						<div class="form-group">
							<div class="form-group">
								<div class="input-group">
									<select name="account_name" id="account_name" class="form-control select2">
										<option value=""><?php echo $this->lang->line('Select Account'); ?></option>
										<?php foreach ($account_lists as $value) {
											echo '<option value="'.$value['id'].'">'.$value['insta_username'].' ['.$value['page_name'].'] '.'</option>';
										} ?>
									</select>
									<input type="text" class="form-control" id="hash_tag" name="hash_tag" placeholder="<?php echo $this->lang->line('Provide hash tag'); ?>">
									<div class="input-group-append">
										<button class="btn btn-primary" id="search_hashtag"><i class="fas fa-search"></i> <?php echo $this->lang->line('Search'); ?></button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-12 text-center" id="preloader"></div>

					<div class="col-12">
						<div id="hashtag_search_result"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<script>
	$(document).ready(function() {
		var base_url = '<?php echo base_url(); ?>';

		$(document).on('click', '#search_hashtag', function(event) {
			event.preventDefault();

			var account_name = $("#account_name").val();
			var hash_tag = $("#hash_tag").val();

			if(account_name == "") {
				swal('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Please select an instagram account"); ?>', 'warning');
				return false;
			}

			if(hash_tag == "") {
				swal('<?php echo $this->lang->line("Warning"); ?>', '<?php echo $this->lang->line("Please provide hash tag"); ?>', 'warning');
				return false;
			}

			$("#hashtag_search_result").html("");

			$(this).addClass('btn-progress disabled')

			$("#preloader").html('<img width="30%" class="center-block text-center" src="<?php echo base_url('assets/pre-loader/loading-animations.gif')?>" alt="Processing...">');

			$.ajax({
				context:this,
				url: base_url+'instagram_reply/hashtag_search_result',
				type: 'POST',
				data: {account_name: account_name,hash_tag: hash_tag},
				success:function(response){
					$(this).removeClass('btn-progress disabled')
					$("#preloader").html("");
					$("#hashtag_search_result").html(response);
				}
			})
			


		});
	});
</script>