<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="<?php echo URLROOT?>/img/logo_1.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vogue Pawn | Confirm Pawn Message</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/styles_confirm_message.css">
</head>
<body>
    <div class="wrapper">
        <div class="message-wrapper">
            <div class="div-message">
                Confirm pawning?
            </div>
            <div class="div-buttons">
                <!-- <a href="<?php echo URLROOT; ?>/Pawnings/showConfirmMessage/<?php echo $data['validation_details']->id;?>/<?php echo $data['full_loan']; ?>/<?php echo $data['payment_method']; ?>" class="button btn-confirm">Confirm</a> -->
                <!-- <a href="" class="button btn-cancel">Cancel</a> -->
                <input type="submit" name="confirm" value="Confirm" class="button btn-confirm">
                <input type="submit" name="cancel" value="Cancel" class="button btn-cancel">
            </div>
        </div>
    </div>
</body>