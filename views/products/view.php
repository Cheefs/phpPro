<?php
/* @var $this \app\controllers\Controller */
/* @var $product \app\models\Product */
?>

<div>
    <nav class="nav">
        <a class="nav__btn" href="/"> <?= Translate::t('ru', 'home')?> </a>
        <a class="nav__btn" href="?c=<?= $this->getControllerName() ?>&a=index">
            <?= Translate::t('ru', 'back')?>
        </a>
    </nav>

    <div class="flex">
        <img src="/assets/<?= $product->photo ?>" alt="product-photo">
    </div>

    <div>
        <h3 class="text_center text_bold"><?= $product->name ?></h3>
        <p class="text_center"><?= $product->desc ?></p>
        <div class="text_center text_bold">
            <span>
                <?= Translate::t('ru', 'material')?>:
            </span>
            <span class="text_marked"><?= $product->material?></span>
        </div>
        <div class="text_center text_bold">
            <span>
                <?= Translate::t('ru', 'branc')?>
            </span>
            <span class="text_marked"><?= $product->brand?></span>
        </div>
        <div class="text_center text_bold">
            <span>
                <?= Translate::t('ru', 'price')?>
            </span>
            <span class="text_marked"><?= $product->price ?></span>
        </div>
    </div>
</div>
