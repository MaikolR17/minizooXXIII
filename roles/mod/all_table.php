<div class="all-reports-container">
    <?php if ($rs->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Asunto</th>
                    <th>Descripción</th>
                    <th>Imagen adjunta</th>
                    <th>Acción</th>
                    <th>Estado</th>       
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
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
                            <a href="<?="report_info.php?id=".$report['id'];?>" class="table-action-button">Ver reporte</a>
                        </td>
                        <td>
                            <?php if ($report['completed'] == 0): ?>
                                <i class="fa-solid fa-square-xmark" style="color: #cc1414; font-size:22px;"></i>
                            <?php else: ?>
                                <i class="fa-solid fa-square-check" style="color: #368d11; font-size:22px;"></i>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay reportes registrados.</p>
    <?php endif; ?>
</div>
