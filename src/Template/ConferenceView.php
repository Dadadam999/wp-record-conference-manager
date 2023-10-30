<div id="conference-menu-<?= $post_id; ?>"  class="rcm-conference-content">
  <h3><?= $title; ?></h3>

  <div class="rcm-speaker">
     <h5>Докладчики:</h5>
     <p><?= $speaker; ?></p>
  </div>

  <div class="rcm-dates">
     <div class="rcm-date-start">
       <h5>Дата начала:</h5>
       <p><?= $start_date; ?></p>
     </div>

     <div class="rcm-date-end">
       <h5>Дата окончания:</h5>
       <p><?= $end_date; ?></p>
     </div>
  </div>

  <?php if( $symposium ) : ?>
    <div class="rcm-symposium">
      <h5>Симпозиум:</h5>
      <p><?= $symposium; ?></p>
    </div>
  <?php endif; ?>

  <div class="rcm-iframe">
      <?= $iframe; ?>
  </div>

  <div class="rcm-to-menu">
     <a href="#rmc-menu-wrapper">Вернутся к началу страницы</a>
  </div>
</div>
