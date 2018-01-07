<div style="font-family: 'Century Gothic';">
	<div style="width: 100%; padding: 1px 0; background: #3e894d; text-align: center;">
		<h3 style="color: white;">Activate you Account</h3>
	</div>
	<div class="" style="background: #ddd; text-align: center; padding: 30px; background: #a9d8b3;">
		<h2>Hi, <?= $nickname ?></h2>


		<p>Please activate your account now. Kindly click the activation link below</p>
		<a style="padding: 10px; margin: 5px; color: white; text-decoration: none; background: #4caf50;"  class="account-activation w3-padding w3-button w3-teal w3-margin" href="<?= $link ?>">Activate account</a>

		<p>or</p>

		<p>Activate your account using the link below.</p>
		<a class="account-activation w3-padding w3-margin" href="<?= $link ?>"><?= $link ?></a>
	</div>
</div>