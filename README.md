# 📦 Sistema de Venda e Entrega de Tomates – Mashup com GraphQL e REST

Este projeto é composto por **três serviços integrados**, usando GraphQL com PHP e REST com Spring Boot, para simular a venda de caixas de tomates e cálculo de frete, com regras comerciais aplicadas em um mashup.

Esse projeto foi desenvolvido pelo aluno Pedro Collares Xavier, que optou por fazer sozinho

## 🔧 Tecnologias usadas

- **PHP + GraphQL (web3)** → Serviço 1: Preço do Tomate
- **Java + Spring Boot (frete-api)** → Serviço 2: Cálculo de Frete (REST)
- **PHP + GraphQL (web3)** → Serviço 3: Mashup Final (venda com frete, lucro, descontos, impostos)

## 🚀 Como Rodar os Serviços

### 1. Serviço 1 – GraphQL Tomate (PHP)
Arquivo: `preco.php`

#### Como rodar:
Deve estar na pasta htdocs do xampp ou outro servidor equivalente

#### Endpoint:
http://localhost:8000](http://localhost/web3/tomate-graphql/index.php

#### Exemplo de requisição GraphQL:
curl -X POST http://localhost/web3/tomate-graphql/index.php ^
  -H "Content-Type: application/json" ^
  -d "{\"query\": \"{ precoTomate(quantidade: 15) }\"}"

#### Exemplo de resposta:
```json
{"data":{"precoTomate":712.5}}
```

---

### 2. Serviço 2 – REST Frete (Spring Boot)

#### Como rodar no Eclipse:
- Executar a classe `FreteApiApplication.java`
- Porta padrão: `8080`

#### Endpoint:
POST http://localhost:8080/frete

#### Exemplo de requisição (CMD):
```cmd
curl -X POST http://localhost:8080/frete -H "Content-Type: application/json" -d "{\"distancia\":120,\"quantidade\":300}"
```

#### Exemplo de resposta:
```json
{
  "veiculo": "Carreta",
  "custoTotal": 5040.0
}
```

---

### 3. Serviço 3 – Mashup Final (PHP + GraphQL)

Arquivo: `mashup.php`  
Local: http://localhost/web3/tomate-graphql/mashup.php

#### Endpoint:
http://localhost/web3/tomate-graphql/mashup.php

#### Requisição via CMD:
```cmd
curl -X POST http://localhost/web3/tomate-graphql/mashup.php -H "Content-Type: application/json" -d "{\"query\":\"query { vendaTomates(quantidade: 350, distancia: 120) }\"}"
```

#### Exemplo de resposta:
```json
{"data":{"vendaTomates":32376.31}}
```

---

## 📊 Regras Comerciais Aplicadas no Mashup

- Lucro fixo de **+55%** sobre (tomate + frete)
- Desconto por volume:
  - **7,5%** se quantidade > 50 caixas
  - **12%** se quantidade > 300 caixas
- Imposto de **27%** sobre o valor final (após lucro e desconto)


## ✅ Teste Rápido do Mashup

```cmd
curl -X POST http://localhost/web3/tomate-graphql/mashup.php -H "Content-Type: application/json" -d "{\"query\":\"query { vendaTomates(quantidade: 100, distancia: 80) }\"}"
```

---

## 📌 Requisitos

- PHP ≥ 7.4
- Composer com `webonyx/graphql-php`
- Java 17
- Spring Boot (com Maven)

