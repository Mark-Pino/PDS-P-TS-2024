/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package pe.edu.upeu.asistencia.controllers;

import java.util.List;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import lombok.extern.slf4j.Slf4j;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;
import pe.edu.upeu.asistencia.models.Inscrito;
import pe.edu.upeu.asistencia.services.InscritoService;

/**
 *
 * @author DELL
 */

@Slf4j
@RestController
@RequestMapping("/asis/inscrito")
public class InscritoController {

    @Autowired
    private InscritoService inscritoService;

    @GetMapping(value = "/list")
    public ResponseEntity<List<Inscrito>> listActividad() {
        List<Inscrito> actDto = inscritoService.findAll();

        log.info("Ver Aqui: {}", actDto.get(0).getTipoCui());  // Reemplaza System.out.println
        log.info("Ver Aquix: {}", actDto.get(0).getActividadId().getNombreActividad());  // Reemplaza System.out.println

        return ResponseEntity.ok().body(actDto);
    }
}
