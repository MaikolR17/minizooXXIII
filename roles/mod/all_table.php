<div class="all-reports-container" style="display: none;">
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
                        <td>Estado</td>       
                    </tr>
                </th>
            </thead>
            <tbody>
                <?php
                    foreach($reports as $report):
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
                    <?php if($_SESSION['completed'] == 0): ?>
                    <tr>
                        <td><i class="fa-solid fa-square-xmark" style="color: #d91717;"></i></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td><i class="fa-solid fa-square-check" style="color: #25a70c;"></i></td>
                    </tr>
                    <?php 
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