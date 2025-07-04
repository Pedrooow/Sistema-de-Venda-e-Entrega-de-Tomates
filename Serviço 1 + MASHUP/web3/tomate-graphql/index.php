<?php
require 'vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

define('PRECO_CAIXA', 50.00);

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'precoTomate' => [
            'type' => Type::float(),
            'args' => [
                'quantidade' => Type::nonNull(Type::int()),
            ],
            'resolve' => function ($root, $args) {
                $qtd = $args['quantidade'];
                $desconto = 0;
                if ($qtd >= 30) $desconto = 0.22;
                elseif ($qtd >= 20) $desconto = 0.11;
                elseif ($qtd >= 10) $desconto = 0.05;

                $preco = PRECO_CAIXA * $qtd * (1 - $desconto);
                return $preco;
            }
        ]
    ],
]);

$schema = new Schema([
    'query' => $queryType
]);

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'] ?? '';

try {
    $result = GraphQL::executeQuery($schema, $query);
    $output = $result->toArray();
} catch (Throwable $e) {
    $output = ['error' => $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($output);
