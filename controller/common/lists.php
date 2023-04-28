<?php
/***************************************
 * 引入公共文件 
 **************************************/

require('../../database.php');
require('../../model/Response.php');

/***************************************
 * 获取参数
 **************************************/

$table_name = $_GET['table_name'];
$count = $_GET['count'];
$offset = ($_GET['page'] - 1) * $count;

/***************************************
 * 执行SQL
 **************************************/

$sql = "SELECT * FROM $table_name LIMIT $offset, $count";
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
}

/***************************************
 * 返回响应
 **************************************/

echo json_encode($response);
$conn->close()

?>