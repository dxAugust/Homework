<?php
    require_once('init.php');

    const ELEMENTS_PER_PAGE = 2;

    $category_list = get_categories_list($mysql);
    $search_term = $_GET["search"];

    $current_page = 1;

    isset($_GET["page"]) ? $current_page = $_GET["page"] : 1;

    $lots = search_lots_by_name($mysql, $search_term, ELEMENTS_PER_PAGE, ($current_page - 1) * ELEMENTS_PER_PAGE);
    $max_pages = ceil(count($lots) / ELEMENTS_PER_PAGE);

    print(include_template('header.php', [
      'page_title' => "Поиск",
      'categories' => $category_list
    ]));

    print(include_template('search.php', [
      'search_term' => $search_term,
      'lots' => $lots,
      'current_page' => $current_page,
      'max_pages' => $max_pages,
    ]));
?>

</div>

<?php

print(include_template('footer.php', [
  'categories' => $category_list,
]));

?>