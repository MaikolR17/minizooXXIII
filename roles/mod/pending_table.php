<form action="report_process.php" method="POST" style="display: block;">
<div class="pending-reports-container">
        <?php
            if($rs->num_rows > 0):
        ?>
    <?php if ($rs->num_rows > 0): ?>

        <table>
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Asunto</th>
                    <th>Descripción</th>
                    <th>Imagen adjunta</th>
                    <th>Acción</th>
                    <?php if ($_SESSION['id_role'] == 2): ?>
                        <th>Marcar completado</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($reports as $report):
                        if($report['completed']==0):
                            $shortDescription = strlen($report['description']) > 50? substr($report['description'],0,50)."..." : $report['description'];
                ?>
                <input type="hidden" name="id" type="hidden" value="<?=$report['id'];?>">
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
                    <tr>
                        <td><a href="report_info.php?id=<?=htmlspecialchars($report['id'])?>" ><i class="fas fa-info-circle"></i><span>Ver reporte</span></a></td>
                    </tr>
                    <?php if($_SESSION['id_role'] == 2): ?>
                    <tr>
                        <td><button type="submit" id ="completed">Marcar completado</button></td>
                    </tr>
                    <?php 
                    endif;
                    endif;
                    endforeach;
                    ?>
                <?php foreach ($reports as $report): ?>
                    <?php if ($report['completed'] == 0): ?>
                        <?php
                            $shortDescription = strlen($report['description']) > 50
                                ? substr($report['description'], 0, 50) . "..."
                                : $report['description'];
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($report['username']) ?></td>
                            <td><?= htmlspecialchars($report['subject']) ?></td>
                            <td><?= htmlspecialchars($shortDescription) ?></td>
                            <td><?= is_null($report['img']) ? "No" : "Sí" ?></td>
                            <td>
                                <!-- Implementar acción para ver reporte -->
                                <button type="button" id="show_report">Ver reporte</button>
                            </td>
                            <?php if ($_SESSION['id_role'] == 2): ?>
                                <td>
                                    <button type="button" id="completed">Marcar completado</button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php
            else:
                echo "<p>No hay reportes pendientes por revisar<p>";
            endif;
        ?>
    </div>
</form>

    <?php else: ?>
        <p>No hay reportes pendientes por revisar</p>
    <?php endif; ?>
</div>
