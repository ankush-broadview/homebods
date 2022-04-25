<?php  https:
include(dirname(__FILE__).'/header.php');
include(dirname(__FILE__).'/user_session_check.php');

$extensionslist = $setting->get_contents('http://skymoonlabs.com/cleanto/extensions-assets/extensions_list.php?'.time());
$arr_extensionslist = json_decode($extensionslist);
?>
<div id="addons_page" class="panel tab-content">
  <div class="panel-body">
    <div class="container-fluid mt-20 mb-20">
			<div class="container">
				<h1 class="main_head"><?php if(isset($arr_extensionslist->Available_Extension_For_Cleanto)){ echo $arr_extensionslist->Available_Extension_For_Cleanto; } ?></h1>
				<?php  if(isset($arr_extensionslist->enable_disable_headline) && $arr_extensionslist->enable_disable_headline == 'Y'){ ?><div class="head_line"></div> <?php  } ?>
				<section><?php if(isset($arr_extensionslist->Add_some_more_features_in_Cleanto_tool_with_new_Extensions)){ echo $arr_extensionslist->Add_some_more_features_in_Cleanto_tool_with_new_Extensions; } ?></section>
			</div>
		</div>
		<div class="clearfix"></div>
		<div class="container-fluid mt-20 mb-20">
			<div class="container">
				<?php 
				if(isset($arr_extensionslist->extensions)){
					if(sizeof((array)$arr_extensionslist->extensions)>0){
						$i = 0;
						foreach($arr_extensionslist->extensions as $extensions){
							?>
							<div class="row">
								<div class="col-lg-12 col-ms-12 col-sm-12 col-xs-12 ">
									<div class="addon_box">
										<div class="col-xs-3 float_none">
											<img src="<?php echo $extensions->icon; ?>" alt="<?php echo $extensions->alt_icon; ?>" width="<?php echo $extensions->image_width; ?>">
											<div class="clearfix"></div>
											<label><?php echo $extensions->purchase_price; ?></label>
										</div>
										<div class="col-xs-9">
											<div class="version_no version_full"><?php echo $extensions->version_label_text; ?></div>
											<h3><a href="javascript:void(0);"><?php echo $extensions->title; ?></a></h3>
											<strong><?php echo $extensions->required_ct_version; ?></strong>
											<p>
												<?php  echo $extensions->description; ?>
											</p>
											
											<?php 
												if((file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension)) && $setting->get_option($extensions->purchase_option_name) == 'N'){
													if($extensions->free_extention_class_name != ''){
														?>
														<h4><i class="fa fa-check-square 7" aria-hidden="true"></i> <a href="javascript:void(0);" class="<?php echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Activate_Feature_label_text; ?></a></h4>
														<?php 
													}else{
														?>
														<h4><i class="fa fa-check-square 1" aria-hidden="true"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#Extension_verify_purchasecode_modal<?php  echo $i; ?>"><?php echo $extensions->Activate_Feature_label_text; ?></a></h4>
														<?php 
													}
												}elseif((!file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension.'-'.$extensions->version.'.zip')) && $setting->get_option($extensions->purchase_option_name) == 'Y'){
													if($extensions->free_extention_class_name != ''){
														?>
														<h4><i class="fa fa-check-square 7" aria-hidden="true"></i> <a href="javascript:void(0);" class="<?php echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Activate_Feature_label_text; ?></a></h4>
														<?php 
													}else{
														?>
														<h4><i class="fa fa-check-square 2" aria-hidden="true"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#Extension_verify_purchasecode_modal<?php  echo $i; ?>"><?php echo $extensions->Activate_Feature_label_text; ?></a></h4>
														<?php 
													}
												}elseif(!file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension.'-'.$extensions->version.'.zip') && $setting->get_option($extensions->purchase_option_name) == 'N'){
													if($extensions->free_extention_class_name != ''){
														?>
														<h4><i class="fa fa-check-square 7" aria-hidden="true"></i> <a href="javascript:void(0);" class="<?php echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Activate_Feature_label_text; ?></a></h4>
														<?php 
													}else{
														?>
														<h4><i class="fa fa-check-square 3" aria-hidden="true"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#Extension_verify_purchasecode_modal<?php  echo $i; ?>"><?php echo $extensions->Activate_Feature_label_text; ?></a></h4>
														<?php 
													}
												}elseif(file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && $setting->get_option($extensions->version_option_name) != '' && ($setting->get_option($extensions->version_option_name) < $extensions->version)){
													if($extensions->free_extention_class_name != ''){
														?>
														<h4 class="ct_set_installed_color 4"><i class="fa fa-check-square" aria-hidden="true"></i> <a href="javascript:void(0);" class="<?php echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Update_Feature_label_text; ?></a></h4>
														<?php 
													}else{
														?>
														<h4 class="ct_set_installed_color 5"><i class="fa fa-check-square" aria-hidden="true"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#Extension_verify_purchasecode_modal<?php  echo $i; ?>"><?php echo $extensions->Update_Feature_label_text; ?></a></h4>
														<?php 
													}
												}elseif(file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && $setting->get_option($extensions->purchase_option_name) == 'Y'){
													?>
													<h4 class="ct_three_column"><i class="fa fa-eye-slash" aria-hidden="true"></i> <a href="javascript:void(0);" class="ct_deactivate_extension" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Deactivate_label_text; ?></a></h4>
													
													<h4 class="ct_set_delete_ext_color ct_three_column"><i class="fa fa-close" aria-hidden="true"></i> <a href="javascript:void(0);" class="ct_uninstall_extension" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Remove_label_text; ?></a></h4>
													
													<h4 class="ct_set_installed_color ct_three_column"><i class="fa fa-check-square 6" aria-hidden="true"></i> <a href="javascript:void(0);"><?php echo $extensions->Installed_label_text; ?></a></h4>
													
													<?php 
												}else{
													if($extensions->free_extention_class_name != ''){
														?>
														<h4 class="ct_set_installed_color"><i class="fa fa-check-square 7" aria-hidden="true"></i> <a href="javascript:void(0);" class="<?php echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><?php echo $extensions->Add_Feature_label_text; ?></a></h4>
														<?php 
													}else{
														?>
														<h4 class="ct_set_installed_color"><i class="fa fa-check-square 8" aria-hidden="true"></i> <a href="javascript:void(0);" data-toggle="modal" data-target="#Extension_verify_purchasecode_modal<?php  echo $i; ?>"><?php echo $extensions->Add_Feature_label_text; ?></a></h4>
														<?php 
													}
												}
												?>
											
											<!-- Modal -->
											<div id="Extension_verify_purchasecode_modal<?php  echo $i; ?>" class="Extension_verify_purchasecode_modal modal fade" role="dialog">
												<div class="modal-dialog">
													<!-- Modal content-->
													<div class="modal-content">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Verify Purchase Code</h4>
														</div>
														<div class="modal-body">
															<form>
																<div class="input-group">
																	<input type="text" value="" class="form-control verify_purchase_code_value_<?php  echo $extensions->extension; ?>" placeholder="Enter purchase code">
																	<div class="input-group-btn">
																		<?php  
																		if((file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension)) && $setting->get_option($extensions->purchase_option_name) == 'N'){
																			?>
																			<a href="javascript:void(0);" class="btn btn-default ct_activate_extensions" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><i class="fa fa-check-square" aria-hidden="true"></i> Verify</a>
																			<?php 
																		}elseif((!file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension.'-'.$extensions->version.'.zip')) && $setting->get_option($extensions->purchase_option_name) == 'Y'){
																			?>
																			<a href="javascript:void(0);" class="btn btn-default ct_activate_extensions_zip" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><i class="fa fa-check-square" aria-hidden="true"></i> Verify</a>
																			<?php 
																		}elseif(!file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension.'-'.$extensions->version.'.zip') && $setting->get_option($extensions->purchase_option_name) == 'N'){
																			?>
																			<a href="javascript:void(0);" class="btn btn-default ct_activate_extensions_zip" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><i class="fa fa-check-square" aria-hidden="true"></i> Verify</a>
																			<?php 
																		}elseif(file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && $setting->get_option($extensions->version_option_name) != '' && ($setting->get_option($extensions->version_option_name) < $extensions->version)){
																			?>
																			<a href="javascript:void(0);" class="btn btn-default <?php  echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><i class="fa fa-check-square" aria-hidden="true"></i> Verify</a>
																			<?php 
																		}elseif(file_exists(dirname(dirname(__FILE__)).'/extension/'.$extensions->extension) && $setting->get_option($extensions->purchase_option_name) == 'Y'){
																			?>
																			<a href="javascript:void(0);" class="btn btn-default"><i class="fa fa-check-square" aria-hidden="true"></i> Verify</a>
																			<?php 
																		}else{
																			?>
																			<a href="<?php echo $extensions->buy_now_link; ?>" class="btn btn-default <?php  echo $extensions->free_extention_class_name; ?>" data-installed_version="<?php echo $setting->get_option($extensions->version_option_name); ?>" data-update_version="<?php echo $extensions->version; ?>" data-redirect_to="<?php echo $extensions->after_installed_redirect_to; ?>" data-extension="<?php echo $extensions->extension; ?>" <?php  echo $extensions->target_blank; ?> data-purchase_option='<?php echo $extensions->purchase_option_name; ?>' data-version_option='<?php echo $extensions->version_option_name; ?>'><i class="fa fa-check-square" aria-hidden="true"></i> Verify</a>
																			<?php 
																		}
																		?>
																	</div>
																</div>
															</form>
															<label class="purchase_code_err purchase_code_err_<?php  echo $extensions->extension; ?>"></label>
														</div>
														<div class="modal-footer"></div>
													</div>
												</div>
											</div>
											<p>
												<?php  echo $extensions->extra_notes; ?>
											</p>
										</div>
									</div>
								</div>
							</div>
							<?php 
							$i++;
						}
					}
				}
				?>
			</div>
		</div>
  </div>
</div>
<?php  
	include(dirname(__FILE__).'/footer.php');
?>
<script>
  var ajax_url = '<?php echo AJAX_URL;?>';
	var base_url = '<?php echo BASE_URL;?>';
	var calObj={'ajax_url':'<?php echo AJAX_URL;?>'};
	var times={'time_format_values':'<?php echo $gettimeformat;?>'};
	var site_ur = {'site_url':'<?php echo SITE_URL;?>'};
</script>