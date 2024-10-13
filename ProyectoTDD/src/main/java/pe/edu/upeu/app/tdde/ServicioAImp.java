package pe.edu.upeu.app.tdde;

import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class ServicioAImp implements ServicioA {

    @Override
    public int sumar(int a, int b) {
        return a+b;
    }

    @Override
    public boolean validarClave(String clave) {
        //if(clave.length()>8){return false;}

        Pattern p= Pattern.compile("^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()])[A-Za-z\\d!@#$%^&*()]{8,}$");
        Matcher m= p.matcher(clave);
        return m.matches();
    }
}
