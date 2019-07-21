<?php
/* @var $this \app\controllers\Controller*/
/* @var $users \app\models\User[] */
?>

<nav class="nav">
    <a class="nav__btn" href="/"><?= Translate::t('ru', 'home')?></a>
</nav>

<table class="table">
    <thead class="table__head">
        <tr class="head__row">
            <th class="head__cell"><?= Translate::t('ru', 'id')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'username')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'last name')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'first name')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'second name')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'email')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'phone')?></th>
            <th class="head__cell actions">
                <i class="btn create far fa-plus-square"
                    data-href="?c=<?= $this->getControllerName() ?>&a=save"
                ></i>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr class="table__row" data-href="?c=users&a=view&id=<?= $user->getId() ?>">
            <td class="table__cell"><?= $user->getId() ?></td>
            <td class="table__cell"><?= $user->getUserName() ?></td>
            <td class="table__cell"><?= $user->last_name ?></td>
            <td class="table__cell"><?= $user->first_name ?></td>
            <td class="table__cell"><?= $user->second_name ?></td>
            <td class="table__cell"><?= $user->email ?></td>
            <td class="table__cell"><?= $user->phone ?></td>

            <td class="table__cell">
                <i class="btn update fas fa-pencil-alt"
                   data-href="?c=<?= $this->getControllerName() ?>&a=save&id=<?= $user->getId() ?>"
                ></i>
                <i class="btn delete far fa-trash-alt"
                   data-href="?c=<?= $this->getControllerName() ?>&a=delete&id=<?= $user->getId() ?>"
                ></i>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
