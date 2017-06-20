<div class="border_half_page">
	<div id="content_left" class="text_center">
		<div id="form"><br />
			<br />
			<span class="self_border">Filters:</span> <br /><br />
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
				<input id="new_interes" type="text" name="new_interes" /> <input onclick="add_interes();" id="add_interes_btn" type="submit" value="Add interes!" /><br />
			</span>
			<span>
				<input onclick="add_user();" type="submit" value="Send!" />
			</span> <br />
			<span class="alert"></span>
		</div>
	</div>
	<div id="content_right" class="text_center">
		<div id="users">
			<table>
			<!--
				<li>
					<ul class="five_cells">
					  <li>Id</li>
					  <li>Nick</li>
					  <li>Phone</li>
					  <li>Interests</li>
					</ul>
				</li>
				-->
			<?php
			/*
			foreach ($users as $key => $value) {
				$interes_str = "";
				echo '<br />';
				echo '<li>';
					echo '<ul class="five_cells">';
						echo "<li> Id: {$users[$key]['id']}</li>";
						echo "<li>Nick: {$users[$key]['nick']}</li>";
						echo "<li>Phone: {$users[$key]['phone']}</li>";
						foreach ($users[$key]['interests'] as $interes_key => $interes_value)
							$interes_str .= "&nbsp;&nbsp;&nbsp;&nbsp;*)".$users[$key]['interests'][$interes_key]."<br />";
						echo "<li style=\"float: left; text-align: left;\">Interests:<br />".(empty($interes_str) ? "-" : $interes_str)."</li>";
					echo '</ul>';
				echo '</li>';
			}
			*/
		?>
			</table>
		</div>
		<div id="listing">
			<button onclick="back_page();">back</button>&nbsp;<button onclick="next_page();">next</button>
			<br />
			page: <span class="page_number"></span> 
			<br />
			Url:<input type="text" value="" id="url" readonly /> <button class="cp" data-clipboard-target="#url" class="button">Копировать!</button>
		</div>
	</div>
</div>
<script>
	user_page = true;
	page = <?php echo $page_number; ?>;
</script>