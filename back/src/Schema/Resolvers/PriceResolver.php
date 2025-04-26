<?php

namespace App\Schema\Resolvers;

use App\Database\DatabaseConnection;
use App\Model\Price\Price;

class PriceResolver
{
    public static function resolveAllPrices(): array
    {
        $em = DatabaseConnection::getEntityManager();
        $prices = $em->getRepository(Price::class)->findAll();
        
        return array_map(function($price) {
            return [
                'id' => $price->getId(),
                'product_id' => $price->getProduct()->getId(),
                'amount' => $price->getAmount(),
                'currency' => [
                    'label' => $price->getCurrency()->getLabel(),
                    'symbol' => $price->getCurrency()->getSymbol(),
                ],
            ];
        }, $prices);
    }

    public static function resolvePriceById($root, array $args): ?array
    {
        $em = DatabaseConnection::getEntityManager();
        $price = $em->getRepository(Price::class)->find($args['id']);
        
        if (!$price) {
            return null;
        }
        
        return [
            'id' => $price->getId(),
            'product_id' => $price->getProduct()->getId(),
            'amount' => $price->getAmount(),
            'currency' => [
                'label' => $price->getCurrency()->getLabel(),
                'symbol' => $price->getCurrency()->getSymbol(),
            ],
        ];
    }
}