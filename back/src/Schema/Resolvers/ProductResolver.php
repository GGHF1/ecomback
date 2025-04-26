<?php

namespace App\Schema\Resolvers;

use App\Database\DatabaseConnection;
use App\Model\Product\Product;
use App\Model\Price\Price;

class ProductResolver
{
    public static function resolveProducts(): array
    {
        $em = DatabaseConnection::getEntityManager();
        $products = $em->getRepository(Product::class)->findAll();

        return array_map(function ($product) use ($em) {
            $prices = $em->getRepository(Price::class)->findBy(['product' => $product]);
            $pricesData = array_map(function ($price) {
                $currency = $price->getCurrency();
                return [
                    'id' => $price->getId(),
                    'amount' => $price->getAmount(),
                    'currency' => [
                        'label' => $currency->getLabel(),
                        'symbol' => $currency->getSymbol(),
                    ],
                ];
            }, $prices);

            $attributeSetsData = array_map(function ($attributeSet) {
                return [
                    'id' => $attributeSet->getId(),
                    'name' => $attributeSet->getName(),
                    'type' => $attributeSet->getType(),
                    'type_name' => $attributeSet->getTypeName(),
                ];
            }, $product->getAttributeSets()->toArray());

            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'inStock' => $product->getInStock(),
                'description' => $product->getDescription(),
                'category' => $product->getCategory(),
                'brand' => $product->getBrand(),
                'gallery' => $product->getGallery()->map(function ($item) {
                    return $item->getImageUrl();
                })->toArray(),
                'prices' => $pricesData,
                'attributeSets' => $attributeSetsData,
            ];
        }, $products);
    }

    public static function resolveProduct($root, array $args): ?array
    {
        $em = DatabaseConnection::getEntityManager();
        $product = $em->getRepository(Product::class)->find($args['id']);

        if (!$product) {
            return null;
        }

        $prices = $em->getRepository(Price::class)->findBy(['product' => $product]);
        $pricesData = array_map(function ($price) {
            $currency = $price->getCurrency();
            return [
                'id' => $price->getId(),
                'amount' => $price->getAmount(),
                'currency' => [
                    'label' => $currency->getLabel(),
                    'symbol' => $currency->getSymbol(),
                ],
            ];
        }, $prices);

        $attributeSetsData = array_map(function ($attributeSet) {
            return [
                'id' => $attributeSet->getId(),
                'name' => $attributeSet->getName(),
                'type' => $attributeSet->getType(),
                'type_name' => $attributeSet->getTypeName(),
            ];
        }, $product->getAttributeSets()->toArray());

        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'inStock' => $product->getInStock(),
            'description' => $product->getDescription(),
            'category' => $product->getCategory(),
            'brand' => $product->getBrand(),
            'gallery' => $product->getGallery()->map(function ($item) {
                return $item->getImageUrl();
            })->toArray(),
            'prices' => $pricesData,
            'attributeSets' => $attributeSetsData,
        ];
    }
}