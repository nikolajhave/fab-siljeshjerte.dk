<?php
/**
 * Convert fields to proper UTF8 text
 *
 * Either of these queries shows rows with multibyte chars with potential problems
 * SELECT id, beskrivelse, CONVERT(beskrivelse USING ASCII) as chars FROM produkt WHERE beskrivelse <> CONVERT(beskrivelse USING ASCII);
 * SELECT id, beskrivelse FROM produkt WHERE LENGTH(beskrivelse) != CHAR_LENGTH(beskrivelse)
 *
 * Conversion table:
 * http://www.i18nqa.com/debug/utf8-debug.html
 **/
require "local.inc";

$tables = [
   'object',
];

$chars = array
(
    // First set of conversions
    'Ã¦' => 'æ',
    'Ã¸' => 'ø',
    'Ã¥' => 'å',
    'Ã¶' => 'ö',
    'Ã¼' => 'ü',
    'Ã†' => 'Æ',
    'Ã˜' => 'Ø',
    'Ã…' => 'Å',
    'Ã–' => 'Ö',
    'Â´' => '´',
    'Ã©' => 'é',
    'Ã¤' => 'ä',
    // Some chars have lowercase à
    'à¦' => 'æ',
    'à¸' => 'ø',
    'à¥' => 'å',
    'à¶' => 'ö',
    'à¼' => 'ü',
    'à†' => 'æ',
    'à˜' => 'ø',
    'à…' => 'å',
    'à–' => 'Ö',
    'à´' => '´',
    'à©' => 'é',
    'à¤' => 'ä',
    // Only found one type
    'àµ' => 'ö',
    'Â½' => '½',
    'aÌŠ' => 'å',
    'aÌˆ' => 'ä',
    'aÌ€' => 'à',
    'aÌ' => 'á',
    'AÌŠ' => 'Å',
    'AÌˆ' => 'Ä',
    'AÌ€' => 'À',
    'AÌ' => 'Á',
    // Intentionally broken encoding
    // Because filname is broken
    'AÌƒÂ¥' => 'Ã¥',
    'AÌƒå' => 'Ãå',
    // HTML
    'â€¢' => '•',
);

// Loop through tables
foreach ($tables AS $key => $table)
{
    $fields = get_table_columns($table);
    convert($table, $fields, $chars);
}

$time = (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]) / 60;
echo "Process Time: " . $time;

// Convert fields
function convert($table, $fields, $chars)
{
    $db = new DB();

    foreach ($fields AS $key => $field)
    {
        foreach ($chars AS $original => $new)
        {
            $sql = "UPDATE " . $table . " SET " . $field . " = REPLACE (" . $field . ", '" . $original . "', '" . $new . "')";
            $result = $db->query($sql);
        }
    }
}

// Get column names
function get_table_columns($table)
{
    $columns = array();
    $db = new DB();

    $sql = "SHOW columns FROM " . $table;
    $result = $db->query($sql);

    while ($row = $result->fetch_object())
    {
        if ($row->Type == 'text' OR substr($row->Type, 0, 7) == 'varchar' OR substr($row->Type, 0, 8) == 'longtext')
        {
            $columns[] = $row->Field;
        }
    }

    return $columns;
}
