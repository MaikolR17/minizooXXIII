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
                            <!-- Implementar acción para ver reporte -->
                            <button type="button" id="show_report">Ver reporte</button>
                        </td>
                        <td>
                            <?php if ($report['completed'] == 0): ?>
                                <img src="" alt="Pendiente" style="width:20px; height:20px;">
                            <?php else: ?>
                                <img src="" alt="Completado" style="width:20px; height:20px;">
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>No hay reportes pendientes por revisar</p>
    <?php endif; ?>
</div>
