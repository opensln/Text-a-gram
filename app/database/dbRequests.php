<?php

require 'connect.php';
session_start();

function logProg($value)
{
    echo "<pre>", print_r($value, true), "</pre>";
    die();
}

function executeQuery($sql, $conditionsData)
{
    //logProg($conditionsData);
    global $conn;
    $stmt = $conn->prepare($sql);
    $values = array_values($conditionsData);
    //logProg($values);
    $types = str_repeat('s', count($values)); //the amount of conditions will determine the amount of types.
    $stmt->bind_param($types, ...$values);
    //logProg($stmt);
    $stmt->execute();
    return $stmt;

}

function selectAllWithAvatar($table, $conditions = [])
{

    global $conn;
    $sql ="SELECT p.*, u.avatar_image FROM post_table AS p JOIN user_table AS u ON p.poster_id_aka_user_id=u.user_id";
    // $sql = "SELECT p*, FROM $table";
    if (empty($conditions)) {
        //logProg($sql);
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $data;
    } else {
        //return records that match the given conditions

        $i = 0;
        foreach ($conditions as $key => $value) {
            if ($i === 0) {
                $sql = $sql . " WHERE $key=?";
            } else { $sql = $sql . " AND $key=?";

            }
            $i++;
        }
        // logProg($sql);
        $stmt = executeQuery($sql, $conditions);
        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $data;
    }

}

function getLatestComment($post_id) {
    global $conn;

    $sql ="SELECT c.*, u.username, u.avatar_image FROM comment_table AS c JOIN user_table AS u ON c.commenter_id_aka_user_id=u.user_id WHERE c.comment_post_id=? ORDER BY c.comment_id desc limit 1";

    $stmt = executeQuery($sql, ['comment_post_id'=> $post_id]);
    $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $data;

}

function getRelatedComments($post_id) {
    global $conn;

    $sql ="SELECT c.*, u.username, u.avatar_image FROM comment_table AS c JOIN user_table AS u ON c.commenter_id_aka_user_id=u.user_id WHERE c.comment_post_id=? ORDER BY c.comment_id desc";

    $stmt = executeQuery($sql, ['comment_post_id'=> $post_id]);
    $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    return $data;

}

//SelectOne

function selectOne($table, $conditions)
{

    global $conn;

    $sql = "SELECT * FROM $table";

    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else { $sql = $sql . " AND $key=?";

        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";
    // logProg($sql);
    $stmt = executeQuery($sql, $conditions);
    $data = $stmt->get_result()->fetch_assoc();
    return $data;
}


//SelectOne

function selectOneWithPostedByInfo($table, $conditions)
{

    global $conn;

    $sql = "SELECT p.*, u.username, u.avatar_image FROM post_table AS p JOIN user_table AS u ON p.poster_id_aka_user_id=u.user_id";
    //logProg($sql);
    $i = 0;
    foreach ($conditions as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " WHERE $key=?";
        } else { $sql = $sql . " AND $key=?";

        }
        $i++;
    }

    $sql = $sql . " LIMIT 1";
    //logProg($sql);
    $stmt = executeQuery($sql, $conditions);
    $data = $stmt->get_result()->fetch_assoc();
    return $data;
}

//Create

function create($table, $data) {
    global $conn;

    //Query Format $Sql = "INSERT INTO mobiles SET model=?,brand=?,price=?,release_date=?,image=?,Front Cam=?,tech_link=?"

    $sql = "INSERT INTO $table SET ";

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else { $sql = $sql . ", $key=?";

        }
        $i++;
    }
    //logProg($sql);
    $stmt = executeQuery($sql, $data);
    $id = $stmt->insert_id;
    return $id;
}

//Update  

function update($table, $id, $data) {
    global $conn;

    //logProg($data);


     //logProg($id);
     $idPrefix = substr($table,0,-6);
     //logProg($idPrefix);
 
     $adjusted_id_field = $idPrefix."_id";
    //logProg($adjusted_id_field);

    //Query Format $Sql = "UPDATE $table SET field=?, field=?, field=?, field=? WHERE id=?"

    $sql = "UPDATE $table SET"; 

    $i = 0;
    foreach ($data as $key => $value) {
        if ($i === 0) {
            $sql = $sql . " $key=?";
        } else { $sql = $sql . ", $key=?";

        }
        $i++;
    }

    //logProg($sql);

    $sql = $sql . " WHERE $adjusted_id_field"."=?"; //We need the field for the WHERE at the end.
    //logProg($sql);
  
    $data[$adjusted_id_field] = $id;
    //logProg($data);

    $stmt = executeQuery($sql, $data);
    return $stmt->affected_rows;
}

function delete($table, $id) {
    global $conn;

    //logProg($id);
    $idPrefix = substr($table,0,-6);
    //logProg($idPrefix);

    //Query Format $Sql = "DELETE FROM mobiles WHERE id=?"

    $adjusted_id_field = $idPrefix."_id";

    $sql = "DELETE FROM $table WHERE $adjusted_id_field"."=?"; 
    //logProg($sql);
   
    $stmt = executeQuery($sql, [$adjusted_id_field => $id]); //must be an array not a single object
    return $stmt->affected_rows;
}
