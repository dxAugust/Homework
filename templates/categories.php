<div class="container">
      <section class="lots">
      <h2>Все лоты в категории <span>«<?= $category_name ?>»</span></h2>
        <ul class="lots__list">
        <?php foreach($lots as $item): ?>
          <?php
            $date = get_dt_range($item['expire_date']);
            $hours = $date[0];
            $minutes = $date[1];
            $seconds = $date[2];
          ?>

          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?= htmlspecialchars($item['image_link']) ?>" width="350" height="260" alt="Сноуборд">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?= htmlspecialchars($item['category_name']) ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?= $item['id'] ?>"><?= htmlspecialchars($item['name']) ?></a></h3>
              <div class="lot__state">
                <div class="lot__rate">
                    <?php if (!intval($item['bet_count'])): ?>
                      <span class="lot__amount">Стартовая цена</span>
                    <?php else: ?>
                      <span class="lot__amount">
                        <?= intval($item['bet_count']), " ", num_to_word(intval($item['bet_count']), array('ставка', 'ставки', 'ставок')) ?>
                      </span>
                    <?php endif; ?>
                  <span class="lot__cost"><?= make_number(htmlspecialchars($item['start_price'])) ?></span>
                </div>
                <div class="lot__timer timer">
                  <?= $hours . ':' . $minutes . ':' . $seconds ?>
                </div>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>
      <ul class="pagination-list">
        <?php if ($current_page != 1): ?>
          <li class="pagination-item pagination-item-prev"><a href="category.php?id=<?= $_GET["id"] ?><?php if(isset($_GET["page"])): ?>&page=<?= $_GET["page"] - 1 ?> <?php endif; ?>">Назад</a></li>
        <?php else: ?>
          <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $max_pages; $i++): ?>

          <?php if ($current_page == $i): ?>
            <li class="pagination-item pagination-item-active"><a><?= $i ?></a></li>
          <?php else: ?>
            <li class="pagination-item"><a href="category.php?id=<?= $_GET["id"] ?>&page=<?= $i ?>"><?= $i ?></a></li>
          <?php endif; ?>

        <?php endfor; ?>

        <?php if ($current_page != $max_pages): ?>
          <li class="pagination-item pagination-item-next"><a href="category.php?id=<?= $_GET["id"] ?><?php if(isset($_GET["page"])): ?>&page=<?= $_GET["page"] + 1 ?> <?php endif; ?>">Вперед</a></li>
        <?php else: ?>
          <li class="pagination-item pagination-item-next"><a>Вперед</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </main>