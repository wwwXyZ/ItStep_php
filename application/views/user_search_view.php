<div class="border_half_page">
	<div id="content_left" class="text_center">
		<div id="form"><br />
			<br />
			<span class="self_border">User Search:</span> <br /><br />
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
			<span>
				<input onclick="search_user();" type="submit" value="Search!" />
			</span> <br />
			<span class="alert"></span>
		</div>
	</div>
<script>
	user_page = false;
</script>