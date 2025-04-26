<?php

namespace App\Schema\Resolvers;

use App\Database\DatabaseConnection;
use App\Model\Attribute\AbstractAttribute;
use App\Model\Attribute\AbstractAttributeSet;
use App\Model\Attribute\AttributeSet;

class AttributeResolver
{
    public static function resolveAttributes($attributeSet): array
    {
        // $attributeSet is the parent AttributeSet object or array from ProductResolver
        if (is_array($attributeSet)) {
            $em = DatabaseConnection::getEntityManager();
            $attributes = $em->getRepository(AbstractAttribute::class)->findBy(['attributeSet' => $attributeSet['id']]);
        } else {
            $attributes = $attributeSet->getAttributes()->toArray();
        }

        return array_map(function ($attribute) {
            return [
                'id' => $attribute->getId(),
                'attribute_set_id' => $attribute->getAttributeSet()->getId(),
                'display_value' => $attribute->getDisplayValue(),
                'value' => $attribute->getValue(),
                'item_id' => $attribute->getItemId(),
                'type_name' => $attribute->getTypeName(),
            ];
        }, $attributes);
    }

    public static function resolveAllAttributes(): array
    {
        $em = DatabaseConnection::getEntityManager();
        $attributes = $em->getRepository(AbstractAttribute::class)->findAll();

        return array_map(function ($attribute) {
            $attributeSetId = null;
            try {
                if ($attribute->getAttributeSet() !== null) {
                    $attributeSetId = $attribute->getAttributeSet()->getId();
                }
            } catch (\Exception $e) {
                error_log('Error getting attribute set ID: ' . $e->getMessage());
            }
            return [
                'id' => $attribute->getId(),
                'attribute_set_id' => $attributeSetId,
                'display_value' => $attribute->getDisplayValue(),
                'value' => $attribute->getValue(),
                'item_id' => $attribute->getItemId(),
                'type_name' => $attribute->getTypeName(),
            ];
        }, $attributes);
    }

    public static function resolveAllAttributeSets(): array
    {
        $em = DatabaseConnection::getEntityManager();
        $attributeSets = $em->getRepository(AbstractAttributeSet::class)->findAll();

        return array_map(function ($attributeSet) {
            return [
                'id' => $attributeSet->getId(),
                'name' => $attributeSet->getName(),
                'type' => $attributeSet->getType(),
                'type_name' => $attributeSet->getTypeName(),
            ];
        }, $attributeSets);
    }
}