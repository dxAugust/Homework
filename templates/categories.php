<div class="container">
      <section class="lots">
      <h2>Все лоты в категории <span>«<?= $category_name ?>»</span></h2>
        <ul class="lots__list">
        <?php foreach($lots as $item): ?>
          <?php
                            $date = get_dt_range($item['expire_date']);
                            $hours = $date[0];
                            $minutes = $date[1];
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
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?= make_number(htmlspecialchars($item['start_price'])) ?></span>
                </div>
                <div class="lot__timer timer">

                  <?php
                     $date_range = get_dt_range($item['expire_date']);
                     $hours = $date_range[0];
                     $minutes = $date_range[1];
                     $seconds = $date_range[2];
                  ?>
                  <?= $hours . ':' . $minutes . ':' . $seconds ?>
                </div>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>
      <ul class="pagination-list">
        <?php if ($current_page != $max_pages): ?>
          <li class="pagination-item pagination-item-prev"><a href="search.php?search=<?= $_GET["search"] ?><?php if(isset($_GET["page"])): ?>&page=<?= $_GET["page"] - 1 ?> <?php endif; ?>">Назад</a></li>
        <?php else: ?>
          <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $max_pages; $i++): ?>

          <?php if ($current_page == $i): ?>
            <li class="pagination-item pagination-item-active"><a><?= $i ?></a></li>
          <?php else: ?>
            <li class="pagination-item"><a><?= $i ?></a></li>
          <?php endif; ?>

        <?php endfor; ?>

        <?php if ($current_page != $max_pages): ?>
          <li class="pagination-item pagination-item-next"><a href="search.php?search=<?= $_GET["search"] ?><?php if(isset($_GET["page"])): ?>&page=<?= $_GET["page"] + 1 ?> <?php endif; ?>">Вперед</a></li>
        <?php else: ?>
          <li class="pagination-item pagination-item-next"><a>Вперед</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </main>