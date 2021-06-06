<?php

$action = '?page=newsletter&action=createSubscriber';
if (isset($_GET['userId'])) {
    $action = '?page=newsletter&action=updateSubscriber&userId=' . $userId;
}
?>

<style>
	.newsletterForm {font-family: Arial, Helvetica, sans-serif;}
	input[type=text], select, textarea {
		width: 100%;
		padding: 6px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
	}
	.newsletterForm select {
		display: block;
		width: 300px;
		padding: 6px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
	}
	.newsletterForm label {
		font-size: 14px;
	}
	.newsletterForm input[type=datetime-local]{
		display: block;
		width: 300px;
		padding: 6px;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
		margin-top: 6px;
		margin-bottom: 16px;
		resize: vertical;
	}
	input[type=submit] {
		background-color: #4CAF50;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	input[type=submit]:hover {
		background-color: #45a049;
	}

	.newsletterForm {
		border-radius: 5px;
		background-color: #f2f2f2;
		padding: 20px;
	}
</style>
</head>
<body>

<h3><?= __('Subscriber', '')?></h3>

<div class="newsletterForm">

	<form method="POST" action="<?=$action?>">
        <div class="row">
    		<label for="email"><?=__('Email address', '')?></label>
	    	<input size="30" type="text" id="email" name="email" placeholder="Email" value="<?= $email ?? ''?>" required>

            <label for="emailStatus"><?= __('Status', '')?></label>
            <select type=select id="newStatus" name="emailStatus">
                <option value="1" <?=($emailStatus == 1) ? 'selected':''?>><?= __('confirmed', '')?></option>
                <option value="0" <?=($emailStatus == 0) ? 'selected':''?>><?= __('not confirmed', '')?></option>
                <option value="-1" <?=($emailStatus == -1) ? 'selected':''?>><?= __('unsubscribed', '')?></option>
                <option value="-2" <?=($emailStatus == -2) ? 'selected':''?>><?= __('bounced', '')?></option>
            </select>

            <label for="firstName"><?=__('First Name', '')?></label>
            <input type="text" id="firstName" name="firstName" placeholder="First Name" value="<?= $firstName ?? ''?>">
            <label for="lastName"><?=__('Last Name', '')?></label>
            <input type="text" id="lastName" name="lastName" placeholder="Last Name" value="<?= $lastName ?? ''?>">

            <input type="submit" value="Submit">
        </div>
		<input type="hidden" id="created" name="createdAt"  value="<?= $createdAt ?? date("Y-m-d H:i:s") ?>" />
        <input type="hidden" id="updated" name="updatedAt"  value="<?= $updatedAt ?? date("Y-m-d H:i:s") ?>" />
	</form>
</div>

</body>
</html>
