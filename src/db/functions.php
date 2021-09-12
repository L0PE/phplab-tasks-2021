<?php

/**
 * Return an array with unique first letters of airport names
 * @param PDO $pdo
 * @return array
 */
function getUniqueFirstLetters(PDO $pdo): array
{
    $sth = $pdo->query('SELECT DISTINCT LEFT(name, 1) AS `letter` FROM airports ORDER BY name');
    return $sth->fetchAll(PDO::FETCH_COLUMN);
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
    return isset($_GET['filter_by_state']) &&
        preg_match('/^([A-z\s]+)$/m', $_GET['filter_by_state']);
}

/**
 * @return bool
 */
function sortValidator(): bool
{
    $sortFields = ['name','code','state_name','city_name'];
    return isset($_GET['sort']) && in_array($_GET['sort'], $sortFields);
}


/**
 * @param int $total
 * @param int $limit
 * @return array
 */
function getPaginationInfo(int $total, int $limit):array
{
    $pages = (int) ceil($total / $limit);
    $currentPage = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array('options' =>
        array(
            'default'   => 1,
            'min_range' => 1,
        ))));
    $offset = ($currentPage - 1) * $limit;
    return [$pages, $currentPage, $offset];
}

/**
 * Return SELECT query to get the number of airports
 * @param string $where
 * @return string
 */
function getCountQuery(string $where): string
{
    return 'SELECT COUNT(a.id) as total FROM airports as a INNER JOIN states as s on a.state_id = s.id'
        . getWhereOrderStatement($where);
}
/**
 * Retutn WHERE and ORDER statement for SELECT
 * @param string $whereStatement
 * @param string $orderStatement
 * @return string
 */
function getWhereOrderStatement(string $whereStatement, string $orderStatement = ''): string
{
    $WhereOrderStatement = '';
    if ($whereStatement) {
        $WhereOrderStatement = ' WHERE';
    }
    return $WhereOrderStatement . $whereStatement . $orderStatement;
}

/**
 * Bind all parameters to PDOStatement
 * @param PDOStatement $sth
 * @param string $filterByLetter
 * @param string $filterByState
 * @param int $limit
 * @param int $offset
 */
function bindParameters(PDOStatement &$sth, string $filterByLetter, string $filterByState, int $limit = 0, int $offset = 0):void
{
    if ($filterByLetter) {
        $sth->bindParam('like', $filterByLetter);
    }
    if ($filterByState) {
        $sth->bindParam('state_name', $filterByState);
    }
    if ($limit) {
        $sth->bindParam('offset', $offset, PDO::PARAM_INT);
        $sth->bindParam('limit', $limit, PDO::PARAM_INT);
    }
}

/**
 * Return SELECT query to DB with all filters / sorting / pagination
 * @param string $wereForQuery
 * @param string $OrderForQuery
 * @return string
 */
function getAirportQuery(string $wereForQuery, string $OrderForQuery):string
{
    return 'SELECT 
                    a.name AS name, 
                    a.code AS code, 
                    c.name AS city_name, 
                    s.name AS state_name, 
                    a.address AS address, 
                    a.timezone AS timezone
            FROM airports AS a
            INNER JOIN cities AS c
            ON a.city_id = c.id
            INNER JOIN states AS s
            ON a.state_id = s.id'
            . getWhereOrderStatement($wereForQuery, $OrderForQuery) .
            ' LIMIT :limit
            OFFSET :offset';
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
    ?>
    <li class="page-item <?=$currentPage === 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="<?=getPaginationHref((string)($currentPage-1))?>" tabindex="-1">Previous</a>
    </li>
    <?php
    for ($i = 1; $i <= $pages; $i++) :
        if ($i === $currentPage) : ?>
            <li class="page-item active"><a class="page-link" href="<?=getPaginationHref((string)$i)?>"><?=$i?></a></li>
        <?php elseif (($i >= $currentPage - 5) && ($i <= $currentPage + 5)) : ?>
            <li class="page-item"><a class="page-link" href="<?=getPaginationHref((string)$i)?>"><?=$i?></a></li>
        <?php endif;
    endfor;
    ?>
    <li class="page-item <?=$currentPage === $pages ? 'disabled' : '' ?>">
        <a class="page-link" href="<?=getPaginationHref((string)($currentPage+1))?>">Next</a>
    </li>
    <?php
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
