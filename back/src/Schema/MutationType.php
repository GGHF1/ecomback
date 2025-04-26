<?php

namespace App\Schema;

use App\Schema\Resolvers\OrderResolver;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;

class MutationType extends ObjectType
{
    public function __construct()
    {
        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'createOrder' => [
                    'type' => Types::order(),
                    'args' => [
                        'productIds' => Type::nonNull(Type::listOf(Type::string())),
                    ],
                    'resolve' => [OrderResolver::class, 'resolveCreateOrder'],
                ],
            ],
        ]);
    }
}