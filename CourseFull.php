<form method="GET" action="CourseFull.php">
   <!-- SEARCH -------->
   <div class="form-group input-group" style="width:300px">
       <input type="text" name="courseID" placeholder="กรุณากรอกข้อมูล">
       <input type="submit">
   </div>
   <!-- SEARCH -------->
</form>
<?php
    isset($_REQUEST['courseID']) ? $courseID = $_REQUEST['courseID'] : $courseID = '?';
    // init
    error_reporting(E_ERROR | E_PARSE);
    header('Content-Type: text/html; charset=utf-8');
    //$curr_code = $_GET['curr_code'];
    $curr_code = $courseID;
    $xml_string = "http://klogic.kmutnb.ac.th:8080/kris/curri/showXML.jsp?currCode=" . $curr_code;
    $xmldata = @file_get_contents($xml_string);
    $xml = simplexml_load_string($xmldata); //or die("กรุณากรอกหมายเลขหลักสูตร");
    $result = 'curr_code: ' . $curr_code;
    if(!$xml){
        echo "กรุณากรอกหมายเลขหลักสูตร";
        $result = 'No post data yet.';
    }
///////////////////////////////////////////////////////////////////////////////////////
    else{
        echo "<table class='table table-striped table-bordered table-hover'>";
        echo "    <thead>";
        echo "        <tr>";
        echo "            <th width=10%>ลำดับ</th>";
        echo "            <th width=10%>รหัสวิชา</th>";
        echo "            <th width=20%>ชื่อวิชาภาษาไทย</th>";
        echo "            <th width=20%>ชื่อวิชาภาษาอังกฤษ</th>";
        echo "            <th width=20%>คำอธิบายวิชาภาษาไทย</th>";
        echo "            <th width=20%>คำอธิบายวิชาภาษาอังกฤษ</th>";
        echo "        </tr>";
        echo "    </thead>";
    ///////////////////////////////////////////////////////////////////////////////////////
        $courseCount = $xml->Courses->Course;
        $count = null;
        for($i=0;$i<count($courseCount);$i++){
            //===================================================
                $count++;
                echo "<tr>";
                echo "    <td>" . $count . "</td>";
                echo "    <td>" . $xml->Courses->Course[$i]->attributes() . "</td>";
                echo "    <td>" . $xml->Courses->Course[$i]->NameThai . "</td>";
                echo "    <td>" . $xml->Courses->Course[$i]->NameEng . "</td>";
                echo "    <td>" . $xml->Courses->Course[$i]->DescThai . "</td>";
                echo "    <td>" . $xml->Courses->Course[$i]->DescEng . "</td>";
                echo "</tr>";
        }
        echo "</table>";
    }
?>