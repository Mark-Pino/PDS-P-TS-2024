package pe.edu.upeu.asistencia.controller;

import org.assertj.core.api.BDDAssumptions;
import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.extension.ExtendWith;
import org.mockito.BDDMockito;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.jupiter.MockitoExtension;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import pe.edu.upeu.asistencia.controllers.PeriodoController;
import pe.edu.upeu.asistencia.dtos.PeriodoDto;
import pe.edu.upeu.asistencia.models.Periodo;
import pe.edu.upeu.asistencia.services.PeriodoService;
import pe.edu.upeu.asistencia.services.PeriodoServiceImp;

import java.util.List;

@ExtendWith(MockitoExtension.class)
public class PeriodoControllerTest {
    @Mock
    private PeriodoServiceImp periodoService;

    @InjectMocks
    private PeriodoController periodoController;

    Periodo periodo;
    List<Periodo> periodos;
    PeriodoDto.PeriodoCrearDto periodoCrearDto;

    @BeforeEach
    public void setUp() {
        periodo = Periodo.builder()
                .id(1L)
                .nombre("2024-1")
                .estado("Activo")
                .build();
        periodos = List.of(periodo,
                Periodo.builder()
                        .id(2L)
                        .nombre("2024-2")
                        .estado("Desactivo")
                        .build()
                );
    }

    @Test
    public void listarPeriodo() {
        //given
        BDDMockito.given(periodoService.findAll()).willReturn(periodos);
        //when
        ResponseEntity<List<Periodo>> lp=periodoController.listPeriodo();
        //then
        Assertions.assertEquals(lp.getStatusCode(), HttpStatus.OK);
        for (Periodo p : lp.getBody()) {
            System.out.println(p.getNombre() + " " + p.getEstado());
        }
        Assertions.assertEquals(periodos,lp.getBody());
    }

    @Test
    public void crearPeriodo() {

    }


}
