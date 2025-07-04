package com.exemplo.freteapi.controller;

import com.exemplo.freteapi.dto.FreteRequest;
import com.exemplo.freteapi.dto.FreteResponse;
import com.exemplo.freteapi.service.CalculadoraFrete;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/frete")
public class FreteController {

    @PostMapping
    public ResponseEntity<FreteResponse> calcularFrete(@RequestBody FreteRequest request) {
        FreteResponse resposta = CalculadoraFrete.calcular(request);
        return ResponseEntity.ok(resposta);
    }
}
