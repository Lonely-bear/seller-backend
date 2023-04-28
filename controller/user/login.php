<?php
/***************************************
 * 引入公共文件 
 **************************************/

require('../../database.php');
require('../../model/Response.php');

/***************************************
 * 获取参数
 **************************************/

$openid = $_POST['openid'];

/***************************************
 * 执行SQL
 **************************************/

$sql = "SELECT * FROM pro_user WHERE openid=$openid";

$result = $conn->query($sql);

/***************************************
 * 数据处理
 **************************************/

$response = new Response();
$response->data = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response->data[] = $row;
    }
} else {
    $response->msg = '未查找到指定数据';
}

/***************************************
 * 返回响应
 **************************************/
echo json_encode($response);
$conn->close()

?>