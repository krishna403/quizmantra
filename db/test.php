<?php
/* 
 * Class DB examples
 */
include_once("Class.Db.php");

//Example 1: simple query
//The constructor connects to the Db, the TRUE param sets the "Debugger mode", wich gives information on the operations
$db = new Db("localhost","root","pass","information_schema", true);

$db->query("select * from character_sets limit 0,20");

echo "Query has: ".$db->numRows." rows.<br />";
while($data = $db->fetch_assoc()){
    echo "Desc: ".$data['DESCRIPTION'].", MaxLen: ".$data['MAXLEN']."<br />";
}

echo "Here goes the fields data for ".$db->numFields." fields.<br />";
$fields = $db->getFieldsData();
print_r($fields);
// No need to close the connection manually, the object does it

?>
