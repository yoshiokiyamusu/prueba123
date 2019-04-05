//READ-PULL | like value en una columna
static public function count_all_con_query($col='',$string=''){
  $sql = "SELECT COUNT(*) FROM " . static::$table_name. "";
  $sql .= " WHERE ".self::$database->escape_string($col)." LIKE '%".self::$database->escape_string($string)."%' ";
  $return_set = self::$database->query($sql);
  $row = $return_set->fetch_array();//fetch_array is used for 1 value result
  return array_shift($row);
}




  SELECT *, count(*) as numrep FROM(
    SELECT * FROM SKU
    WHERE sku_readable LIKE '%truza%'
    group by sku
  union ALL
    SELECT * FROM SKU
    WHERE sku_readable LIKE '%alto%'
    group by sku
  union ALL
    SELECT * FROM SKU
    WHERE sku_readable LIKE '%talla 10%'
    group by sku
  union ALL
    SELECT * FROM SKU
    WHERE sku_readable LIKE '%celeste%'
  group by sku
  )as tb1
  group by sku order by numrep desc
  limit 10
  offset 10

SELECT *, count(*) as numrep FROM(
  SELECT * FROM sku WHERE sku_readable LIKE '%celeste%' group by sku
  UNION ALL
  SELECT * FROM sku WHERE sku_readable LIKE '%truza%' group by sku
  UNION ALL
  SELECT * FROM sku WHERE sku_readable LIKE '%talla%' group by sku
  UNION ALL
  SELECT * FROM sku WHERE sku_readable LIKE '%10%' group by sku
  UNION ALL
  SELECT * FROM sku WHERE sku_readable LIKE '%alto%' group by sku
  UNION ALL
  SELECT * FROM sku WHERE sku_readable LIKE '%celeste%' group by sku
  )as tb1  group by sku order by numrep desc  LIMIT 15 OFFSET 15
