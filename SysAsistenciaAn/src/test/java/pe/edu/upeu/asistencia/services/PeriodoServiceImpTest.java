package pe.edu.upeu.asistencia.services;

import org.assertj.core.api.Assertions;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.DisplayName;
import org.junit.jupiter.api.Order;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.extension.ExtendWith;
import org.mockito.InjectMocks;
import org.mockito.Mock;
import org.mockito.junit.jupiter.MockitoExtension;
import pe.edu.upeu.asistencia.models.Periodo;
import pe.edu.upeu.asistencia.repositories.PeriodoRepository;

import java.util.List;
import java.util.Map;
import java.util.Optional;

import static org.mockito.BDDMockito.*;

@ExtendWith(MockitoExtension.class)
public class PeriodoServiceImpTest {

    @Mock
    private PeriodoRepository repo;
    @InjectMocks
    private PeriodoServiceImp periodoService;

    Periodo periodo;

    @BeforeEach
    public void setUp() {
        periodo = Periodo.builder()
                .id(1L)
                .nombre("2025-1")
                .estado("Desactivo")
                .build();
    }

    @Order(1)
    @DisplayName("GuardarPeriodo")
    @Test
    public void testSavePeriodo() {
        //given
        given(repo.save(periodo)).willReturn(periodo);
        //when
        Periodo ppx=periodoService.save(periodo);
        //then
        Assertions.assertThat(ppx.getNombre()).isNotNull();
        Assertions.assertThat(ppx.getNombre()).isEqualTo(periodo.getNombre());
    }

    @Order(2)
    @DisplayName("Listar Periodo")
    @Test
    public void testListPeriodo() {
        //given
        Periodo p=Periodo.builder()
                .id(2L)
                .nombre("2025-2")
                .estado("Desactivo")
                .build();
        given(repo.findAll()).willReturn(List.of(periodo,p));
        //when
        List<Periodo> pl=periodoService.findAll();
        for (Periodo pr:pl){
            System.out.println(pr.getNombre()+" "+pr.getEstado());
        }
        //then
        Assertions.assertThat(pl).hasSize(2);
        Assertions.assertThat(pl.get(0)).isEqualTo(periodo);
        Assertions.assertThat(pl.size()).isEqualTo(2);
    }

    @Order(3)
    @DisplayName("Actualizar Periodo")
    @Test
    public void testUpdatePeriodo() {
        //given
        given(repo.save(periodo)).willReturn(periodo);
        given(repo.findById(1L)).willReturn(Optional.of(periodo));
        //when
        periodo.setEstado("Activo");
        Periodo pa=periodoService.update(periodo, periodo.getId());
        //then
        System.out.println(pa.getEstado()+" "+pa.getNombre());
        Assertions.assertThat(pa.getEstado()).isEqualTo("Activo");

    }

    @Order(4)
    @DisplayName("Eliminar Periodo")
    @Test
    public void testDeletePeriodo() {
        //given
        given(repo.findById(1L)).willReturn(Optional.of(periodo));
        //when
        Map<String, Boolean> pd=periodoService.delete(1L);
        //then
        System.out.println(pd.get("deleted"));

        Assertions.assertThat(pd.get("deleted")).isTrue();
    }

}
