<?php
include('../customtitle.php');
include('../customdb.php');
error_reporting(0);
$con_zaheer = mysqli_connect("localhost","zaheerautospindi_pn1","stkpindizaheer123++","zaheerautospindi_stkpindi");
include '../dbc.php'; 
page_protect();

mysqli_autocommit($con,FALSE);

$dd1=date_create_from_format("Y-m-d",$dtt1);
$dd2=date_create_from_format("Y-m-d",$dtt2);

$titles = 'Print  Purchase & Sales ';
include('slice/pur_order_code.php');

?>
<link href="css/style.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="js/jquery.js" type="text/javascript"></script>
<style>
    table, th, td, tr {
        border-left-style: none;
        border-right-style: none;

    }
</style>
<script language="javascript">
    function Clickheretoprint() {

        var disp_setting = "toolbar=yes,location=no,directories=yes,menubar=yes,";
        disp_setting += "scrollbars=yes,width=800, height=400, left=100, top=25";
        var content_vlue = document.getElementById("content").innerHTML;

        var docprint = window.open("", "", disp_setting);
        docprint.document.open();
        docprint.document.write('</head><body onLoad="self.print()" style="width: 800px; font-Meter: 13px; font-family: arial;">');
        docprint.document.write(content_vlue);
        docprint.document.close();
        docprint.focus();
    }


    function stopback() {


        if (window.history && window.history.pushState) {

            $(window).bind('popstate', function () {
                var hashLocation = location.hash;
                var hashSplit = hashLocation.split("#!/");
                var hashName = hashSplit[1];

                if (hashName !== '') {
                    var hash = window.location.hash;
                    if (hash === '') {
                        alert('Back button was pressed.');
                        // window.location = 'myaccount.php';
                        return false;
                    }
                }
            });

            // window.history.pushState('forward', null, './#forward');
        }
        <?php
        if($_SESSION['status'] == "shop"){ ?>

        Clickheretoprint();
        <?php }
        ?>
    }

</script>

<body onload="stopback()">
<a href="shipment_purchase.php" style="font-Meter:20px" ;>Back</a>|

<div align ='center'>

    <a href="#" onclick="javascript:Clickheretoprint('content')">
        <button type="button" class="btn btn-warning">Print</button>
    </a>
    <a href="" align="center"><?php echo $Brand_duration?></a>


 
</div> 
 <hr>

<div class="content" id="content">
<div align="center">
      
    
    <!--heading start-->
<font style="font-style:italic;"><b><u><? echo "Zaheer Autos"?> Customer Yearwise Sales Collection <? echo $rev?></u> </b>
        </font> </div>
    <div style="margin: 0 auto; padding: 0px; width: 1000px; font-weight: normal;">

    <div style="width: 100%; height: 80px;">
            <div>

                <div>
                    <u><h3 align="center"><?php echo $rev ?></h3></u>
                    <table cellpadding="2" cellspacing="2"
                           style="font-family: times & roman; font-style:italic; font-size: 14px;text-align:left;width : 100%;">
                        <tr>

                            <td width="35%"><b><?php echo 'M/s: ' . $brand ?></b></td>
                            <td align="right"><?php echo 'Book No: ' . $tr_no ?></td>

                        </tr>
                        <tr>

                            <td width="35%"><?php echo 'Address: ' . $address ?></td>
                            <td align="right"><?php echo 'Date: ' . date('d-m-y'); ?></td>

                        </tr>




                    </table>
                </div>

            </div>




        </div>

  <!--heading end-->

        <div id="myform">




        <table id="bor" border="1" cellpadding="4" cellspacing="0"
               style=" font-family: times & roman; font-style:italic; font-size: 12px;text-align:left; " width="100%">
            <thead>
            <tr>
                <th>S.NO</th>
                <th>customer</th>
                <?php

//zero query
$querytable1 = "SELECT year(date) as date FROM `gdsales`  group by year(date)";
                $querytableresult1 = mysqli_query($con_zaheer,$querytable1);
                while($rowtable=Mysqli_Fetch_Assoc($querytableresult1)) {
                    
                    $year[] = $rowtable['date'];
                }
