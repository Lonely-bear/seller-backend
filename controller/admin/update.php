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
$uid = $_POST['uid'];
$username = $_POST['username'];
$password = $_POST['password'];
$nickname = $_POST['nickname'];
$last_logintime = new DateTime();
$last_logintime = $last_logintime->format("Y-m-d H:i:s");

/***************************************
 * 自定义函数
 **************************************/

/**
 * 1. 判断用户名是否已存在
 */
function adminExist($conn ,$target) {
    $result = $conn->query("SELECT * FROM sys_admin WHERE username='$target'");
    if($result->num_rows > 0) {
        return true;
    }else{
        return false;
    }
}

/***************************************
 * 执行SQL
 **************************************/

$response = new Response();
$response->data = [];
$sql = "";
switch($type) {
    // 新增管理员
    case "add":
        // password -> md5加盐加密
        $salt = substr(uniqid(), -6);
        $password = md5($password.$salt);
        if(!adminExist($conn, $username)) {
            $sql = "INSERT INTO sys_admin (username, password, salt, nickname, last_logintime) VALUES ('$username', '$password', '$salt', '$nickname', '$last_logintime')";
        } else {
            $response->msg = '该用户名已存在';
        }
        break;
    // 修改管理员信息
    case "edit":
        $sql = "UPDATE sys_admin SET username='$username', nickname='$nickname' WHERE uid=$uid";
        break;
    // 修改管理员密码
    case "changepass":
        $salt = substr(uniqid(), -6);
        $password = md5($password.$salt);
        $sql = "UPDATE sys_admin SET password='$password', salt='$salt' WHERE uid=$uid";
        break;
    // 删除指定管理员
    case "delete":
        $sql = "DELETE FROM sys_admin WHERE uid=$uid";
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
    $response->msg = "更新用户成功";
}

/***************************************
 * 返回响应
 **************************************/

echo json_encode($response);
$conn->close()

?>