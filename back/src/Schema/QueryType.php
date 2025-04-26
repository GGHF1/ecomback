<?php

namespace App\Schema;

use App\Schema\Resolvers\AttributeResolver;
use App\Schema\Resolvers\CategoryResolver;
use App\Schema\Resolvers\ProductResolver;
use App\Schema\Resolvers\ProductGalleryResolver;
use App\Schema\Resolvers\PriceResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class QueryType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'categories' => [
                    'type' => Type::listOf(Types::category()),
                    'resolve' => [CategoryResolver::class, 'resolveCategories'],
                ],
                'category' => [
                    'type' => Types::category(),
                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],
                    'resolve' => [CategoryResolver::class, 'resolveCategory'],
                ],
                'products' => [
                    'type' => Type::listOf(Types::product()),
                    'resolve' => [ProductResolver::class, 'resolveProducts'],
                ],
                'product' => [
                    'type' => Types::product(),
                    'args' => [
                        'id' => Type::nonNull(Type::string()),
                    ],
                    'resolve' => [ProductResolver::class, 'resolveProduct'],
                ],
                'attributes' => [
                    'type' => Type::listOf(Types::attribute()),
                    'resolve' => [AttributeResolver::class, 'resolveAllAttributes'],
                ],
                'attributeSets' => [
                    'type' => Type::listOf(Types::attributeSet()),
                    'resolve' => [AttributeResolver::class, 'resolveAllAttributeSets'],
                ],
                'product_gallery' => [
                    'type' => Type::listOf(Types::productGallery()),
                    'resolve' => [ProductGalleryResolver::class, 'resolveAllProductGallery'],
                ],
                'product_gallery_item' => [
                    'type' => Types::productGallery(),
                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],
                    'resolve' => [ProductGalleryResolver::class, 'resolveProductGalleryById'],
                ],
                'prices' => [
                    'type' => Type::listOf(Types::price()),
                    'resolve' => [PriceResolver::class, 'resolveAllPrices'],
                ],
                'price' => [
                    'type' => Types::price(),
                    'args' => [
                        'id' => Type::nonNull(Type::int()),
                    ],
                    'resolve' => [PriceResolver::class, 'resolvePriceById'],
                ],
            ],
        ]);
    }
}