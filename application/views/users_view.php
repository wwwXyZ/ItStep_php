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
				<input target="_blank"  type="button" value="Add" onclick="window.open('/user/add')" />
				<!--<a target="_blank" href="/user/add">add</a> -->
				<input onclick="search_user();" type="submit" value="Search!" />
				<button onclick="reset_input();">RESET</button>
			</span> <br />
			<span class="alert"></span>
		</div>
	</div>

	<div id="content_right" class="">
		<div class="clear" id="users">
			<ul>
			</ul>
		</div>
		<div id="listing">
			
		
			<button style="background-color: #ffffff;" class="button" onclick="back_page();">back</button>&nbsp;<span id="listing_self"></span>&nbsp;<button style="background-color: #ffffff;" class="button" onclick="next_page();">next</button>
			
			<br />
<!--			page: <span class="page_number"></span> <hr>
			<br />
			Url:<input type="text" value="" id="url" readonly /> <button class="cp button" data-clipboard-target="#url">Копировать!</button>-->
		</div>
	</div>
</div>
<script>
	user_page = true;
	page = <?php echo $page_number; ?>;
</script>