<section class="lot-item container">
      <h2><?= $lot_info['name'] ?></h2>
      <div class="lot-item__content">
        <div class="lot-item__left">
          <div class="lot-item__image">
            <img src="<?= $lot_info['image_link'] ?>" width="730" height="548" alt="<?= htmlspecialchars($lot_info['category_name']) ?>">
          </div>
          <p class="lot-item__category">Категория: <span><?= $lot_info['category_name'] ?> </span></p>
          <p class="lot-item__description"><?= htmlspecialchars($lot_info['description']) ?></p>
        </div>
        <div class="lot-item__right">
          <div class="lot-item__state">
            <?php
                $date = get_dt_range($lot_info['expire_date']);
                $hours = $date[0];
                $minutes = $date[1];
            ?>

            <div class="lot-item__timer timer <?php if (intval($hours) < 24): ?> timer--finishing <?php endif; ?>">
                <?= sprintf('%s:%s', $hours, $minutes) ?>
            </div>
            
            <div class="lot-item__cost-state">
              <div class="lot-item__rate">
                <span class="lot-item__amount">Текущая цена</span>
                <span class="lot-item__cost"><?= pretty_number($lot_info['start_price']) ?></span>
              </div>
              <div class="lot-item__min-cost">
                Мин. ставка <span><?= pretty_number($lot_info['bet_step']) ?> р</span>
              </div>
            </div>
            <form class="lot-item__form" action="https://echo.htmlacademy.ru" method="post" autocomplete="off">
              <p class="lot-item__form-item form__item form__item--invalid">
                <label for="cost">Ваша ставка</label>
                <input id="cost" type="text" name="cost" placeholder="<?= pretty_number($lot_info['start_price']) ?>">
                <span class="form__error">Введите наименование лота</span>
              </p>
              <button type="submit" class="button">Сделать ставку</button>
            </form>
          </div>
          <div class="history">
            <h3>История ставок (<span><?= count($bet_history) ?></span>)</h3>
            <table class="history__list">
              <?php foreach($bet_history as $bet): ?>
                  <tr class="history__item">
                    <td class="history__name"><?= $bet[3] ?></td>
                    <td class="history__price"><?= pretty_number($bet[1]) ?> р</td>
                    <td class="history__time"><?= format_time($bet[0]) ?></td>
                  </tr>
              <?php endforeach; ?>
              
            </table>
          </div>
        </div>
      </div>
    </section>
  </main>