
    <?php
    class database{
        private $host;
        private $dbusername;
        private $dbpassword;
        private $dbname;

    protected function connect()
        {
            $this->host = 'localhost';
            $this->dbusername = 'root';
            $this->dbpassword = '';
            $this->dbname = 'oopcrud';
            $con = new mysqli($this->host, $this->dbusername, $this->dbpassword, $this->dbname);
            return $con;
        }
    }

    class query extends database{
        public function getData($field="", $table="", $condition_arr, $order_by_field="", $order_by_type="", $limit=""){
            $sql = "select $field from $table";
            if($condition_arr != ""){
                $sql .= " where";
                $count = count($condition_arr);
                $i = 1;
                foreach($condition_arr as $key=>$val){
                    if($i == $count){
                        $sql .= " $key='$val' ";
                    }else{
                        $sql .= " $key='$val' and ";

                    }
                $i++;
                    
                }
            }
            if($order_by_field != ""){
                $sql .= " order by $order_by_field $order_by_type ";
            }
            if($limit != ""){
                $sql .= " limit $limit ";
            }
            $result = $this->connect()->query($sql);
           if($result->num_rows > 0){
               $arr = array();
           while($row = $result->fetch_assoc()){
                $arr[] = $row;  
               }
               return $arr;
           }else{
               return 0;
           }
        }

        public function insertData($table, $condition_arr){
            if($condition_arr != ""){
                foreach($condition_arr as $key=>$val){
                    $fieldArr[] = $key;
                    $valueArr[] = $val;   
                }
               $field = implode(",", $fieldArr);
               $value = implode("','", $valueArr);
               $value = "'".$value."'";
            $sql = "insert into $table($field) values($value)";
              $result = $this->connect()->query($sql);
            }
        }

        public function deleteData($table, $condition_arr){
            $sql = " delete from $table where ";
            if($condition_arr != ""){
                $count = count($condition_arr);
                $i = 1;
                foreach($condition_arr as $key=>$val){
                    if($i == $count){
                        $sql .= " $key='$val' ";
                    }else{
                        $sql .= " $key='$val' and ";

                    }
                $i++;
                }
              $result = $this->connect()->query($sql);
            }
        }

        public function updateData($table, $condition_arr, $where_field, $where_value){
            if($condition_arr != ""){
            $sql = " update $table set ";
                $count = count($condition_arr);
                $i = 1;
                foreach($condition_arr as $key=>$val){
                    if($i == $count){
                        $sql .= " $key='$val' ";
                    }else{
                        $sql .= " $key='$val', ";

                    }
                $i++;
                }
                $sql .= " where $where_field='$where_value' ";
              $result = $this->connect()->query($sql);
            }
        }
    }
