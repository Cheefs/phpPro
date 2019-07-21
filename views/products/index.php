<?php
/* @var $this \app\controllers\Controller */
/* @var $products \app\models\Product[] */


Translate::t('ru','test');
?>

<nav class="nav">
    <a class="nav__btn" href="/"><?= Translate::t('ru', 'home')?></a>
</nav>

<table class="table">
    <thead class="table__head">
    <tr class="head__row">
        <th class="head__cell"><?= Translate::t('ru', 'id')?></th>
        <th class="head__cell"><?= Translate::t('ru', 'photo')?></th>
        <th class="head__cell"><?= Translate::t('ru', 'name')?></th>
        <th class="head__cell"><?= Translate::t('ru', 'price')?></th>
        <th class="head__cell"><?= Translate::t('ru', 'material')?></th>
        <th class="head__cell"><?= Translate::t('ru', 'desc')?></th>
        <th class="head__cell"><?= Translate::t('ru', 'brand')?></th>

        <th class="head__cell actions">
            <i class="btn create far fa-plus-square hide"
               data-href="?c=<?= $this->getControllerName() ?>&a=save"
            ></i>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $product): ?>
        <tr class="table__row" data-href="?c=<?= $this->getControllerName() ?>&a=view&id=<?= $product->getId() ?>">
            <td class="table__cell"><?= $product->getId() ?></td>
            <td class="table__cell">
                <img class="product__photo" src="/assets/<?= $product->photo ?>" alt="product-photo">
            </td>
            <td class="table__cell"><?= $product->name ?></td>
            <td class="table__cell"><?= $product->price ?></td>

            <td class="table__cell"><?= $product->material ?></td>
            <td class="table__cell"><?= $product->desc ?></td>
            <td class="table__cell"><?= $product->brand ?></td>

            <td class="table__cell">
                <i class="btn update fas fa-pencil-alt hide"
                   data-href="?c=<?= $this->getControllerName() ?>&a=save&id=<?= $product->getId() ?>"
                ></i>
                <i class="btn delete far fa-trash-alt"
                   data-href="?c=<?= $this->getControllerName() ?>&a=delete&id=<?= $product->getId() ?>"
                ></i>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
