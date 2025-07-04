package com.exemplo.freteapi.dto;

public class FreteResponse {
    private String veiculo;
    private double custoTotal;

    public FreteResponse(String veiculo, double custoTotal) {
        this.veiculo = veiculo;
        this.custoTotal = custoTotal;
    }

    public String getVeiculo() {
        return veiculo;
    }

    public void setVeiculo(String veiculo) {
        this.veiculo = veiculo;
    }

    public double getCustoTotal() {
        return custoTotal;
    }

    public void setCustoTotal(double custoTotal) {
        this.custoTotal = custoTotal;
    }
}
