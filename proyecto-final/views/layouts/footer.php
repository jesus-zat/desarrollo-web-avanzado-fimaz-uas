<?php
//Jesús Zatarain Tirado LISI 3-1
/**
 * Layout de Cierre - Pie de Página General (Footer)
 *
 * Renderiza la sección inferior de la interfaz gráfica del sistema. Incorpora
 * los estilos CSS necesarios para implementar un "Sticky Footer" que se adhiere 
 * al fondo de la ventana mediante Flexbox, despliega los créditos institucionales 
 * de la facultad y evalúa dinámicamente la ruta actual para proveer un acceso 
 * directo condicional hacia el endpoint de la API JSON.
 *
 * @package Views
 * @subpackage Layouts
 * @uses BASE_URL Constante global para la resolución de rutas relativas y absolutas del proyecto.
 * @global array $_GET['route'] Analiza este parámetro de la URL para determinar si se expone el enlace a la API.
 */
?>
<style>
    .main-footer {
        background-color: #0b0f19;
        color: #8b98a9;
        /* Padding mínimo para que sea lo más bajo posible */
        padding: 10px 0 5px 0; 
        margin-top: 10px;
        font-family: 'Segoe UI', sans-serif;
        border-top: 3px solid #22d3ee;
    }

    .footer-container {
        max-width: 1100px; 
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        /* Alineamos al centro para que todo quepa en una línea visual */
        align-items: center; 
        padding: 0 15px;
    }

    .footer-section {
        /* Permitimos que el ancho sea flexible según el contenido */
        flex: 1; 
    }

    .footer-section h4 {
        color: #e6edf3;
        font-size: 0.75rem;
        /* Quitamos el margen inferior para reducir altura */
        margin: 0; 
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .footer-section p, .footer-section li {
        font-size: 0.7rem; 
        line-height: 1.2;
        /* Margen mínimo entre líneas */
        margin: 2px 0; 
    }

    .text-center { text-align: center; }
    .text-right { text-align: right; }
    
    .team-list { list-style: none; padding: 0; margin: 0; }
    .highlight { color: #22d3ee; font-weight: bold; }

    .footer-bottom {
        text-align: center;
        margin-top: 5px;
        padding-top: 5px;
        border-top: 1px solid #1b2130;
        font-size: 0.65rem;
        opacity: 0.7;
    }

    .footer-bottom a {
        color: #22d3ee;
        text-decoration: none;
    }

    .footer-bottom a:hover {
        text-decoration: underline;
    }

    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh; 
        margin: 0;
    }

    main, .container { 
        flex: 1; 
    }
</style>
</div>
</body>
<footer class="main-footer">
    <div class="footer-container">
        <div class="footer-section">
            <h4>FIMAZ - UAS</h4>
            <p><span class="highlight">Dr. José Alfonso Aguilar Calderón</span></p>
        </div>
        
        <div class="footer-section text-center">
            <h4>Integrantes</h4>
            <p style="font-size: 0.65rem;">Jesús Zatarain Tirado LISI 3-1</p>
        </div>

        <div class="footer-section text-right">
            <h4>Ubicación</h4>
            <p>Av. Universidad, Av. Leonismo Internacional y, Tellería, Mazatlán, Sin.<br>C.P. 82000</p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2026 Facultad de Informática Mazatlán.
            <br>
            <?php if (isset($_GET['route']) && ($_GET['route'] === 'productos' || $_GET['route'] === 'bitacora')): ?>
                <a href="<?= BASE_URL ?>api/productos" target="_blank">
                    Ver API JSON
                </a>
            <?php endif; ?> 
        </p>
    </div>
</footer>