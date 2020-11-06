<?php

$fileName = '';
$title = '';
$memos = '';
$fileNum = '';

$memos = [];
$names = [];

// function dbConnect() {

// try {
//     # hostには「docker-compose.yml」で指定したコンテナ名を記載
//     $dsn = "mysql:host=db;dbname=book_log;";
//     $db = new PDO(
//         $dsn,
//         'book_log',
//         'pass');

//     $sql = "SELECT * FROM memos";
//     $stmt = $db->prepare($sql);
//     $stmt->execute();
//     $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     return $result;

// } catch (PDOException $e) {
//     echo $e->getMessage();
//     exit;
// }

// }

function oldFilenameView()
{

    try {
        $dsn = "mysql:host=db;dbname=book_log;";
        $user = "book_log";
        $password = "pass";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT file_number, file_name FROM file_names";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        echo "既存のファイル名を表示します" . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
        if (empty($result)) {
            echo "なし" . PHP_EOL;
            echo PHP_EOL;
        } else {
            foreach ($result as $key => $vals) {
                echo $key . "  " . $vals . PHP_EOL;
            }
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function addToExistingFile()
{

    try {
        $dsn = "mysql:host=db;dbname=book_log;";
        $user = "book_log";
        $password = "pass";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'INSERT INTO memos(file_number,title,
memos) VALUES (?,?,?)';
        $stmt = $dbh->prepare($sql);

        echo "メモを追加します" . PHP_EOL;
        echo PHP_EOL;
        echo "メモを追加したいファイルの番号を入力して下さい" . PHP_EOL;
        $number = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
        echo PHP_EOL;
        echo "タイトルを入力して下さい" . PHP_EOL;
        $title = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
        echo PHP_EOL;
        echo "メモを入力して下さい" . PHP_EOL;
        $memos = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
        echo PHP_EOL;
        $data = array();
        $data[] = $number;
        $data[] = $title;
        $data[] = $memos;

        $stmt->execute($data);

        $dbh = null;

        echo "新しいメモが登録されました" . PHP_EOL;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}


// function createFilename(){

//     try {
//         # hostには「docker-compose.yml」で指定したコンテナ名を記載
//         $dsn = "mysql:host=db;dbname=book_log;";
//         $user = "book_log";
//         $password = "pass";
//         $dbh = new PDO($dsn,$user,$password);
//         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $sql = <<<EOT
//         "INSERT INTO file_names(
//             file_name
//             ) VALUES (
//                 ?)";
// EOT;
//         $stmt = $dbh->prepare($sql);

//         oldFilenameView();

//         echo PHP_EOL .'既に登録されているファイル名'.PHP_EOL;
//         echo '-------------------------------------'.PHP_EOL;
//         if (empty($result)){
//             echo "なし".PHP_EOL;
//             echo PHP_EOL;
//         }else{
//         while ($result){
//             echo $result['file_number'] ."　". $result['file_name'];

//         }
//         echo '-------------------------------------'.PHP_EOL;
//         echo  PHP_EOL;
//         echo 'ファイル名を登録してください' .PHP_EOL;
//         echo 'ファイル名:';
//         $fileName = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//         (STDIN)) .PHP_EOL;

//         $data[] = $fileName;
//         $stmt->execute($data);

//         $dbh = null;

//         echo "新しいファイルが作成されました" .PHP_EOL;


//     } catch (Exception $e) {
//         echo $e->getMessage();
//         exit;
//     }

//     }
// }

function createNewFile()
{

    oldFilenameView();
    try {
        # hostには「docker-compose.yml」で指定したコンテナ名を記載
        $dsn = "mysql:host=db;dbname=book_log;";
        $user = "book_log";
        $password = "pass";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'INSERT INTO file_names(file_name) VALUES (?)';
        $stmt = $dbh->prepare($sql);

        echo "新しいファイルを追加します" . PHP_EOL;
        echo PHP_EOL;
        echo "ファイル名を入力してください" . PHP_EOL;
        $fileName = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|S[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));

        $fileName = $str = str_replace(PHP_EOL, '', $fileName);

        $data[] = $fileName;

        $stmt->execute($data);

        echo "新しいファイルが登録されました" . PHP_EOL;

        $sql = 'SELECT LAST_INSERT_ID()';
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $lastFileNumber = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo PHP_EOL;

        echo "続いてメモを追加します" . PHP_EOL;
        echo PHP_EOL;
        echo "タイトルを入力して下さい" . PHP_EOL;
        $title = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
        echo PHP_EOL;
        echo "メモを入力して下さい" . PHP_EOL;
        $memos = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
        echo PHP_EOL;
        $data = array();
        $data[] = (int)$lastFileNumber;
        $data[] = $title;
        $data[] = $memos;

        $stmt->execute($data);

        $dbh = null;

        echo "新しいファイルにメモが追加されました" . PHP_EOL;
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }
}

//  function createMemo($number){

//     try {
//         # hostには「docker-compose.yml」で指定したコンテナ名を記載
//         $dsn = "mysql:host=db;dbname=book_log;";
//         $user = "book_log";
//         $password = "pass";
//         $dbh = new PDO($dsn,$user,$password);
//         $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         $sql = <<<EOT
//         "INSERT INTO file_names(
//             file_number,
//             title,
//             memos,
//             ) VALUES (
//                 '?','?','?')";
// EOT;
//         $stmt = $dbh->prepare($sql);

//         echo "メモを追加します"　.PHP_EOL;
//         echo PHP_EOL;
//         echo "タイトルを入力して下さい" .PHP_EOL;
//         $title = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//         (STDIN)) .PHP_EOL;
//         echo "メモを入力して下さい" .PHP_EOL;
//         $memos = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//         (STDIN)) .PHP_EOL;

//         $data[] = $number;
//         $data[] = $title;
//         $data[] = $memos;

//         $stmt->execute($data);

//         $dbh = null;

//         echo "新しいメモが登録されました" .PHP_EOL;

//         } catch (Exception $e) {
//         echo $e->getMessage();
//         exit;
//         }

// }
//     oldFilenameView();

//     echo PHP_EOL .'既に登録されているファイル名'.PHP_EOL;
//     echo '-------------------------------------'.PHP_EOL;
//     if (empty($result)){
//         echo "なし".PHP_EOL;
//         echo PHP_EOL;
//     }else{
//     while ($result){
//         echo $result['file_number'] ."　". $result['file_name'];

//     }
//     echo '-------------------------------------'.PHP_EOL;
//     echo  PHP_EOL;
//     echo 'ファイル名を登録してください' .PHP_EOL;
//     echo 'ファイル名:';
//     $fileName = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//     (STDIN)) .PHP_EOL;
//     echo 'タイトル:';
//     $title = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//     (STDIN)) .PHP_EOL;
//     echo 'メモ:';
//     $memos = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//     (STDIN)) .PHP_EOL;

//     echo 'メモの追加が完了しました' .PHP_EOL.PHP_EOL;

//     return [
//         "$fileName" =>
//         ["title" => "$title",
//          "memos" => "$memos"]];
// };

// function oldCreateMemo($memos){
//     $arrKey= '';
//     var_export($memos);
//     foreach($memos as $key=>$vals){
//         foreach($vals as $key2=>$vals2){
//             echo PHP_EOL;
//             echo '['.$key.']'.'  '.$key2.PHP_EOL;
//             $arrKey = $key;
//         }}
//     echo '追加するファイルのナンバーを入力して下さい' .PHP_EOL;
//     echo 'ファイルナンバー:';
//     $fileName = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//     (STDIN)) .PHP_EOL;
//     echo 'タイトル:';
//     $title = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//     (STDIN)) .PHP_EOL;
//     echo 'メモ:';
//     $memos = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets
//     (STDIN)) .PHP_EOL;

//     echo 'メモの追加が完了しました' .PHP_EOL.PHP_EOL;

//     return [
//         "$fileName" =>
//         ["title" => "$title",
//          "memos" => "$memos"]];

//          $fileNum;
// };

function listMemos()
{
    try {
        $dsn = "mysql:host=db;dbname=book_log;";
        $user = "book_log";
        $password = "pass";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT file_name , title , memos FROM file_names,memos WHERE file_names.file_number=memos.file_number";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "既存のファイル名を表示します" . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
        if (empty($result)) {
            echo "なし" . PHP_EOL;
            echo PHP_EOL;
        } else {
            foreach ($result as $key => $vals) {
                echo PHP_EOL;
                echo '-------------------------------------' . PHP_EOL;
                echo "【 ファイル名 】" . PHP_EOL;
                echo PHP_EOL;
                echo "　" . $vals['file_name'] . PHP_EOL;
                echo PHP_EOL;
                echo "【 タイトル 】" . PHP_EOL;
                echo PHP_EOL;
                echo "　" . $vals['title'];
                echo PHP_EOL;
                echo PHP_EOL;
                echo "【 メモ 】" . PHP_EOL;
                echo PHP_EOL;
                echo "　" . $vals['memos'];
                echo PHP_EOL;
                echo PHP_EOL;
                //                echo $key . "  " . $vals . PHP_EOL;
            }
        }
        $dbh = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function fileSerch()
{
    try {
        $dsn = "mysql:host=db;dbname=book_log;";
        $user = "book_log";
        $password = "pass";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT file_number , file_name FROM file_names WHERE file_number = ?';
        $stmt = $dbh->prepare($sql);
        echo PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
        echo PHP_EOL;
        echo "既存のファイル名を以下に表示しています" . PHP_EOL;
        echo '-------------------------------------' . PHP_EOL;
        oldFilenameView();
        echo '-------------------------------------' . PHP_EOL;
        echo  PHP_EOL;
        echo "表示したいファイルの番号を入力しEnterを押して下さい" . PHP_EOL;
        $fileNumber = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));

        $data = array();
        $data[] = (int)$fileNumber;
        $stmt->execute($data);
        $result1 = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

        foreach ($result1 as $key => $val) {
            echo PHP_EOL;
            echo "【 ファイル名 】" . PHP_EOL;
            echo PHP_EOL;
            echo "　" . $val;
        }

        $sql = 'SELECT title,memos FROM memos WHERE file_number = ?';
        $stmt = $dbh->prepare($sql);
        $data = array();
        $data[] = (int)$fileNumber;
        $stmt->execute($data);
        $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo PHP_EOL;

        foreach ($result2 as $key => $val) {
            echo PHP_EOL;
            echo "【 タイトル 】" . PHP_EOL;
            echo PHP_EOL;
            echo "　" . $val['title'];
            echo PHP_EOL;
            echo PHP_EOL;
            echo "【 メモ 】" . PHP_EOL;
            echo PHP_EOL;
            echo "　" . $val['memos'];
            echo PHP_EOL;
            echo PHP_EOL;
            echo '-------------------------------------' . PHP_EOL;
        }
        echo PHP_EOL;
        echo PHP_EOL;
        $dbh = null;
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}


function createFlow()
{
    echo '-------------------------------------' . PHP_EOL;
    echo "新しいファイルを作成　　　　　　　⇒ 1" . PHP_EOL;
    echo "既存のファイルに追加　　　　　　　⇒ 2" . PHP_EOL;
    echo '-------------------------------------' . PHP_EOL;
    echo PHP_EOL;
    echo "1 , 2 のどちらかを選択しEnterを押してください :";
    $answer = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
    echo '-------------------------------------' . PHP_EOL;
    if ($answer === "1") {
        createNewFile();
    } elseif ($answer === "2") {
        oldFilenameView();
        addToExistingFile();
    }
}
while (true) {
    echo PHP_EOL;
    echo '-------------------------------------' . PHP_EOL;
    echo "メモを作成する　　　　　　　　　　⇒　1" . PHP_EOL;
    echo "メモを全て表示　　　　　　　　　　⇒　2" . PHP_EOL;
    echo "ファイル名を指定して表示　　　　　⇒　3" . PHP_EOL;
    echo "アプリを終了　　　　　　　　　　　⇒　9" . PHP_EOL;
    echo '-------------------------------------' . PHP_EOL;
    echo "番号を選択し、Enterを押してください ：";
    $answer = preg_replace("/\A[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++|[\\x0-\x20\x7F\xC2\xA0\xE3\x80\x80]++\z/u", '', fgets(STDIN));
    echo '-------------------------------------' . PHP_EOL;



    if ($answer === "1") {
        createFlow();
    } elseif ($answer === "2") {
        //一覧表示用
        listMemos();
    } elseif ($answer === "3") {
        //検索表示
        fileSerch();
    } elseif ($answer === "9") {
        echo PHP_EOL;
        echo PHP_EOL;
        echo "アプリケーションを終了します" . PHP_EOL;
        echo "お疲れさまでした" . PHP_EOL;
        echo PHP_EOL;
        echo PHP_EOL;
        break;
    } else {
        echo PHP_EOL;
        echo PHP_EOL;
        echo PHP_EOL;
        echo "１ , 2 , 3,  9 のいずれかで選択してください";
        echo PHP_EOL;
        echo PHP_EOL;
    };
};



// $memos = [
// ["例" =>["例" => ["例" => "例" , "例" => "例"]]],
// ["10/21" =>["title" => ["daytitle" => "21" , "memos" => "21の中身"]]],
// ["10/22" =>["title" => ["daytitle" => "22" , "memos" => "22の中身"]]],
// ];

// foreach($memos as $key=>$vals){
//     foreach($vals as $vals2){
// var_export($key);
// // var_export($vals2['daytitle']);
// // var_export($vals2);
//     }
// }