$no;

                //first query 
                $queryyearno = "SELECT year(date) as date FROM `gdsales` WHERE YEAR(date) != YEAR(CURDATE()) group by year(date)";
                $queryyearnoresult = mysqli_query($con_zaheer,$queryyearno);
                while($rowno=Mysqli_Fetch_Assoc($queryyearnoresult)) {
                ++$no;    
                }
                
                
                $nno;
                //second query
                $querymonthno = "SELECT MONTHname(date) as date FROM `gdsales` where  YEAR(date) = YEAR(CURDATE()) group by monthname(date)";
                $querymonthresult = mysqli_query($con_zaheer,$querymonthno);
                while($rowno=Mysqli_Fetch_Assoc($querymonthresult)) {
                ++$nno;    
                }
                
                //thrid query
                $querytable = "SELECT year(date) as date FROM `gdsales` group by year(date)";
                $querytableresult = mysqli_query($con_zaheer,$querytable);
                while($rowc=Mysqli_Fetch_Assoc($querytableresult)) {
                
                ?>
                <th><?php echo $rowc['date']?></th>
                
                <?php
                
                }
                
                ?>
                <th>Total</th>
                <th><?php echo $no?>Year Avg</th>
                <th>12 Month Avg Pre year</th>
                <th>Current Year <?php echo $nno?> Month Avg</th>
                <th>Gain/Loss</th>
                






            </tr>
            </thead>
            <tbody>
            <?php
          
             
       
           $sno=0;
            
                //fourth query
                $querycustomer = "SELECT (a.cusid) as pay_acid , b.cus_org ,sum(a.amount) as amount FROM `gdsales` as a inner join tbl_cusdetails as b on a.cusid = b.cus_id group by a.cusid order by amount desc";
                $querycustomerresult = mysqli_query($con_zaheer,$querycustomer);
                while($rowcus=Mysqli_Fetch_Assoc($querycustomerresult)) {
                    $customer = $rowcus['pay_acid'];

                ?>

                <tr class="record">

                     <td><?php echo  ++$sno ; ?></td>
                     <td><?php echo $rowcus['cus_org'] ; ?></td>
                     

                <?php
                //fifth yearloop
                $totalsales_amount = 0;
                $currentamount = 0;
                $cur_year = date('Y');
                foreach($year as $yearget){
                    
                    //sixth query    
                $queryamount = "SELECT sum(amount) as amount FROM `gdsales` WHERE `cusid` = $customer and year(date) = $yearget";
                $queryamountresult = mysqli_query($con_zaheer,$queryamount);
                $rowamount=Mysqli_Fetch_Assoc($queryamountresult);
                
                ?>
                <th><?php echo number_format($rowamount['amount']) ?></th>
                
                <?php
                
                $totalsales_amount += $rowamount['amount'];
                if($yearget==$cur_year){

                    $currentamount = $rowamount['amount'];
                }
                
            }
                

                ?>
                <th><?php echo number_format($totalsales_amount) ?></th>
                <th><?php 
                
                
                $totalamount = $totalsales_amount-$currentamount;
                
                
                echo number_format($total = $totalamount/$no) ?></th>
                <th><?php echo number_format($pre = $total/12) ?></th>
                <th><?php echo number_format($cur = $currentamount/$nno) ?></th>
              
                
                <?php
                
                $alltotal = round(($cur - $pre)/$pre*100 ,2);
                if($alltotal<0){   ?>
                    
                      <th style="background:red;color:white"><?php echo $alltotal;  ?></th>
                    
                    <?php   }
                    else { ?>   <th ><?php echo $alltotal ; ?></th>  <?php    }
                
                
                
                
                
                
                
                
                ?>

                   
                 




                </tr>
                <?php


           

}
            ?>


     
            <tr>
                <td colspan="2" ><strong style="font-size: 12px; color: #222222;">Total amount :</strong></td>
                
                <?php
                
                $querytable11 = "SELECT year(pay_time) as date FROM `tbl_payment` WHERE `pay_type` LIKE 'customer' group by date";
                $querytableresult11 = mysqli_query($con_zaheer,$querytable11);
                while($rowtable1=Mysqli_Fetch_Assoc($querytableresult11)) {
                    
                    $year1 = $rowtable1['date'];
                    
                $queryamount1 = "SELECT sum(pay_amount) as amount FROM `tbl_payment` WHERE `pay_type` LIKE 'customer' and year(pay_time) = $year1 and pay_acid != 1";
                $queryamountresult1 = mysqli_query($con_zaheer,$queryamount1);
                while($rowamount1=Mysqli_Fetch_Assoc($queryamountresult1)) {
                
                
                ?>
                
                
                
                
                <td colspan="1"><strong style="font-size: 12px; color: #222222;"><?php echo number_format($rowamount1['amount']) ?></strong></td>
                
                
                <?php } }
                
                $queryamount11 = "SELECT sum(pay_amount) as amount FROM `tbl_payment` WHERE `pay_type` LIKE 'customer' and pay_acid != 1";
                $queryamountresult12 = mysqli_query($con_zaheer,$queryamount11);
                while($rowamount11=Mysqli_Fetch_Assoc($queryamountresult12)) {
                $all1 = $rowamount11['amount'];
                
                ?>
                <td colspan="1"><strong style="font-size: 12px; color: #222222;"><?php echo number_format($rowamount11['amount']) ?></strong></td>
                <?php }?>
                <td colspan="1"><strong style="font-size: 12px; color: #222222;"><?php 
                
                $querycurrent1 = "SELECT sum(pay_amount) as amount, year(pay_time) as date FROM `tbl_payment` WHERE `pay_type` LIKE 'customer' and  year(pay_time) = YEAR(CURDATE()) and pay_acid != 1";
                $querycurrentresult1 = mysqli_query($con_zaheer,$querycurrent1);
                while($rowcurrent1=Mysqli_Fetch_Assoc($querycurrentresult1)) {
                $currenttotal = $rowcurrent1['amount'];
                }
                
                
                
                echo $alltotalss = number_format(($all1 - $currenttotal)/$no) ?></strong></td>
                <td colspan="1"><strong style="font-size: 12px; color: #222222;"><?php echo number_format((($all1 - $currenttotal)/$no)/12) ?></strong></td>
                <td colspan="1"><strong style="font-size: 12px; color: #222222;"><?php echo number_format(($currenttotal)/$nno) ?></strong></td>
            </tr>




            <?php
            $cond_user ="user_id=$userid";
            $res_user =  sel_query_cond($con_zaheer,'users',$cond_user);



            while($rowa = mysqli_fetch_assoc($res_user)){
                $User = $rowa['name'];
                $email = $rowa['email'];

            }
            ?>


            <tr>

                <td colspan="10">
                    <div style="text-align: left; margin-top: 13px;">Remarks: <b><?php echo $txt_remarks ?> </b></div>
                    <div style="text-align: left;">Create By :<b><?php echo $User ?> </b></div>
                    <?php echo $email; ?>
                </td>
            </tr>

            </tbody>
        </table>
       
    
    
    
    </div>
    </div>

  
    </div>

        </div>
</body>
