<!DOCTYPE html>

<!-- Fig. 19.21: dynamicForm.php -->
<!-- Dynamic form. -->
<html>
<head>
<meta charset = "utf-8">
<title>Registration Form</title>
<style type = "text/css">
p       { margin: 0px; }
.error  { color: red }
p.head  { font-weight: bold; margin-top: 10px; }
label   { width: 5em; float: left; }
</style>
</head>
<body>
<?php
function querydb($query, $db, $location, $username, $password, $dbport, $iserror) {
    if ( !( $database = mysql_connect( "aaakdox7k5o2fx.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306", "bmaple", "security") ) ){
        print( "<p>Could not connect to database</p>");
        die( mysql_error() . "</body></html>" );
    }

    if ( !mysql_select_db( "cis435p3", $database ) )
        die( "<p>Could not open MailingList database</p></body></html>" );

    if ( !( $result = mysql_query( $query, $database ) ) )
    {
        print( "<p>Could not execute query!</p>" );
        die( mysql_error() . "</body></html>" );
    } // end if 
    return $result;
}
//p3.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306
//instance identifier p3
//username = bmaple
//pass = security
// variables used in script
$timesOption = isset($_POST[ "timesOption" ]) ? $_POST[ "timesOption" ] : "";
$fname = isset($_POST[ "fname" ]) ? $_POST[ "fname" ] : "";
$lname = isset($_POST[ "lname" ]) ? $_POST[ "lname" ] : "";
$email = isset($_POST[ "email" ]) ? $_POST[ "email" ] : "";
$phone = isset($_POST[ "phone" ]) ? $_POST[ "phone" ] : "";
$umid = isset($_POST[ "umid" ]) ? $_POST[ "umid" ] : "";
$dbname = "cis435p3";
$dbloc ="aaakdox7k5o2fx.ccg2fbosv7le.us-west-2.rds.amazonaws.com";
$dbport = "3306";
$dbuser ="bmaple";
$dbpass ="security";
$stu_query = "select * from student";
$times_query = "SELECT demoDate, date_format(timeStart, '%r'), date_format(timeEnd, '%r'), id FROM timeslot";
$numReg_query = "select timeslot.id, count(*), timeslot.maxSlots".
    " from timeslot".
    " join student on timeslot.id = student.timeslot_id".
    " group by student.timeslot_id";
$iserror = false;
$isDup = false;
$dupID = 0;
$perfectDup = false;
$formerrors = array( "fnameerror" => false, "lnameerror" => false, "emailerror" => false, "phoneerror" => false, "umiderror" => false, "timesOptionerror" => false, );
// array of name values for the text input fields
$inputlist = array( 
    "fname" => "First Name",
    "lname" => "Last Name", 
    "email" => "Email",
    "umid" => "UMID",
    "phone" => "Phone",
);
$numReg = querydb($numReg_query, $dbname, $dbloc, $dbuser, $dbpass, $dbport, $iserror);
$students = querydb($stu_query, $dbname, $dbloc, $dbuser, $dbpass, $dbport, $iserror); 
$times = querydb($times_query,$dbname, $dbloc, $dbuser, $dbpass, $dbport, $iserror);

