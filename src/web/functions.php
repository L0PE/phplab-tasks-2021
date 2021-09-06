<?php
/**
 * The $airports variable contains array of arrays of airports (see airports.php)
 * What can be put instead of placeholder so that function returns the unique first letter of each airport name
 * in alphabetical order
 *
 * Create a PhpUnit test (GetUniqueFirstLettersTest) which will check this behavior
 *
 * @param  array  $airports
 * @return string[]
 */
function getUniqueFirstLetters(array $airports): array
{
    $firstLetters = array();
    foreach ($airports as $airport) {
        if (!isset($airport['name'])) {
            throw new InvalidArgumentException('Input array must have a "name" key');
        }
        $firstLetters[] = $airport['name'][0];
    }
    $firstLetters =  array_unique($firstLetters);
    sort($firstLetters);

    return $firstLetters;
}

/**
 * @return bool
 */
function filterByLetterValidator():bool
{
    return isset($_GET['filter_by_first_letter']) &&
        preg_match('/^[A-Z]$/m', $_GET['filter_by_first_letter']);
}

/**
 * @return bool
 */
function filterByStateValidator():bool
{
    $airports = require './airports.php';
    return isset($_GET['filter_by_state']) &&
        state_in_array($airports, $_GET['filter_by_state']);
}

/**
 * Checks whether the state is in the array
 * @param $airports
 * @param $state
 * @return bool
 */
function state_in_array($airports, $state): bool
{
    foreach ($airports as $airport) {
        if ($airport['state'] === $state) {
            return true;
        }
    }
    return false;
}

/**
 * @return bool
 */
function sortValidator(): bool
{
    $sortFields = ['name','code','state','city'];
    return isset($_GET['sort']) && in_array($_GET['sort'], $sortFields);
}

/**
 * Sort an array by a specific key
 * @param array $array
 * @param string $on
 * @return array
 */
function array_sort(array $array, string $on): array
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        asort($sortable_array);

        foreach ($sortable_array as $k => $v) {
            $new_array[] = $array[$k];
        }
    }

    return $new_array;
}

/**
 * @param int $limit
 * @param int $total
 * @return array
 */
function getPaginationInfo(int $limit, int $total):array
{
    $pages = (int) ceil($total / $limit);
    $currentPage = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' =>
        array(
            'default'   => 1,
            'min_range' => 1,
        ))));
    $offset = ($currentPage-1) * $limit;
    return [$pages,$currentPage,$offset];
}

/**
 * Return href for filter url
 * @param string $key
 * @param string $value
 * @return string
 */
function getFilterHref(string $key, string $value):string
{
    $href = $_SERVER['PHP_SELF'] . '?' . $key . '=' . $value;
    if ($key === 'filter_by_first_letter' && filterByStateValidator()) {
        $href .= '&filter_by_state=' . $_GET['filter_by_state'];
    } elseif ($key === 'filter_by_state' && filterByLetterValidator()) {
        $href .= '&filter_by_first_letter=' . $_GET['filter_by_first_letter'];
    }
    return $href;
}

/**
 * Print links for the five previous, current, and five following pages
 * @param int $currentPage
 * @param int $pages
 */
function printPagination(int $currentPage, int $pages):void
{
    for ($i = 1; $i <= $pages; $i++) :
        if ($i === $currentPage) : ?>
            <li class="page-item active"><a class="page-link" href="<?=getPaginationHref((string)$i)?>"><?=$i?></a></li>
        <?php elseif (($i >= $currentPage - 5) && ($i <= $currentPage + 5)) : ?>
            <li class="page-item"><a class="page-link" href="<?=getPaginationHref((string)$i)?>"><?=$i?></a></li>
        <?php endif;
    endfor;
}

/**
 * Return href with filters url
 * @param string $key
 * @param string $value
 * @return string
 */
function getHrefWithFilters(string $key, string $value):string
{
    $href = $_SERVER['PHP_SELF'] . '?' . $key . '=' . $value;
    if (filterByLetterValidator()) {
        $href .= '&filter_by_first_letter=' . $_GET['filter_by_first_letter'];
    }
    if (filterByStateValidator()) {
        $href .= '&filter_by_state=' . $_GET['filter_by_state'];
    }
    return $href;
}

/**
 * @param string $page
 * @return string
 */
function getPaginationHref(string $page): string
{
    $href = getHrefWithFilters('page', $page);
    if (sortValidator()) {
        $href .= '&sort=' . $_GET['sort'];
    }
    return $href;
}

/**
 * @param string $sortField
 * @param string $currentPage
 * @return string
 */
function getSortHref(string $sortField, string $currentPage): string
{
    $href = getHrefWithFilters('sort', $sortField);
    $href .= '&page=' . $currentPage;
    return $href;
}
