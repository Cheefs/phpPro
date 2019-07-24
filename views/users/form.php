<?php
/* @var $user \app\models\User */
/* @var $this \app\controllers\Controller */

?>

<form method="post" class="form">
    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'username') ?></label>
        <input id="username" class="input" name="username" type="text" required
            value="<?= $user->getUserName() ?>"
        >
    </div>
    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'password') ?></label>
        <input class="input" id="password" name="password" type="password"
           <?= is_null($user->getId())? 'required' : 'disabled' ?>
        >
    </div>

    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'last name') ?></label>
        <input class="input" id="last_name" name="last_name" type="text"
            value="<?= $user->last_name ?> "
        >
    </div>
    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'first name') ?></label>
        <input class="input" id="first_name" name="first_name" type="text"
           value="<?= $user->first_name ?>"
        >
    </div>

    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'second name') ?></label>
        <input class="input" id="second_name" name="second_name" type="text"
           value="<?= $user->second_name ?>"
        >
    </div>

    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'email') ?></label>
        <input class="input" id="email" name="email" type="email"
           value="<?= $user->email ?>"
        >
    </div>

    <div class="form__field">
        <label class="label" for="username"><?= Translate::t('ru', 'phone') ?></label>
        <input class="input" id="phone" name="phone"
           value="<?= $user->phone ?>"
        >
    </div>

    <div class="flex">
        <button type="submit" class="form__button save">
            <?= Translate::t('ru', 'save') ?>
        </button>
        <button type="button" class="form__button cancel"
            data-href="?c=<?= $this->getControllerName()?>">
            <?= Translate::t('ru', 'cancel') ?>
        </button>
    </div>
</form>


