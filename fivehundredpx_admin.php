<?php
function fivehundredpx_admin() {
	add_options_page('500px Publisher Options', '500px Publisher','manage_options', __FILE__, 'fivehundredpx_options');
}
function fivehundredpx_options(){
?>
<div class="wrap">
	
<?php screen_icon(); ?>
<h2>500px WP Publisher</h2>

<?php
	if(isset($_POST['fivehundredpx_submit'])) {
		update_option('fivehundredpx_username', esc_html($_POST['fivehundredpx_username']));
		update_option('fivehundredpx_userid', intval($_POST['fivehundredpx_userid']));
		update_option('fivehundredpx_categoryid', intval($_POST['fivehundredpx_categoryid']));
		
		echo '<div class="updated"><p><strong>Settings updated</strong></p></div>';
	}
?>

<form action="" method="post" enctype="multipart/form-data" name="fivehundredpx_form">
<?php wp_nonce_field('update-options'); ?>

	<div id="poststuff" style="padding-top:10px; position:relative;">
		<div style="float:left; width:74%; padding-right:1%;">

	<div class="postbox">
		<h3>Settings</h3>
		<div class="inside">
			<table>
				<tr><td style="padding-bottom:20px;" valign="top">500px username:</td>
				<td style="padding-bottom:20px;">
					<input type="text" name="fivehundredpx_username" value="<?php echo get_option("fivehundredpx_username"); ?>" />
				</td></tr>
				
				<tr><td style="padding-bottom:20px;" valign="top">Post on behalf of user:</td>
				<td style="padding-bottom:20px;">
					<select name="fivehundredpx_userid">
						<?php
						require_once(ABSPATH . WPINC . '/post.php');
						$current_user = get_option("fivehundredpx_userid");
						if (empty($current_user)) {
							echo '<option value="0" selected="selected"></option>';
						}
						
						$all_users = get_users();

						foreach ($all_users as $user) {
							if ($current_user == $user->data->ID) {
								$selected = ' selected="selected"';
							} else {
								$selected = '';
							}
							
							echo '<option value="' . $user->data->ID . '"' . $selected
									. '>' . $user->data->display_name . '</option>';
						}
						?>
					</select>
				</td></tr>
				
				<tr><td style="padding-bottom:20px;" valign="top">Post to category:</td>
				<td style="padding-bottom:20px;">
					<select name="fivehundredpx_categoryid">
						<?php
						require_once(ABSPATH . WPINC . '/category.php');
						$current_category = get_option("fivehundredpx_categoryid");
						if (empty($current_category)) {
							echo '<option value="0" selected="selected"></option>';
						}
						
						$all_categories = get_categories();

						foreach ($all_categories as $category) {
							if ($current_category == $category->term_id) {
								$selected = ' selected="selected"';
							} else {
								$selected = '';
							}
							
							echo '<option value="' . $category->term_id . '"' . $selected
									. '>' . $category->cat_name . '</option>';
						}
						?>
					</select>
				</td></tr>
				
				<tr><td valign="top" colspan="2">
					<?php 
						$last_update = get_option('fivehundredpx_last_update');
						if (empty($last_update)) { 
					?>
						<p>Remember to add the following call to crontab:<br />
						<b>00 12 * * * php <?php echo WP_CONTENT_DIR
							. '/plugins/fivehundredpx-wp-publisher/cron.php'; ?></b><br />
						For more information, see <a href="http://linuxconfig.org/linux-cron-guide">this guide</a>	
						</p>
					<?php
						} else {
							echo '<p>Last run at ' . date('H:i:s \o\n m/d/Y', $last_update);
						}
					?>
				</td></tr>
				
				<tr><td valign="top" colspan="2">
					<p class="submit">
						<input type="submit" name="fivehundredpx_submit" class="button-primary" value="Save Changes" />
					</p>
				</td></tr>	
			</table>
		</div>
	</div>
		</div>
	</div>
	
	</form>
</div>			
<?php 
}
add_action('admin_menu', 'fivehundredpx_admin');
?>