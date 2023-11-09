<?php
    require_once('init.php');

    const ELEMENTS_PER_PAGE = 3;

    $category_list = get_categories_list($mysql);
    $search_term = "";

    isset($_GET["search"]) ? $search_term = trim($_GET["search"]) : $search_term = "";
    $current_page = 1;
    isset($_GET["page"]) ? $current_page = $_GET["page"] : $current_page = 1;

    $lots = search_lots_by_name($mysql, $search_term, ELEMENTS_PER_PAGE, ($current_page - 1) * ELEMENTS_PER_PAGE);

    $lots_amount = $lots[0];
    $lots = $lots[1];

    $max_pages = ceil($lots_amount / ELEMENTS_PER_PAGE);

    print(include_template('header.php', [
      'page_title' => "Поиск",
      'categories' => $category_list
    ]));

    if (!empty($lots))
    {
      print(include_template('search.php', [
        'search_term' => $search_term,
        'lots' => $lots,
        'current_page' => $current_page,
        'max_pages' => $max_pages
      ]));
    } else {
      http_response_code(404);
      print(include_template('error.php', [
        'title' => "404 Ничего не найдено",
        'description' => "В этой категории ещё нет не одного активного лота",
      ]));
    }
    
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>