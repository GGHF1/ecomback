<?php

namespace App\Schema\Resolvers;

use App\Database\DatabaseConnection;
use App\Model\Product\ProductGallery;

class ProductGalleryResolver
{
    /**
     * Resolve all product gallery items
     */
    public static function resolveAllProductGallery(): array
    {
        $em = DatabaseConnection::getEntityManager();
        $galleryItems = $em->getRepository(ProductGallery::class)->findAll();
        
        return array_map(function (ProductGallery $item) {
            return [
                'id' => $item->getId(),
                'product_id' => $item->getProduct() ? $item->getProduct()->getId() : null,
                'image_url' => $item->getImageUrl(),
            ];
        }, $galleryItems);
    }
    
    /**
     * Resolve a single gallery item by ID
     */
    public static function resolveProductGalleryById($root, array $args): ?array
    {
        if (!isset($args['id'])) {
            return null;
        }
        
        $em = DatabaseConnection::getEntityManager();
        $galleryItem = $em->getRepository(ProductGallery::class)->find($args['id']);
        
        if (!$galleryItem) {
            return null;
        }
        
        return [
            'id' => $galleryItem->getId(),
            'product_id' => $galleryItem->getProduct() ? $galleryItem->getProduct()->getId() : null,
            'image_url' => $galleryItem->getImageUrl(),
        ];
    }
    
    /**
     * Resolve gallery items for a specific product
     */
    public static function resolveProductGalleryByProductId($root, array $args): array
    {
        if (!isset($args['product_id'])) {
            return [];
        }
        
        $em = DatabaseConnection::getEntityManager();
        $galleryItems = $em->getRepository(ProductGallery::class)->findBy(['product' => $args['product_id']]);
        
        return array_map(function (ProductGallery $item) {
            return [
                'id' => $item->getId(),
                'product_id' => $item->getProduct() ? $item->getProduct()->getId() : null,
                'image_url' => $item->getImageUrl(),
            ];
        }, $galleryItems);
    }
}