// ensure that all fields have been filled in correctly
if ( isset( $_POST["submit"] ) ) {
    while($row = mysql_fetch_row($numReg)){
        if ($row[0] == $timesOption){
            if( $row[1] > $row[2]) {
                $formerrors[ "timesOptionerror" ] = true;
                $iserror = true;
            }
        }
    }
    while($row = mysql_fetch_assoc($students)) {
        if( $row['umid'] == $umid ){
            $isDup = true;
            if($row['timeslot_id'] == $timesOption)
                $perfectDup = true;
            $dupID = $row['id'];
            break;
        }
    }
    if ( !preg_match("/^\w+$/", $fname)) {
        $formerrors[ "fnameerror" ] = true;
        $iserror = true;
    } 
    if ( !preg_match("/^\w+$/", $lname)) {
        $formerrors[ "lnameerror" ] = true;
        $iserror = true;
    } 
    if ( !preg_match("/^\w+\@(\w{1,19}\.){1,3}\w{1,20}$/", $email)) {
        $formerrors[ "emailerror" ] = true;
        $iserror = true;
    } 
    if ( !preg_match( "/^[0-9]{4}-[0-9]{4}$/", $umid) ) {
        $formerrors[ "umiderror" ] = true;
        $iserror = true;
    } 
    if ( !preg_match( "/^\([0-9]{3}\)[0-9]{3}-[0-9]{4}$/", $phone ) ) {
        $formerrors[ "phoneerror" ] = true;
        $iserror = true;
    } 
    // build INSERT query
    $insert_query = "INSERT INTO student" .
        "( lname, fname, email, phone, umid, timeslot_id) " .
        "VALUES ( '$lname', '$fname', '$email', " .
        "'" . mysql_real_escape_string( $phone ) .
        "', '$umid', '$timesOption' )";
    if (!$iserror && !$isDup) {
        $result = querydb($insert_query, $dbname, $dbloc, $dbuser, $dbpass, $dbport, $iserror);
        print( "<p>Hi $fname. Thank you for completing the survey.
            You have been added to the timeslot book mailing list.</p>
            <p class = 'head'>The following information has been
            saved in our database:</p>
            <p>Name: $fname $lname</p>
            <p>Email: $email</p>
            <p>Phone: $phone</p>
            <p>UMID: $umid</p>
            <p><a href = 'formDatabase.php'>Click here to view
            entire database.</a></p>
            <p class = 'head'>This is only a sample form.
            You have not been added to a mailing list.</p>
            </body></html>" );
        die(); // finish the page
    }
} // end if
if ( isset( $_POST["update"] ) ) {
    $update_query = "UPDATE student".
        " SET timeslot_id = $timesOption".
        " WHERE id = '$dupID'";
    print("<p>UPDATE student SET timeslot_id = $timesOption WHERE id = '$dupID'</p>");
    $result = querydb($update_query, $dbname, $dbloc, $dbuser, $dbpass, $dbport, $iserror);
    print("<p>Thanks for changing your timeslot $fname.</p><a href = 'formDatabase.php'>Click here to view
        entire database.</a></body></html>" );
    die();
}

print( "<h1>Sign up for a project slot</h1>
    <p>Please fill in all fields and click Register.</p>" );

if ( $iserror ) {
    print( "<p class = 'error'>Fields with * need to be filled
        in properly.</p>" );
} // end if

print( "<!-- post form data to dynamicForm.php -->
    <form method = 'post' action = 'index.php'>
    <h2>Your information</h2>

    <!-- create four text boxes for user input -->" );
foreach ( $inputlist as $inputname => $inputalt ) {
    print( "<div><label>$inputalt:</label><input type = 'text'
        name = '$inputname' value = '" . $$inputname . "'>" );

    if ( $formerrors[ ( $inputname )."error" ] == true )
        print( "<span class = 'error'>*</span>" );

    print( "</div><br />" );
} // end foreach

print( "<h2>Timeslots</h2>
    <select name='timesOption'>" );
while($row = mysql_fetch_row($times)){
    echo "<option value = {$row[3]}>";
    echo $row[0];
    echo ' - ';
    echo $row[1];
    echo ' - ';
    echo $row[2];
    echo '</option>';
}
print "</select>";
if (!$iserror && $isDup && !$perfectDup) {
    print("<p> $fname, you have already registered before.</p>
        <p>Any new submission will change your timeslot.</p>
        <input type = 'submit' name = 'update' value = 'update'>");
}
else if($perfectDup)
    print("<p> $fname, you have already registered for this timeslot");

if ( $formerrors[ "timesOptionerror" ] == true )
    print( "<span class = 'error'>* This time slot is full</span>" );
print( "<p class = 'head'>
    <input type = 'submit' name = 'submit' value = 'Register'>
    </p>
    </form>
    </body>
    </html>" );
?>
<!-- end PHP script -->
