/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/UnitTests/JUnit5TestClass.java to edit this template
 */
package pe.edu.upeu.asistencia.controller;

import jakarta.transaction.Transactional;
import java.util.logging.Level;
import java.util.logging.Logger;

import org.hamcrest.Matchers;
import org.json.JSONException;
import org.json.JSONObject;
import org.junit.jupiter.api.AfterEach;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.MethodOrderer;
import org.junit.jupiter.api.Order;
import org.junit.jupiter.api.Test;
import org.junit.jupiter.api.TestMethodOrder;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.test.autoconfigure.web.reactive.AutoConfigureWebTestClient;
import org.springframework.boot.test.context.SpringBootTest;
import org.springframework.boot.test.web.server.LocalServerPort;
import org.springframework.http.MediaType;
import org.springframework.test.web.reactive.server.WebTestClient;

import pe.edu.upeu.asistencia.dtos.CredencialesDto;
import pe.edu.upeu.asistencia.dtos.UsuarioCrearDto;
import pe.edu.upeu.asistencia.models.Periodo;

/**
 *
 * @author DELL
 */
@TestMethodOrder(MethodOrderer.OrderAnnotation.class)
@SpringBootTest(webEnvironment = SpringBootTest.WebEnvironment.RANDOM_PORT)
@AutoConfigureWebTestClient
public class PeriodoControllerWebTestClientTest {

    @LocalServerPort
    private int port;

    @Autowired
    private WebTestClient webTestClient;

    private String token;

    Logger logger = Logger.getLogger(PeriodoControllerWebTestClientTest.class.getName());

    @BeforeEach
    public void setUp() {
        System.out.println("Puerto x:" + this.port);
        UsuarioCrearDto udto = new UsuarioCrearDto("Elias", "Mamani Pari", "eliasmp@upeu.edu.pe",
                "Da12345*", "admin", "43631918", "upeu", "Activo", "SI");
        try {
            var dd = webTestClient.post()
                    .uri("/asis/login")
                    .contentType(MediaType.APPLICATION_JSON)
                    .bodyValue(new CredencialesDto("eliasmp@upeu.edu.pe", "Da12345*"))//.toCharArray()
                    .exchange()
                    .expectBody(String.class)
                    .returnResult()
                    .getResponseBody();
            JSONObject jsonObj = new JSONObject(dd);
            if (jsonObj.length() > 1) {
                token = jsonObj.getString("token");
            } else {
                if (token == null) {
                    webTestClient.post()
                            .uri("/asis/register")
                            .contentType(MediaType.APPLICATION_JSON)
                            .bodyValue(udto)//.toCharArray()
                            .exchange()
                            .expectStatus().isCreated()
                            .expectBody(String.class)
                            .value(tokenx -> {
                                try {
                                    JSONObject jsonObjx = new JSONObject(tokenx);
                                    if (jsonObjx.length() > 1) {
                                        token = jsonObjx.getString("token");
                                    }
                                } catch (JSONException ex) { //JSONException|
                                    logger.log(Level.SEVERE, null, ex);
                                }
                            });
                }
            }
        } catch (JSONException e) {
            System.out.println("saliooooo:" + e.getMessage());
        }
    }

    @AfterEach
    public void tearDown() {
    }

    Periodo periodo;
    Long idx;
    
    @Test
    @Order(1)
    public void testListarPeriodo() {
        System.out.println("ddd:" + token);
        webTestClient.get().uri("http://localhost:" + this.port + "/asis/periodo/list")
                .header("Authorization", "Bearer " + token)
                .exchange()
                .expectStatus().isOk()
                .expectHeader().contentType(MediaType.APPLICATION_JSON)
                .expectBody()
                .jsonPath("$[0].nombre").isEqualTo("2023-2")
                .jsonPath("$[0].estado").isEqualTo("Activo")
                .jsonPath("$").isArray();
                //.jsonPath("$").value(Matchers.hasSize(5));
    }

    @Transactional
    @Test
    @Order(2)
    public void testGuardarPeriodo() {
        /*Periodo periodo = Periodo.builder()
                .nombre("2024-2")
                .estado("Inactivo").build();*/
        periodo = Periodo.builder()
                .nombre("2024-1")
                .estado("Inactivo").build();

        try {
            var datoBuscado = webTestClient.post().uri("http://localhost:" + this.port + "/asis/periodo/crear")
                    .header("Authorization", "Bearer " + token)
                    .contentType(MediaType.APPLICATION_JSON)
                    .bodyValue(periodo)
                    .exchange()
                    .expectStatus().isOk()
                    .expectBody(String.class)
                    .returnResult()
                    .getResponseBody();

            JSONObject jsonObj = new JSONObject(datoBuscado);
            if (jsonObj.length() > 1) {
                idx = Long.parseLong(jsonObj.getString("id"));
            }
        } catch (JSONException e) {
            System.out.println("Error:" + e);
        }

        System.out.println("DATO:" + idx);

    }

    @Transactional
    @Test
    @Order(3)
    public void testActualizarPeriodo() {
        Periodo periodox = Periodo.builder()
                .nombre("2024-2")
                .estado("Activo").build();

        Long datoBuscado = webTestClient.get().uri("http://localhost:" + this.port + "/asis/periodo/buscarmaxid")
                .header("Authorization", "Bearer " + token)
                .exchange()
                .expectStatus().isOk()
                .expectBody(Long.class)
                .returnResult()
                .getResponseBody();

        webTestClient.put().uri("http://localhost:" + this.port + "/asis/periodo/editar/{id}", datoBuscado)
                .header("Authorization", "Bearer " + token)
                .contentType(MediaType.APPLICATION_JSON)
                .bodyValue(periodox)
                .exchange()
                .expectStatus().isOk();
    }

    @Test
    @Order(4)
    public void testBuscarPeriodo() {
        Long datoBuscado = webTestClient.get().uri("http://localhost:" + this.port + "/asis/periodo/buscarmaxid")
                .header("Authorization", "Bearer " + token)
                .exchange()
                .expectStatus().isOk()
                .expectBody(Long.class)
                .returnResult()
                .getResponseBody();

        webTestClient.get().uri("http://localhost:" + this.port + "/asis/periodo/buscar/{id}", datoBuscado)
                .header("Authorization", "Bearer " + token)
                .exchange()
                .expectStatus().isOk()
                .expectHeader().contentType(MediaType.APPLICATION_JSON)
                .expectBody()
                .jsonPath("$.nombre").isEqualTo("2024-2")
                .jsonPath("$.estado").isEqualTo("Activo");
    }

    @Test
    @Order(5)
    public void testEliminarPeriodo() {
        Long datoBuscado = webTestClient.get().uri("http://localhost:" + this.port + "/asis/periodo/buscarmaxid")
                .header("Authorization", "Bearer " + token)
                .exchange()
                .expectStatus().isOk()
                .expectBody(Long.class)
                .returnResult()
                .getResponseBody();

        Long id = datoBuscado;
        System.out.println("Elimnar: " + id);
        webTestClient.delete().uri("http://localhost:" + this.port + "/asis/periodo/eliminar/{id}", id)
                .header("Authorization", "Bearer " + token)
                .exchange()
                .expectStatus().isOk();
    }



}
