<form action="report_process.php" method="POST">
    <div class="pending-reports-container">
        <?php if ($pending->num_rows > 0): ?>

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
                                    <a href="<?="report_info.php?id=".$report['id'];?>" id="show_report">Ver reporte</a>
                                </td>
                                <?php if ($_SESSION['id_role'] == 2): ?>
                                    <td>
                                        <button type="submit" id="completed">Marcar completado</button>
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
