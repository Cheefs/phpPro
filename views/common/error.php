<?php
 /* @var $message string */
?>

<div class="error">
    <div class="error__message">
        <?= $message ?>
    </div>
    <nav class="nav">
        <a class="nav__btn" href="/">
            <?= Translate::t('ru', 'home')?>
        </a>
    </nav>
</div>
