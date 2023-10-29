<?php
    require_once('init.php');

    const ELEMENTS_PER_PAGE = 9;

    $category_list = get_categories_list($mysql);
    $current_category = 1;
    isset($_GET["id"]) ? $current_category = $_GET["id"] : $current_category = 1;

    $current_page = 1;

    isset($_GET["page"]) ? $current_page = $_GET["page"] : 1;

    $category_name = get_category_name_by_id($mysql, $current_category);
    $lots = get_lot_list_by_category_id($mysql, $current_category, ELEMENTS_PER_PAGE, ($current_page - 1) * ELEMENTS_PER_PAGE);
    $max_pages = ceil(count($lots) / ELEMENTS_PER_PAGE);

    print(include_template('header.php', [
      'page_title' => "Поиск",
      'categories' => $category_list
    ]));

    print(include_template('categories.php', [
      'category_name' => $category_name,
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