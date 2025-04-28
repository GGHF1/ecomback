<?php

namespace App\Schema;

use App\Model\Attribute\Attribute;
use App\Model\Attribute\AttributeSet;
use App\Model\Category\Category;
use App\Model\Currency\Currency;
use App\Model\Price\Price;
use App\Model\Product\Product;
use App\Schema\Resolvers\AttributeResolver;
use App\Schema\Resolvers\CategoryResolver;
use App\Schema\Resolvers\ProductResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class Types
{
    private static ?ObjectType $categoryType = null;
    private static ?ObjectType $productType = null;
    private static ?ObjectType $attributeSetType = null;
    private static ?ObjectType $attributeType = null;
    private static ?ObjectType $priceType = null;
    private static ?ObjectType $currencyType = null;
    private static ?ObjectType $productGalleryType = null;

    public static function category(): ObjectType
    {
        return self::$categoryType ??= new ObjectType([
            'name' => 'Category',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'name' => Type::nonNull(Type::string()),
                'products' => [
                    'type' => Type::listOf(self::product()),
                    'resolve' => [CategoryResolver::class, 'resolveProducts'],
                ],
            ],
        ]);
    }

    public static function product(): ObjectType
    {
        return self::$productType ??= new ObjectType([
            'name' => 'Product',
            'fields' => [
                'id' => Type::string(),
                'name' => Type::string(),
                'inStock' => Type::boolean(),
                'description' => Type::string(),
                'category' => Type::string(),
                'brand' => Type::string(),
                'gallery' => Type::listOf(Type::string()),
                'prices' => Type::listOf(self::price()),
                'attributeSets' => Type::listOf(self::attributeSet()),
            ],
        ]);
    }

    public static function attributeSet(): ObjectType
    {
        return self::$attributeSetType ??= new ObjectType([
            'name' => 'AttributeSet',
            'fields' => [
                'id' => Type::nonNull(Type::string()),
                'name' => Type::nonNull(Type::string()),
                'type' => Type::nonNull(Type::string()),
                'type_name' => Type::nonNull(Type::string()),
                'attributes' => [
                    'type' => Type::listOf(self::attribute()),
                    'resolve' => [AttributeResolver::class, 'resolveAttributes'],
                ],
            ],
        ]);
    }

    public static function attribute(): ObjectType
    {
        return self::$attributeType ??= new ObjectType([
            'name' => 'Attribute',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'attribute_set_id' => Type::nonNull(Type::string()),
                'display_value' => Type::nonNull(Type::string()),
                'value' => Type::nonNull(Type::string()),
                'item_id' => Type::nonNull(Type::string()),
                'type_name' => Type::nonNull(Type::string()),
            ],
        ]);
    }

    public static function price(): ObjectType
    {
        return self::$priceType ??= new ObjectType([
            'name' => 'Price',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'product_id' => Type::nonNull(Type::string()),
                'amount' => Type::nonNull(Type::float()),
                'currency' => Type::nonNull(self::currency()),
            ],
        ]);
    }

    public static function currency(): ObjectType
    {
        return self::$currencyType ??= new ObjectType([
            'name' => 'Currency',
            'fields' => [
                'label' => Type::nonNull(Type::string()),
                'symbol' => Type::nonNull(Type::string()),
            ],
        ]);
    }

    public static function productGallery(): ObjectType
    {
        return self::$productGalleryType ??= new ObjectType([
            'name' => 'ProductGallery',
            'fields' => [
                'id' => Type::nonNull(Type::int()),
                'product_id' => Type::nonNull(Type::string()),
                'image_url' => Type::nonNull(Type::string()),
            ],
        ]);
    }
}