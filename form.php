			<h1>PushHiatus</h1>
			<form name="mainForm" action="form_post.php" method="post" onsubmit="return validateForm();" >
				<div class="bucket">
					<div class="formPair">
						<label for="WhyTheHiatus">Why are you taking a break? <span class="required">*</span></label></br>
						<select id="reason" name="reason">
							<option>Please select a reason...</option>
							<option>Vacation</option> 
							<option>Google+</option>
							<option>FB Break</option>
							<option>Other</option>
						</select></br>
					</div>
					<div id="errorReason" class="error">
						<p>A reason is required.</p>
					</div>
				</div>
				<div class="bucket clear">
					<div class="formPair">
						<label for="WhenComingBack">When are you coming back? <span class="required">*</span></label></br>
						<input id="date" class="text" type="text" name="date" /></br>
					</div>
					<div id="errorDate" class="error">
						<p>A date is required to stop messaging to your friends.</p>
					</div>
				</div>
				<div class="bucket clear">
					<div class="formPair">
						<label for="Message">Message <span class="required">*</span></label></br>
						<input id="message" class="text" type="text" name="message" /></br>
					</div>
					<div id="errorMessage" class="error">
						<p>A message is required to auto-reply to your friends.</p>
					</div>
				</div>
				<div class="clear"></div>
				<input class="button" title="Submit" type="submit" name="Submit" value="Submit" />
			</form>