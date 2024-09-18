<div class="container text-center  align-content-center">
    <h1 class="mb-5">Administrador</h1>

  <section class="row justify-content-center">  

    <section class="col-md-5">
        <div class="card-counter primary mb-3">
            <i class="material-icons">sentiment_very_satisfied</i>
            <?php foreach ($student as $item): ?>
            <span class="count-numbers"><?= $item->student?></span>
            <?php endforeach  ?>

            <span class="count-name">Alumnos</span>
        </div>
    </section>

    <section class="col-md-5">
        <div class="card-counter danger mb-3">
            <i class="material-icons">psychology</i>
            <?php foreach ($subject as $item): ?>
                    <span class="count-numbers"><?= $item->materia?></span>
            <span class="count-name">Materia</span>
            <?php endforeach  ?>

        </div>
    </section>

    <section class="col-md-5">
        <div class="card-counter info mb-3">
            <i class="material-icons">person_outline</i>
            <?php foreach ($payment as $item): ?>
                        <span class="count-numbers"><?= $item->pagos?></span>
            <span class="count-name">Pagos</span>
            <?php endforeach  ?>

        </div>
    </section>

    <section class="col-md-5">
        <div class="card-counter success mb-3">
            <i class="material-icons">supervisor_account</i>
            <?php foreach ($tutor as $item): ?>
                    <span class="count-numbers"><?= $item->tutor?></span>
            <?php endforeach  ?>
            <span class="count-name">Padres</span>
        </div>

    </section>
  </section>
</div>

