<?php

namespace app\controllers;

use app\models\entities\Product;
use app\models\repositories\ProductRepository;

class ProductsController extends Controller {

    const PRODUCTS = 'products';

    public function actionIndex() {
        $products = (new ProductRepository)->findAll();
        return $this->render('index', [
            'products' => $products,
        ]);
    }

    public function actionView($id) {
        if (!is_null($id) && is_numeric($id)) {
            $product = (new ProductRepository)->find($id);
            if ($product) {
                return $this->render('view', [
                    'product' => $product,
                ]);
            }
        }
        return $this->notFound();
    }

    public function actionDelete(int $id) {
        $repository = new ProductRepository();
        $product = $repository->find($id);
        if ($product) {
            $repository->delete($product);
        }
        return $this->returnToLastPage();
    }

    public function actionBuy(int $id) {
        $repository = new ProductRepository();
        /** @var $product Product */
        $product = $repository->find($id);
        if (!$product) {
            return $this->returnToLastPage();
        }
        $products = $this->session->get(self::PRODUCTS);

        if (!isset($products[$id])) {
            $products[$id] = [
              'count' => 1,
              'id' => $product->getId(),
              'name' => $product->name,
              'price' => $product->price,
              'brand' => $product->brand,
              'material' => $product->material,
              'desc' => $product->desc,
              'photo' => $product->photo
            ];
        } else {
            $products[$id]['count']++;
        }

        $this->session->add([
            self::PRODUCTS => $products
        ]);
        return $this->returnToLastPage();
    }
}
