<?php
require 'vendor/autoload.php';

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;

define('GRAPHQL_TOMATE_URL', 'http://localhost/web3/tomate-graphql/index.php'); // serviço 1
define('REST_FRETE_URL', 'http://localhost:8080/frete'); // serviço 2

function consultarPrecoTomate($quantidade) {
    $query = json_encode([
        'query' => 'query { precoTomate(quantidade: ' . $quantidade . ') }'
    ]);

    $opts = ['http' =>
        [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n",
            'content' => $query
        ]
    ];

    $context = stream_context_create($opts);
    $result = file_get_contents(GRAPHQL_TOMATE_URL, false, $context);
    $data = json_decode($result, true);

    return $data['data']['precoTomate'] ?? 0;
}

function consultarFrete($quantidade, $distancia) {
    $payload = json_encode([
        'quantidade' => $quantidade,
        'distancia' => $distancia
    ]);

    $opts = ['http' =>
        [
            'method'  => 'POST',
            'header'  => "Content-Type: application/json\r\n",
            'content' => $payload
        ]
    ];

    $context = stream_context_create($opts);
    $result = file_get_contents(REST_FRETE_URL, false, $context);
    $data = json_decode($result, true);

    return $data['custoTotal'] ?? 0;
}

$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'vendaTomates' => [
            'type' => Type::float(),
            'args' => [
                'quantidade' => Type::nonNull(Type::int()),
                'distancia' => Type::nonNull(Type::float()),
            ],
            'resolve' => function ($root, $args) {
                $quantidade = $args['quantidade'];
                $distancia = $args['distancia'];

                $precoTomate = consultarPrecoTomate($quantidade);
                $frete = consultarFrete($quantidade, $distancia);

                $custoTotal = $precoTomate + $frete;

                $lucro = $custoTotal * 0.55;
                $valorComLucro = $custoTotal + $lucro;

                // Desconto por volume
                $desconto = 0;
                if ($quantidade > 300) {
                    $desconto = 0.12;
                } elseif ($quantidade > 50) {
                    $desconto = 0.075;
                }

                $valorComDesconto = $valorComLucro * (1 - $desconto);

                // Imposto de 27%
                $valorFinal = $valorComDesconto * 1.27;

                return round($valorFinal, 2);
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
