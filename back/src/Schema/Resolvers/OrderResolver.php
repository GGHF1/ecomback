<?php

namespace App\Schema\Resolvers;

use App\Database\DatabaseConnection;
use App\Model\Order\Order;
use App\Model\Product\Product;

class OrderResolver
{
    public static function resolveCreateOrder($root, array $args): Order
    {
        $em = DatabaseConnection::getEntityManager();
        $order = new Order();

        foreach ($args['productIds'] as $productId) {
            $product = $em->getRepository(Product::class)->find($productId);
            if ($product) {
                $order->addProduct($product);
            }
        }

        $em->persist($order);
        $em->flush();

        return $order;
    }
}