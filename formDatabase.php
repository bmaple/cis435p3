<!DOCTYPE html>

<!-- Fig. 19.22: formDatabase.php -->
<!-- Displaying the MailingList database. -->
<html>
   <head>
      <meta charset = "utf-8">
      <title>Search Results</title>
      <style type = "text/css">
         table  { background-color: lightblue;
                  border: 1px solid gray;
                  border-collapse: collapse; }
         th, td { padding: 5px; border: 1px solid gray; }
         tr:nth-child(even) { background-color: white; }
         tr:first-child { background-color: lightgreen; }
      </style>
   </head>
   <body>
      <?php
         // build SELECT query
         $query = "SELECT * FROM student";

         // Connect to MySQL
         if ( !( $database = mysql_connect( "aaakdox7k5o2fx.ccg2fbosv7le.us-west-2.rds.amazonaws.com:3306", "bmaple", "security") ) ){
             print( "<p>Could not connect to database</p>");
                die( mysql_error() . "</body></html>" );
         }
         if ( !mysql_select_db( "cis435p3", $database ) )
            die( "<p>Could not open MailingList database</p></body></html>" );

         // query MailingList database
         if ( !( $result = mysql_query( $query, $database ) ) )
         {
            print( "<p>Could not execute query!</p>" );
            die( mysql_error() . "</body></html>" );
         } // end if
      ?><!-- end PHP script -->

      <h1>Mailing List Contacts</h1>
      <table>
         <caption>Contacts stored in the database</caption>
         <tr>
            <th>ID</th>
            <th>Timeslot ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>UMID</th>
            <th>E-mail Address</th>
            <th>Phone Number</th>
         </tr>
         <?php
            // fetch each record in result set
            for ( $counter = 0; $row = mysql_fetch_row( $result );
               ++$counter )
            {
               // build table to display results
               print( "<tr>" );

               foreach ( $row as $key => $value )
                  print( "<td>$value</td>" );

               print( "</tr>" );
            } // end for

            mysql_close( $database );
         ?><!-- end PHP script -->
      </table>
   </body>
</html>
