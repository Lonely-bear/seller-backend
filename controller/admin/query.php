<?php
/***************************************
 * 引入公共文件 
 **************************************/

require('../../database.php');
require('../../model/Response.php');

/***************************************
 * 获取参数
 **************************************/

$username = $_POST['username'];
$password = $_POST['password'];

/***************************************
 * 执行SQL
 **************************************/

$sql = "SELECT * FROM sys_admin WHERE username='$username'";
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
    // password -> md5加盐解密
    $salt = $response->data[0]['salt'];
    $password = md5($password.$salt);
    if($password !== $response->data[0]['password']) {
        unset($response->data);
        $response->data = [];
        $response->msg = '您输入的密码不正确';
    } else {
        $response->data[0]['password'] = "***";
        $response->data[0]['salt'] = "***";
    }
} else {
    $response->msg = '您输入的用户名不存在';
}

/***************************************
 * 返回响应
 **************************************/
echo json_encode($response);
$conn->close()

?>