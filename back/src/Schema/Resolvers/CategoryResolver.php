<?php

namespace App\Schema\Resolvers;

use App\Database\DatabaseConnection;
use App\Model\Category\Category;

class CategoryResolver
{
    public static function resolveCategories(): array
    {
        $em = DatabaseConnection::getEntityManager();
        $categories = $em->getRepository(Category::class)->findAll();
        
        return array_map(function($category) {
            return [
                'id' => (int)$category->getId(), 
                'name' => $category->getName()
            ];
        }, $categories);
    }

    public static function resolveCategory($root, array $args): ?array
    {
        $em = DatabaseConnection::getEntityManager();
        $category = $em->getRepository(Category::class)->find($args['id']);
        
        if (!$category) {
            return null;
        }
        
        return [
            'id' => (int)$category->getId(),
            'name' => $category->getName()
        ];
    }

    public static function resolveProducts(array $category): array
    {
        $em = DatabaseConnection::getEntityManager();
        $products = $em->getRepository('App\Model\Product\Product')->findBy(['category' => $category['name']]);
        
        return array_map(function($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'inStock' => $product->getInStock(),
                'description' => $product->getDescription(),
                'category' => $product->getCategory(),
                'brand' => $product->getBrand(),
                'gallery' => $product->getGallery()->map(function($item) {
                    return $item->getImageUrl();
                })->toArray()
            ];
        }, $products);
    }
}