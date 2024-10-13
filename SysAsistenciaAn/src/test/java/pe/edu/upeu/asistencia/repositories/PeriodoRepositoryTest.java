package pe.edu.upeu.asistencia.repositories;

import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.Order;
import org.junit.jupiter.api.Test;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.jdbc.AutoConfigureTestDatabase;
import org.springframework.boot.test.autoconfigure.orm.jpa.DataJpaTest;
import org.springframework.boot.test.autoconfigure.orm.jpa.TestEntityManager;
import pe.edu.upeu.asistencia.models.Periodo;

import java.util.List;
@AutoConfigureTestDatabase(replace = AutoConfigureTestDatabase.Replace.NONE)
@DataJpaTest
public class PeriodoRepositoryTest {

    @Autowired
    private PeriodoRepository periodoRepository;

    @Autowired
    private TestEntityManager entityManager;

    @BeforeEach
    public void setUp() {
        System.out.println("Primer paso");
        Periodo periodo = new Periodo();
        periodo.setNombre("2024-1");
        periodo.setEstado("Activo");
        periodoRepository.save(periodo);
        entityManager.persist(periodo);
    }

    @Order(1)
    @Test
    public void testFindById() {
        System.out.println("Primera Prueba");
        Long id = periodoRepository.maxID().get();
        Periodo periodo = periodoRepository.findById(id).get();
        Assertions.assertEquals("2024-1", periodo.getNombre());
    }

    @Order(2)
    @Test
    public void testByName() {
        Periodo periodo = periodoRepository.findByNombre("2024-1").get();
        Assertions.assertEquals("2024-1", periodo.getNombre());
    }

    @Order(3)
    @Test
    public void createPeriodo() {
        Periodo periodo = new Periodo();
        periodo.setNombre("2024-2");
        periodo.setEstado("Activo");
        periodoRepository.save(periodo);
        entityManager.persist(periodo);
        Assertions.assertEquals("2024-2", periodo.getNombre());
    }

    @Order(4)
    @Test
    public void listaPeriodo() {
        List<Periodo> periodos = periodoRepository.findAll();
        System.out.println(periodos.size());
        System.out.println("ID:"+periodos.get(0).getId());
        Assertions.assertEquals(periodos.size(),1);
    }

    @Order(6)
    @Test
    public void testDeletePeriodo() {
        Long id = periodoRepository.maxID().get();
        periodoRepository.deleteById(id);
        Periodo periodo = periodoRepository.findById(id).isPresent() ?
                periodoRepository.findById(id).get() : null;
        Assertions.assertNull(periodo);
    }

    @Order(5)
    @Test
    public void testUpdatePeriodo() {
        Long id = periodoRepository.maxID().get();
        Periodo periodo =periodoRepository.findById(id).get();
        periodo.setEstado("Desactivo");
        periodoRepository.save(periodo);
        Periodo px=entityManager.persist(periodo);
        Assertions.assertEquals("Desactivo", px.getEstado());
    }
}
