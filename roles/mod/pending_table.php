<div class="pending-reports-container">
        <?php
            if($rs->num_rows > 0):
        ?>

        <table>
            <thead>
                <th>
                    <tr>
                        <td>Autor</td>
                        <td>Asunto</td>
                        <td>Descripcion</td>
                        <td>Imagen adjunta</td>
                        <td>Accion</td>
                        <?php if($_SESSION['id_role'] == 2):?>
                            <td>Accion</td>
                        <?php endif;?>        
                    </tr>
                </th>
            </thead>
            <tbody>
                <?php
                    foreach($reports as $report):
                        if($report['completed']==0):
                            $shortDescription = strlen($report['description']) > 50? substr($report['description'],0,50)."..." : $report['description'];
                ?>
                    <tr>
                        <td><?=htmlspecialchars($report['username'])?></td>
                    </tr>
                    <tr>
                        <td><?=htmlspecialchars($report['subject'])?></td>
                    </tr>
                    <tr>
                        <td><?=htmlspecialchars($report['description'])?></td>
                    </tr>
                    <tr>
                        <td><?=is_null($report['img'])? "No" : "Si"?></td>
                    </tr>
                    <!--Implementar action para enviar por post con js-->
                    <tr>
                        <td><button type="button" id="show_report">Ver reporte</button></td>
                    </tr>
                    <?php if($_SESSION['id_role'] == 2): ?>
                    <tr>
                        <td><button type="button" id = "completed">Marcar completado</button></td>
                    </tr>
                    <?php 
                    endif;
                    endif;
                    endforeach;
                    ?>
            </tbody>

        </table>
        <?php
            else:
                echo "<p>No hay reportes pendientes por revisar<p>";
            endif;
        ?>
    </div>