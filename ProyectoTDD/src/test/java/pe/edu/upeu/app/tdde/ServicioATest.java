package pe.edu.upeu.app.tdde;

import org.junit.jupiter.api.Assertions;
import org.junit.jupiter.api.Test;
import org.springframework.util.Assert;

public class ServicioATest {


    @Test
   void testSuma() { //TDD
        int a=2; int b=3;
        ServicioA sa=new ServicioAImp();
        Assertions.assertEquals(sa.sumar(a,b),5);
   }

   //Casos de Pruebas
    @Test
   void valiarClaves(){
        String clave="D@vidmp1";
        ServicioA sa=new ServicioAImp();
        Assertions.assertEquals(sa.validarClave(clave), true);

   }

    @Test
    void valiarClavesSinMayuscula(){
        String clave="d@vidmpp";
        ServicioA sa=new ServicioAImp();
        Assertions.assertEquals(sa.validarClave(clave), true);

    }

    @Test
    void valiarClavesSinMinisculas(){
        String clave="DAVIDMP@ppp";
        ServicioA sa=new ServicioAImp();
        Assertions.assertEquals(sa.validarClave(clave), true);

    }


}
