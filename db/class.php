<?php
/**
 * MySQl simple abstraction layer.
 * It can manage and obtain additional information from an mysql_query
 * The same object can manage many querys, but it is recommended to use one object for each query
 * @autor C�sar Bruschi
 * @since 03/2010
 */
class Db
{
    private $host;
    private $username;
    private $password;
    private $db; //BBDD
    private $query; //Resource
    private $sql; //Statement
    public  $link; //Connection
    public  $numRows = 0; //Num or affected rows
    public  $numFields = 0; //Num fields
    public  $fiels = array(); //Fields data
    private $debug = false; //Sets debug mode true or false
    public  $insert_id = 0; // Last insert ID

    /**
     * Connects to the Db and makes the query
     * @param <string> $host
     * @param <string> $username
     * @param <string> $password
     * @param <string> $db
     * @param <bool> $debug
     */
    public function Db($host, $username, $password, $db, $debug)
    {

        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->debug = $debug;
      //  if($this->debug) echo "Modo debug activado. Cliente: ".mysql_get_client_info()."<br />";
   

        if(!$this->link = mysql_connect($this->host, $this->username, $this->password))
                die("Cannot connect to server (".mysql_errno().") ".mysql_error());
        
        if(!$this->db = mysql_select_db($db, $this->link))
                die("Cannot select database (".mysql_errno().") ".mysql_error());
     //   if($this->debug) echo "Conectado a $this->host como $this->username a las ".date("H:i:s").". DB seleccionada: $db<br />";
    }

    /**
     * Executes a mysql_query and gets some additional information
     * @param <string> $sql
     * @return <resource>  mysql_resource
     */
    public function query($sql)
    {
        $this->sql = $sql;
        if(!is_resource($this->link)) die ("It has lost the connection to the DB. ".mysql_error());
        if(!$this->query = mysql_query($this->sql, $this->link)) die("Unable to perform query (".mysql_error().") ".mysql_error());

       // if($this->debug) echo "Realizada la consulta $this->sql.  Host ".mysql_get_host_info()."<br />";
        //Registros obtenidos o afectados
        if(!strpos("SELECT", $this->sql))
        {
            $this->numRows = mysql_num_rows($this->query);
            $this->numFields = mysql_num_fields($this->query);
            $this->insert_id = mysql_insert_id();
        } else { $this->numRows = mysql_affected_rows($this->query); }

      //  if($this->debug) echo "Consultados $this->numRows registros.<br />";

        return $this->query;
    }

    /**
     * Executes and unbuffered query if needed
     * @param <string> $sql
     * @return <resource>  mysql_resource
     */
    public function unbuffered_query($sql)
    {
        $this->sql = $sql;
        if(!is_resource($this->link)) die ("Se ha perdido la conexi�n con la DB. ".mysql_error());
        if(!$this->query = mysql_unbuffered_query($this->sql, $this->link)) die("Imposible realizar consulta (".mysql_error().") ".mysql_error());

        if($this->debug) echo "Realizada la consulta sin buffer $this->sql.<br />";
        //Registros obtenidos o afectados
         
        if($this->debug) echo "Consulta sin b?ffer, no hay informaci�n adicional.<br />";

        return $this->query;
    }

    /**
     * Gets the information of the fields and returns it into an array
     * @return <array>
     */
    public function getFieldsData()
    {
    //Numero de campos
        if($this->debug) echo "La consulta contiene $this->numFields campos.<br />";

        //Nombres de los campos y sus propiedades
        $i = 0;
        while($i<$this->numFields)
        {

            $this->fields[mysql_field_name($this->query, $i)] = array(
                'type' => mysql_field_type($this->query, $i),
                'len' => mysql_field_len($this->query, $i),
                'table' => mysql_field_table($this->query, $i));
            $i++;
        }
        //Devuelvo array
        return $this->fields;
    }

    /**
     * Performs a mysql_fetch_assoc function, no need to indicate the resource
     * @return <array>
     */
    public function fetch_assoc()
    {
        return mysql_fetch_assoc($this->query);

    }

    /**
     * Performs a mysql_fetch_array function, no need to indicate the resource
     * @return <array>
     */
    public function fetch_array()
    {
        return mysql_fetch_array($this->query);
    }

    /**
     * Gets a field name with the mysql_field_name function
     * @param <int> $index, the field to query
     * @return <string> , the field $index name
     */
    public function field_name($index)
    {
        return mysql_field_name($this->query, $index);

    }

    /**
     * Gets a field lenght with the mysql_field_length function
     * @param <int> $index, the field to query
     * @return <int> , the field $index lenght
     */
    public function field_len($index)
    {
        return mysql_field_len($this->query, $index);

    }

     /**
     * Gets a field table name with the mysql_field_table function
     * @param <int> $index, the field to query
     * @return <string> , the field $index table name
     */
    public function field_table($index)
    {
        return mysql_field_table($this->query, $index);

    }

    /**
     * Gets the las insert id
     * @return <int>
     */
    public function insert_id()
    {
        return $this->insert_id;
    }

    /**
     * Fetchs a query like and object, see the php manual for more information
     * @return <array>
     */
    public function fetch_object()
    {
        return mysql_fetch_object($this->query);
    }

    /**
     * Closes any open connection and frees any resource that may be open
     */
    public function _destruct()
    {
      //  if(is_resource($this->query)) mysql_free_result($this->query);
      //  if(mysql_ping($this->link)) mysql_close($this->link);
         if(!$this->db)
          mysql_close($this->db);
     }

}
?>
