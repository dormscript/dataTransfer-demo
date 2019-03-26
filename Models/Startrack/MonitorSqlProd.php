<?php

namespace Demo\Models\Startrack;

use Demo\Library\PipeInterface;

class MonitorSqlProd extends \dormscript\Data\Models\Table
{
    public $primaryKey = "id";
    public $srcTable   = 'startrack.monitor_sql_prod';

    public function __construct()
    {
        PipeInterface::addPragram('soar', '/webroot/src/goproject/bin/soar');
    }

    public $fieldMap = array(
        'sqlfinger' => 'id,sqls/getfinger',
    );

    public function getfinger($p)
    {
        list($id, $sqls) = $p;
        $rs              = PipeInterface::getInstance('soar')->get($sqls);
        if (empty($rs)) {
            return false;
        }
        $this->upItem[$id] = $rs;
        return false;
    }

    public function callback($p)
    {
        if ($this->upItem) {
            $sql = "UPDATE startrack.monitor_sql_prod SET sqlfinger = CASE id ";
            foreach ($this->upItem as $id => $finger) {
                $sql .= sprintf("WHEN %d THEN '%s' ", $id, addslashes($finger));
            }
            $sql .= 'END WHERE id IN (' . implode(array_keys($this->upItem), ',', ) . ')';
            \dormscript\Data\Library\Db::exeSql('write', $sql);
        }
        $this->upItem = [];
    }
}
