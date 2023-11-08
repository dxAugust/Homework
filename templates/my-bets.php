<section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">

        <?php print_r($_SESSION); ?>
        <?php print_r($bets); ?>

        <?php foreach($bets as $bet): ?>
          <?php if(strtotime('now') <= strtotime($bet['expire_date'])): ?>
            <tr class="rates__item">
          <?php elseif ($bet['winner_id'] === intval($_SESSION['user_id'])): ?>
            <tr class="rates__item rates__item--win">
          <?php else: ?>
            <tr class="rates__item rates__item--end">
          <?php endif; ?>
            <td class="rates__info">
              <div class="rates__img">
                <img src="<?= $bet["lot_img"] ?>" width="54" height="40" alt="Сноуборд">
              </div>
              <h3 class="rates__title"><a href="../lot.php?id=<?= $bet["lot_id"] ?>"><?= $bet["lot_name"] ?></a></h3>
              <?php if ($bet['winner_id'] === $_SESSION['user_id']): ?>
                <p><?= $bet['author_contacts'] ?></p>
              <?php endif; ?>
            </td>
            <td class="rates__category">
              <?= $bet["category_name"] ?>
            </td>

            <?php if(strtotime('now') <= strtotime($bet['expire_date'])): ?>
            <td class="rates__timer">
              
              <?php 
              $date = get_dt_range($bet['expire_date']); 
              $hours = $date[0];
              $minutes = $date[1];
              $seconds = $date[2];
              ?>

                  <div class="timer <?php if (intval($hours) < 24): ?> timer--finishing <?php endif; ?>">
                <?= sprintf('%s:%s:%s', $hours, $minutes, $seconds) ?>
              </div>
            </td>

            <?php elseif ($bet['winner_id'] === intval($_SESSION['user_id'])): ?>
              <td class="rates__timer">
                <div class="timer timer--win">Ставка выиграла</div>
              </td>
            <?php else: ?>
              <td class="rates__timer">
                <div class="timer timer--end">Торги окончены</div>
              </td>
            <?php endif; ?>

            <td class="rates__price">
              <?= pretty_number($bet["summary"]) ?> р
            </td>
            <td class="rates__time">
              <?= format_time($bet["create_date"]) ?>
            </td>
          </tr>

        <?php endforeach; ?>
      </table>
    </section>