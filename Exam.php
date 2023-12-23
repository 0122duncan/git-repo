<?php
require_once 'function/DBConnectionHandler.php';

$serverName = "140.127.74.201:9001";
$userName = "root";
$password = "root";
$db = 'bigdata';

try{
    DBConnectionHandler::setConnection(
        $serverName,
        $userName,
        $password,
        $db
    );
    $connection = DBConnectionHandler::getConnection();
    echo "success";
}catch(Exception $e){
    echo "ERROR".$sql . "<br>" . $e->getMessage();
}


/*
-----------------------------------------------------
hw starts here
-----------------------------------------------------
*/

//1-1
$sql = "Select Count(Distinct dp001_review_sn) AS result From edu_big_imp1 Where PseudoID=:ID";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':ID',39);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//1-2
$sql = "SELECT Count(Distinct dp001_question_sn) As result 
        From edu_bigdata_imp 
        Where PseudoID=:ID 
        And dp001_question_sn !=:VAL";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':ID',39);
$stmt->bindValue(':VAL','NA');
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//2-1
$sql = "SELECT dp001_video_item_sn, dp001_indicator
        FROM edu_bigdata_imp 
        WHERE PseudoID = :ID
        GROUP BY dp001_video_item_sn, dp001_indicator";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':ID',281);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//2-2
$sql = "SELECT COUNT(*) AS correct_records_count
        FROM edu_bigdata_imp 
        WHERE PseudoID = :ID
        AND dp001_prac_score_rate = 100";

$stmt = $connection->prepare($sql);
$stmt->bindValue(':ID', 281);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//3-1
$sql = "SELECT COUNT(dp001_record_plus_view_action) AS result
        From edu_bigdata_imp1 
        Where dp001_record_plus_view_action = :VAL
        And PseudoID =:ID";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':ID', 281);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//3-2
$sql = "SELECT Distinct Date(dp001_review_start_time),Date(dp001_review_end_time)
        From edu_bigdata_imp1 
        Where PseudoID =:ID
        Group By dp001_review_start_time,dp001_review_end_time";
$stmt = $connection->prepare($sql);
$stmt->bindValue(':ID', 71);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//4-1
$sql = "SELECT dp001_review_sn, COUNT(*) AS total_views
        FROM edu_bigdata_imp.dp001
        GROUP BY dp001_review_sn
        ORDER BY total_views DESC
        LIMIT 1";
$stmt = $connection->prepare($sql);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//4-2
$sql = "SELECT COUNT(*) AS total_records
        FROM edu_bigdata_imp.dp002
        WHERE dp002_extensions_alignment LIKE '%十二年國民基本教育%'";
$stmt = $connection->prepare($sql);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//4-3
$sql = "SELECT dp002_verb_display_zh_TW, COUNT(*) AS action_count
        FROM edu_bigdata_imp.dp002
        WHERE dp002_verb_display_zh_TW IS NOT NULL
        AND dp002_verb_display_zh_TW <> 'NA'
        GROUP BY dp002_verb_display_zh_TW
        ORDER BY action_count DESC
        LIMIT 3";
$stmt = $connection->prepare($sql);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);


//4-4
$sql = "SELECT COUNT(*) AS total_records
        FROM edu_bigdata_imp.dp002
        WHERE dp002_extensions_alignment LIKE '%校園職業安全%'";
$stmt = $connection->prepare($sql);
$stmt->execute();
$r = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($r);

?>