<?php
$meta_title = 'Result';
?>

<?php foreach ($arResult as $user) : ?>
    <?= $user['fullName'] ?> - <?=$user['balance']?><p>
<?php endforeach; ?>
