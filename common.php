<?php
    function addNew($table,$data) {
        global $conn;
        if(is_array($data)) {
            $field="";
            $val="";
            $i=0;
            foreach($data as $key=>$value) {
                if($key!="addNew") {
                    $i++;
                    if($i==1) {
                        $field .=$key;
                        $val .="'".$value."'";
                    } else {
                        $field .=",".$key;
                        $val .=",'".$value."'";
                    }
                }
            }
        }

        $sqlInsert = "INSERT INTO $table ($field) VALUES($val)";
        $conn->exec($sqlInsert) or die("Lỗi câu lệnh thêm mới " .$sqlInsert);
    }
?>