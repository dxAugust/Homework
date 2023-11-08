<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title ?></title>
  <link href="../css/normalize.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/flatpickr.min.css" rel="stylesheet">
</head>
<body>

<div class="page-wrapper">
  <header class="main-header">
    <div class="main-header__container container">
      <h1 class="visually-hidden">YetiCave</h1>
      <a class="main-header__logo" href="/index.php">
        <img src="../img/logo.svg" width="160" height="39" alt="Логотип компании YetiCave">
      </a>
      <form class="main-header__search" method="get" action="../search.php" autocomplete="off">
        <input type="search" name="search" placeholder="Поиск лота">
        <input class="main-header__search-btn" type="submit" name="find" value="Найти">
      </form>

      <?php if (isset($_SESSION['is_auth']) && $_SESSION['is_auth']): ?>
          <a class="main-header__add-lot button" href="../add.php">Добавить лот</a>
      <?php endif; ?>

      <nav class="user-menu">
            <?php if (isset($_SESSION['is_auth']) && $_SESSION['is_auth']): ?>
                <div class="user-menu__logged">
                    <p> <?= htmlspecialchars($_SESSION['username']) ?> </p>
                    <a class="user-menu__bets" href="../my-bets.php">Мои ставки</a>
                    <a class="user-menu__logout" href="../logout.php">Выход</a>
                </div>
            <?php else: ?>
                <ul class="user-menu__list">
                    <li class="user-menu__item">
                        <a href="../sign-up.php">Регистрация</a>
                    </li>
                    <li class="user-menu__item">
                        <a href="../login.php">Вход</a>
                    </li>
                </ul>
            <?php endif; ?>
        </nav>

    </div>
  </header>

  <?php 
  $current_category = 0;  

  if (isset($category_id))
  {
    $current_category = $category_id;
  }
  ?>

  <main>
    <nav class="nav">
      <ul class="nav__list container">
        <?php if (isset($categories)): ?>
          <?php foreach($categories as $item): ?>
            <?php if ($item["id"] != $current_category): ?>
              <li class="nav__item">
                  <a href="../category.php?id=<?= $item["id"] ?>"><?= $item['name'] ?></a>
              </li>
            <?php else: ?>
              <li class="nav__item nav__item--current">
                  <a href="../category.php?id=<?= $item["id"] ?>"><?= $item['name'] ?></a>
              </li>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </ul>
    </nav>