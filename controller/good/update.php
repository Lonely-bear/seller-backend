<?php
/***************************************
 * 引入公共文件 
 **************************************/

require('../../database.php');
require('../../model/Response.php');

/***************************************
 * 获取参数
 **************************************/

$type = $_POST['type'];
$gid = $_POST['gid'];
$sid = $_POST['sid'];
$tid = $_POST['tid'];
$name = $_POST['name'];
$imgURL = $_POST['imgURL'];
$num = $_POST['num'];
$price = $_POST['price'];
$gtype = $_POST['gtype'];
$status = $_POST['status'];

/***************************************
 * 自定义函数
 **************************************/

////////////////////////////////////////

/***************************************
 * 执行SQL
 **************************************/

$response = new Response();
$response->data = [];
$sql = "";
switch($type) {
    // 新增系统配置
    case "add":
        $sql = "INSERT INTO pro_good (sid, tid, name, imgURL, num, price, type, status) 
                VALUES ($sid, $tid, '$name', '$imgURL', $num, '$price', '$gtype', $status)";
        break;
    // 修改系统配置信息
    case "edit":
        $sql = "UPDATE pro_good 
                SET sid=$sid, tid=$tid, name='$name', imgURL='$imgURL', num=$num, price='$price', type='$gtype', status=$status 
                WHERE gid=$gid";
        break;
    // 删除指定系统配置
    case "delete":
        $sql = "DELETE FROM pro_good WHERE gid=$gid";
        break;
    default:
        break;
}
if($sql !== "") {
    $result = $conn->query($sql);
}

/***************************************
 * 数据处理
 **************************************/

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response->data[] = $row;
    }
}

if($result === true) {
    $response->msg = "更新数据成功";
} else {
    $response->msg = "更新数据失败";
}

/***************************************
 * 返回响应
 **************************************/

echo json_encode($response);
$conn->close()

?>