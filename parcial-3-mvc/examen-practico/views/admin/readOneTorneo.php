<?php

    //Jesús Zatarain Tirado 3-1
    
    require_once("../admin/template/header.php");
    require_once("../../controllers/torneosController.php");
    //Instanciar el controlador para ejecutar la consulta.
    $objTorneosController = new torneosController();
    //Capturar el id y a su vez sacar la información del torneo.
    $lstTorneo = $objTorneosController->readOneTorneo($_GET['id']);

?>

<div class="mx-auto p-5">
    <div class="card">
        <div class="card-header">
            INFORMACIÓN DEL TORNEO
        </div>
        <div class="card-body">
            <form action="torneosInsert.php" method="post">
                <div class="mb-3">
                    <label for="nombreTorneo" class="form-label">
                        NOMBRE DEL TORNEO (ID: 
                        <?= $lstTorneo['id'] ?>)
                    </label>
                    <input type="text" class="form-control" 
                    name="txtNombreTorneo" id="nombreTorneo"
                    value="<?= $lstTorneo['nombreTorneo'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="organizador" class="form-label">
                        ORGANIZADOR (nombre completo)
                    </label>
                    <input type="text" class="form-control" 
                    name="txtOrganizador" id="organizador" 
                    value="<?= $lstTorneo['organizador'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="patrocinador" class="form-label">
                        PATROCINADOR(ES)
                    </label>
                    <textarea type="text" class="form-control" readonly
                    name="txtPatrocinador" id="patrocinador" cols="30" rows="2"><?= $lstTorneo['patrocinadores'] ?></textarea>
                    <span class="form-text" id="patrocinador" >
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
                            name="txtSede" id="sede"
                            value="<?= $lstTorneo['sede'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="categoria" class="form-label">
                                CATEGORÍA
                            </label>
                            <input list="lstCategorias" class="form-control" 
                            name="txtCategoria" id="categoria"
                            value="<?= $lstTorneo['categoria'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="premio1" class="form-label">
                            PREMIO 1ER. LUGAR
                        </label>
                        <input type="text" class="form-control"
                        id="premio1" name="txtPremio1"
                        value="<?= $lstTorneo['premio1'] ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label for="premio2" class="form-label">
                            PREMIO 2DO. LUGAR
                        </label>
                        <input type="text" class="form-control"
                        id="premio2" name="txtPremio2"
                        value="<?= $lstTorneo['premio2'] ?>" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col mb-3">
                        <label for="premio3" class="form-label">
                            PREMIO 3ER. LUGAR
                        </label>
                        <input type="text" class="form-control"
                        id="premio3" name="txtPremio3"
                        value="<?= $lstTorneo['premio3'] ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label for="otroPremio" class="form-label">
                            OTRO PREMIO (Campeón canastero)
                        </label>
                        <input type="text" class="form-control"
                        id="otroPremio" name="txtOtroPremio"
                        value="<?= $lstTorneo['otroPremio'] ?>" readonly>
                    </div>
                </div>
                <!-- Usuario y contraseña para el organizador del torneo -->
                <div class="row">
                    <div class="col mb-3">
                        <label for="usuario" class="form-label">
                            USUARIO
                        </label>
                        <input type="text" class="form-control"
                        id="usuario" name="txtUsuario"
                        value="<?= $lstTorneo['usuario'] ?>" readonly>
                    </div>
                    <div class="col mb-3">
                        <label for="contrasena" class="form-label">
                            CONTRASEÑA
                        </label>
                        <input type="text" class="form-control"
                        id="contrasena" name="txtContrasena"
                        value="<?= $lstTorneo['contrasena'] ?>" readonly>
                    </div>
                    
                </div>
                <div class="col-12">
                    <a href="readAllTorneos.php" class="btn btn-success">REGRESAR</a>
                </div>
            </form>
        </div>
        <div class="card-footer text-body-secondary">
            DETALLE DE TORNEO.
        </div>
    </div>
</div>

<?php
    require_once("../admin/template/footer.php");
?>