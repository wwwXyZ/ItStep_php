<div class="border_half_page">
	<div id="content_left" class="text_center">
		<div id="form"><br />
			<br />
			<span class="self_border">User Add:</span> <br /><br />
			<span>
				Nick: <input id="nick" type="text" name="nick" minlength="3" maxlength="30" /><br />
			</span>
			<span>
				Phone: <input id="phone" type="text" name="phone" /><br />
			</span>
			<span>
				Age: <input id="age" type="number" min="6" max="666" name="age" /><br />
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
			<a href="/user/add_interes">Add interes</a><br>
			<span style="display:none">
				<input id="new_interes" type="text" name="new_interes" /> <input onclick="add_interes();" id="add_interes_btn" type="submit" value="Add interes!" /><br />
			</span>
			<span>
				<input onclick="add_user();" type="submit" value="Send!" />
			</span> <br />
			<span class="alert"></span>
		</div>
	</div>
<script>
	user_page = true;
	page = <?php echo $page_number; ?>;
</script>