<?php

    //Jesús Zatarain Tirado LISI 3-1

    require_once("../admin/template/header.php");
?>

<div class="mx-auto p-5">
    <div class="card">
        <div class="card-header">
            <span class="fa-solid fa-trophy"></span> CAPTURAR LA INFORMACIÓN DEL TORNEO
        </div>
        <div class="card-body">
            <form action="torneosInsert.php" method="post">
                <div class="mb-3">
                    <label for="nombreTorneo" class="form-label">
                        NOMBRE DEL TORNEO
                    </label>
                    <input type="text" class="form-control" 
                    name="txtNombreTorneo" id="nombreTorneo">
                </div>
                <div class="mb-3">
                    <label for="organizador" class="form-label">
                        ORGANIZADOR (nombre completo)
                    </label>
                    <input type="text" class="form-control" 
                    name="txtOrganizador" id="organizador">
                </div>
                <div class="mb-3">
                    <label for="patrocinador" class="form-label">
                        PATROCINADOR(ES)
                    </label>
                    <textarea type="text" class="form-control" 
                    name="txtPatrocinador" id="patrocinador" cols="30" rows="2"></textarea>
                    <span class="form-text" id="patrocinador">
                        Atención: se puede separar con "," si hay 
                        más de un patrocinador.
                    </span>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="sede" class="form-label">
                                SEDE (cancha)
                            </label>
                            <input type="text" class="form-control" 
                            name="txtSede" id="sede">
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="categoria" class="form-label">
                                CATEGORÍA
                            </label>
                            <input list="lstCategorias" class="form-control" 
                            name="txtCategoria" id="categoria">
                            <datalist id="lstCategorias">
                                <option value="1ra. Fuerza"></option>
                                <option value="2da. Fuerza"></option>
                                <option value="Veteranos"></option>
                                <option value="Libre"></option>
                                <option value="Juvenil"></option>
                                <option value="Femenil"></option>
                                <option value="Empresarial"></option>
                                <option value="Infantil"></option>
                                <option value="Minibasket"></option>
                            </datalist>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="premio1" class="form-label">
                            PREMIO 1ER. LUGAR
                        </label>
                        <input type="text" class="form-control"
                        id="premio1" name="txtPremio1">
                    </div>
                    <div class="col mb-3">
                        <label for="premio2" class="form-label">
                            PREMIO 2DO. LUGAR
                        </label>
                        <input type="text" class="form-control"
                        id="premio2" name="txtPremio2">
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="premio3" class="form-label">
                            PREMIO 3ER. LUGAR
                        </label>
                        <input type="text" class="form-control"
                        id="premio3" name="txtPremio3">
                    </div>
                    <div class="col mb-3">
                        <label for="otroPremio" class="form-label">
                            OTRO PREMIO (Campeón canastero)
                        </label>
                        <input type="text" class="form-control"
                        id="otroPremio" name="txtOtroPremio">
                    </div>
                </div>
                <!-- Usuario y contraseña para el organizador del torneo -->
                <div class="row">
                    <div class="col mb-3">
                        <label for="usuario" class="form-label">
                            USUARIO
                        </label>
                        <input type="text" class="form-control"
                        id="usuario" name="txtUsuario">
                    </div>
                    <div class="col mb-3">
                        <label for="contrasena" class="form-label">
                            CONTRASEÑA
                        </label>
                        <input type="password" class="form-control"
                        id="contrasena" name="txtContrasena">
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <button type="submit" class="btn btn-primary">
                            Guardar
                        </button>
                        <a href="admin.php" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer text-body-secondary">
            FORMULARIO PARA REGISTRAR TORNEOS
        </div>
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>