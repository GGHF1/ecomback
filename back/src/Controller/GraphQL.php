<?php

namespace App\Controller;

use App\Schema\MutationType;
use App\Schema\QueryType;
use GraphQL\GraphQL as GraphQLBase;
use GraphQL\Type\Schema;
use GraphQL\Type\SchemaConfig;
use GraphQL\Error\DebugFlag;
use RuntimeException;
use Throwable;

class GraphQL
{
    public static function handle()
    {
        try {
            $schema = new Schema(
                (new SchemaConfig())
                    ->setQuery(new QueryType())
                    ->setMutation(new MutationType())
            );

            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to get php://input');
            }

            $input = json_decode($rawInput, true);
            file_put_contents('debug.log', 'Raw Input: ' . $rawInput . PHP_EOL, FILE_APPEND);
            file_put_contents('debug.log', 'Parsed Query: ' . ($input['query'] ?? 'No query') . PHP_EOL, FILE_APPEND);

            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            $result = GraphQLBase::executeQuery($schema, $query, null, null, $variableValues);
            $output = $result->toArray(DebugFlag::INCLUDE_DEBUG_MESSAGE | DebugFlag::INCLUDE_TRACE);
        } catch (Throwable $e) {
            $errorMessage = 'Error: ' . $e->getMessage() . PHP_EOL . 'Stack Trace: ' . $e->getTraceAsString() . PHP_EOL;
            file_put_contents('debug.log', $errorMessage, FILE_APPEND);
            $output = [
                'errors' => [
                    [
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]
                ]
            ];
        }

        header('Content-Type: application/json; charset=UTF-8');
        return json_encode($output);
    }
}