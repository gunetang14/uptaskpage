<?php include_once __DIR__ . '/header-dashboard.php'; ?>


    <?php if(count($proyectos) === 0) { ?>

        <p class="no-proyectos">No Hay Proyectos Aún <a href="/new-project">Comienza Creando Un Proyecto</a></p>

    <?php } else { ?>
        <ul class="listado-proyectos">

            <?php foreach($proyectos as $proyecto) : ?>
                <li class="proyecto">
                    <a href="/my-project?id=<?php echo $proyecto->url; ?>">
                        <?php echo $proyecto->proyecto;  ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php } ?>







<?php include_once __DIR__ . '/footer-dashboard.php'; ?>
