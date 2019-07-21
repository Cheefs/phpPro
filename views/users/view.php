<?php
/* @var $user \app\models\User */
/* @var $cart \app\models\Cart[] */

?>

<nav class="nav">
    <a class="nav__btn" href="/"><?= Translate::t('ru', 'home')?></a>
    <a class="nav__btn" href="?c=<?= $this->getControllerName() ?>&a=index">
        <?= Translate::t('ru', 'back')?>
    </a>
</nav>

<div class="container">
    <div>
       <span class="text_bold">
          <?= Translate::t('ru', 'id')?>:
       </span>
       <span> <?= $user->getId() ?></span>
    </div>
    <div>
        <span class="text_bold">
            <?= Translate::t('ru', 'username')?>:
        </span>
        <span> <?= $user->getUserName() ?></span>
    </div>
    <div>
        <span class="text_bold">
          <?= Translate::t('ru', 'last name')?>:
        </span>
        <span> <?= $user->last_name ?></span>
    </div>
    <div>
        <span class="text_bold">
            <?= Translate::t('ru', 'first name')?>:
        </span>
        <span> <?= $user->first_name ?></span>
    </div>
    <div>
        <span class="text_bold">
            <?= Translate::t('ru', 'second name')?>:
        </span>
        <span> <?= $user->second_name ?></span>
    </div>
    <div>
        <span class="text_bold">
            <?= Translate::t('ru', 'email')?>:
        </span>
        <span> <?= $user->email ?></span>
    </div>
    <div>
        <span class="text_bold">
            <?= Translate::t('ru', 'phone')?>:
        </span>
        <span> <?= $user->phone ?></span>
    </div>
</div>

<div>

    <?php if (count($cart)) :?>
    <table class="table">
        <caption><?= Translate::t('ru', 'cart products')?></caption>
        <thead class="table__head">
        <tr class="head__row">
            <th class="head__cell"><?= Translate::t('ru', 'id')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'name')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'price')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'count')?></th>
            <th class="head__cell"><?= Translate::t('ru', 'photo')?></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($cart as $item):
            /* @var $productInfo \app\models\Product */
            $productInfo = $item->getProduct($item->product_id);
            ?>
            <tr class="table__row" data-href="?u=products&a=view&id=<?= $item->getId() ?>">
                <td class="table__cell"><?= $item->getId() ?></td>
                <td class="table__cell"><?= $productInfo->name ?></td>
                <td class="table__cell"><?= $productInfo->price ?> x 1</td>
                <td class="table__cell"><?= $item->count ?></td>
                <td class="table__cell">
                  <img class="product__photo" src="/assets/<?= $productInfo->photo ?>" alt="product-photo">
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php else :?>
        <h3 class="text_center"> Cart is empty! </h3>
    <?php endif; ?>
</div>
