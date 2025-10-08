<table>
    <tr>
        <td>Id</td>
        <td>Nombre</td>
        <td>Pais</td>
        <td>Ciudad</td>
    </tr>
    <?php
        foreach ($listaEquipos as $equipo){ ?>
            <tr>
                <td><?=$equipo->getId();?></td>
                <td><?=$equipo->getNombre();?></td>
                <td><?=$equipo->getPais();?></td>
                <td><?=$equipo->getCiudad();?></td>
            </tr>
        <?php } ?>
</table>