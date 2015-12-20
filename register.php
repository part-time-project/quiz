<?php
	$provinces = array(
		'0' => 'SELEZIONA PROVINCIA',
		'italia' => 'Italia' 
	);
	$professions = array(
		'0' => 'PROFESSIONE',
		'developer' => 'Developer'
	);

	$fname = '';
	$lname = '';
	$email = '';
	$province = '';
	$profession = '';
	$phone = '';
	$legal = '';

	if (!empty($_POST)) {

	} else {

	}
?>
<div id="register" class="center-block text-center">
	<div id="register-form">
		<form action="/register" method="POST">
			<div class="form-group">
				<input type="text" class="form-control" id="fname" placeholder="NOME" value="<?php echo $fname ?>">
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="lname" placeholder="COGNAME" value="<?php echo $lname ?>">
			</div>
			<div class="form-group">
				<select name="province" class="form-control">
					<option value="0">SELEZIONA PROVINCIA</option>
					<option value="italia">Italia</option>
				</select>
			</div>
			<div class="form-group">
				<input type="text" class="form-control" id="phone" placeholder="TELEFONO" value="<?php echo $phone ?>">
			</div>
		 	<div class="form-group">
				<input type="email" class="form-control" id="email" placeholder="EMAIL" value="<?php echo $email ?>">
			</div>
			<div class="form-group">
				<select name="profession" class="form-control">
					<option value="0">PROFESSIONE</option>
					<option value="developer">Developer</option>
				</select>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="legal" value="1"<?php echo $agreed; ?>> I agree with Terms and Conditions
				</label>
			</div>
			<button type="submit" id="register-button"></button>
		</form>
	</div>
</div>