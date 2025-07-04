package com.exemplo.freteapi.service;

import com.exemplo.freteapi.dto.FreteRequest;
import com.exemplo.freteapi.dto.FreteResponse;

public class CalculadoraFrete {

    public static FreteResponse calcular(FreteRequest request) {
        double distancia = request.getDistancia();
        int quantidade = request.getQuantidade();

        String veiculo;
        double precoPorKm;
        double taxaFixa;

        if (quantidade <= 250) {
            veiculo = "Caminhão";
            precoPorKm = 20.0;
            taxaFixa = 200.0;
        } else {
            veiculo = "Carreta";
            precoPorKm = 40.0;
            taxaFixa = 400.0;
        }

        double precoKmTotal;
        if (distancia <= 100) {
            precoKmTotal = distancia * precoPorKm;
        } else {
            precoKmTotal = 100 * precoPorKm + (distancia - 100) * precoPorKm * 0.8;
        }

        double custoTotal = precoKmTotal + taxaFixa;

        return new FreteResponse(veiculo, custoTotal);
    }
}
