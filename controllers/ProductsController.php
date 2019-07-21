<?php

namespace app\controllers;

use app\models\Product;

class ProductsController extends Controller {

    public function actionIndex() {
        $products = Product::findAll();
        return $this->render('index', [
            'products' => $products
        ]);
    }

    public function actionView($id) {
        if (!is_null($id) && is_numeric($id)) {
            $product = Product::find($id);
            if ($product) {
                return $this->render('view', [
                    'product' => $product
                ]);
            }
        }
        return $this->notFound();
    }

    public function actionDelete(int $id) {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
        }
        $this->redirect('index');
    }
}
