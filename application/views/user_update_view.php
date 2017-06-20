<div class="border_half_page">
	<div id="content_left" class="text_center">
		<div id="form"><br />
			<br />
			<span class="self_border">User Update:</span> <br /><br />
			<span style="display:none;">
				Id: <input value="<?php echo $id; ?>" id="id" type="number" value="1" min="1" max="1000" name="id" minlength="3" maxlength="30" /><br />
			</span>
			<span>
				Nick: <input value="<?php echo $nick; ?>" id="nick" type="text" name="nick" minlength="3" maxlength="30" /><br />
			</span>
			<span>
				Phone: <input value="<?php echo $phone; ?>" id="phone" type="text" name="phone" /><br />
			</span>
			<span>
				Age: <input value="<?php echo $age; ?>" id="age" type="number" min="6" max="666" name="age" /><br />
			</span>
			<span>
				Interests:<br />
				<select id="interes_list" name="interests" multiple="multiple" />
					<?php
						foreach ($interests as $key => $value)
							echo "<option value='{$interests[$key]['id']}'>{$interests[$key]['interes']}</option>";
					?>
				</select>
			</span> <br />
			<span>
				<a href="/user/add_interes">Add interes</a><br>
				<!-- <input id="new_interes" type="text" name="new_interes" /> <input onclick="add_interes();" id="add_interes_btn" type="submit" value="Add interes!" /><br /> -->
			</span>
			<span>
				<input onclick="add_user(true);" type="submit" value="Send!" />
			</span> <br />
			<span class="alert"></span>
		</div>
	</div>
<script>
	interests = '<?php echo $interes_id; ?>';
    options = document.querySelectorAll('#interes_list option');
    interests.split(', ').forEach(function(v) {
      Array.from(options).find(c => c.value == v).selected = true;
    });
	user_page = true;
	page = <?php echo $page_number; ?>;
</script>