<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form method="post" action="" >	

<input type="hidden" name="<?php echo $this->hidden_field_name; ?>" value="Y" />

<table class="form-table">
<tr valign="top">
<th scope="row"><label for="<?php echo $this->fb_publisher_name; ?>">FB Publisher ID</label></th>
<td><input type="url" id="<?php echo $this->fb_publisher_name; ?>" name="<?php echo $this->fb_publisher_name; ?>" value="<?php echo $this->options[$this->fb_publisher_name]; ?>" size="40" /></td>
</tr>


<tr valign="top">
<th scope="row"><label for="<?php echo $this->fb_page_app_field_name; ?>"><?php _e("facebook page app:", 'menu-test' ); ?></label></th>
<td><input type="number" id="<?php echo $this->fb_page_app_field_name; ?>" name="<?php echo $this->fb_page_app_field_name; ?>" value="<?php echo $this->options[$this->fb_page_app_field_name]; ?>" size="20"></td>
</tr>


<tr valign="top">
<th scope="row"><label for="<?php echo $this->fb_userids_field_name; ?>"><?php _e("facebook page userids:", 'menu-test' ); ?></label></th>
<td><input type="number" id="<?php echo $this->fb_userids_field_name; ?>" name="<?php echo $this->fb_userids_field_name; ?>" value="<?php echo $this->options[$this->fb_userids_field_name]; ?>" size="20" /></td>
</tr>
</table>

<?php submit_button(); ?>

</form>