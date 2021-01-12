<?php
require "../connexion.php";
$sql = "select * from  BlocageApplicationWeb where ActifBlocage=1
 and convert(date,GETDATE())>= DateDebutBlocage and  convert(date,GETDATE())<= DateFinBlocage ";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$Blocage = false;
$MotifBlocage = "";
$DateDebutBlocage = "";
$DateFinBlocage = "";
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $DateDebutBlocage = $row["DateDebutBlocage"];
    $DateFinBlocage = $row["DateFinBlocage"];
    $MotifBlocage = utf8_encode($row["MotifBlocage"]);
    $Blocage = true;
}
$sql = " select FraisLivraison,SeuilGratuite from ParametreDiver";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $FraisLivraison = $row['FraisLivraison'];
    $SeuilGratuite = $row['SeuilGratuite'];

}

$sql=" select SUM(Inclu)   as Ouvert from (
select 
  case  
when  getdate ()  between 
 ( select cONVERT(DATETIME, CONVERT(NVARCHAR, DateJour ,103)+' '+  HeureEntre  )) 
 and 
 ( select cONVERT(DATETIME, CONVERT(NVARCHAR, DateJour ,103)+' '+  HeureSortie  ))
 then 1
 else 0
 end  as Inclu
from EmploieTemp where DateJour=CONVERT(date,getdate())  
 
 )as tt";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $Ouvert = $row['Ouvert'];


}


$sql="select   HeureEntre   ,  HeureSortie,Jour  from EmploieTemp where DateJour=CONVERT(date,getdate())  ";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
$horraire="Horaire de Livraison : <br>";
$et="";

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {

    $HeureEntre = $row['HeureEntre'];
    $HeureSortie = $row['HeureSortie'];
    $Jour= $row['Jour'];
    if($Jour=='Dimanche') {

        $horraire="Le restaurant est fermé le dimanche " ;

    }else{
        if( $HeureEntre!='')
        { $horraire .= $et . " De  " . $HeureEntre . " à " . $HeureSortie . "<br>";
            $et = " et ";}
    }


}










echo" 

            <div class=\"col-sm-6 \">
                <center>

                    <div class=\" \">";
                      if ($Blocage == false) {

                            if($Ouvert>=1)

                            {




                        echo"    <div class=\"sub-ttl font_Lobster  color-white\">Restaurant Le 52</div>
                            <br>
                            <br>
                            <div class=\"text-center\">
                                <div class=\"col-md-12\">
                                    <img class=\"img-responsive\" style=\"width: 250px; \" src=\"images/bg_52_logo.png\"
                                         alt=\"\">
                                    <h4 class=\"font-16\"></h4>
                                    <br>
                                    <br>
                                    <p class=\"btn btn-danger btn-lg\" id=\"bt_menu\" hidden onclick=\"getMenu()\"><i
                                                class=\"fa fa-play-circle\"></i>
                                        Voir Menu </p>


                                </div>


                            </div>

                            <label class=\"color-white font-weight-bold font-16  animated  pulse infinite    \">

                                <input type=\"checkbox\" id=\"checkrobot\" class=\"\" onclick=\"RobetTest()\">
                                Je ne suis pas un robot</label><br>
                                <label class=\"color-white font-16\">

                                 $horraire   

                                </label>
                            <!--              fin actif         -->";
                     }
                        else{


                    echo"        <div class=\"sub-ttl font_Lobster  color-white\">Restaurant Le 52</div>
                            <br>
                            <br>
                            <div class=\"text-center\">
                                <div class=\"col-md-12\">
                                    <img class=\"img-responsive\" style=\"width: 250px;250px\" src=\"images/bg_52_logo.png\"
                                         alt=\"\">
                                    <h4 class=\"font-16\"></h4>
                                    <br>

                                   <label class=\"color-white font-20\">

                                    $horraire   

                                   </label>

                                </div>


                            </div>";












                        }



                        } ELSE {

                        echo"    <div class=\"sub-ttl font_Lobster  color-white\">Restaurant Le 52</div>
                            <div>
                                <h5 class=\"color-white text-uppercase\">FERMé DU
                                    <span class=\"font-weight-bold color-red\"><?php echo date_format($DateDebutBlocage, 'd/m/Y') ?></span>
                                    AU
                                    <span class=\"font-weight-bold color-red\">
                                      ".   date_format($DateFinBlocage, 'd/m/Y')."  </span>
                                </h5>
                                <hr>
                                <p  class=\"color-white\"> $MotifBlocage  </p>
                            </div>";



                       }
                      echo "  <div id=\"dataInfoRestaurant\">

                            <input type='hidden' class=\"\" readonly id='tel' name='tel' value='46 525 252'/>
                            <div class=\"col-md-12  \">
                                <h4 class=\"color-white font-weight-bold\">
                                    <i class=\"fa fa-phone\"></i> (+216) 46 52 52 52</h4>
                            </div>

                            <div class=\"btn-group row \">

                                 <a href='https://www.facebook.com/RestoLe52' class='btn btn-info'>
                                            <i class='fa fa-facebook-square'></i> facebook &nbsp;</a>


                                        <a href='https://www.instagram.com/restaurant_le52/' style=\"background-color: #b30047\"
                                           class='btn btn-danger'>
                                            <i class='fa fa-instagram'></i> Instagram </a>
                            </div>

                            <!--                            <a class=\"btn btn-info\" href=\"https://www.facebook.com/RestoLe52/\"><i-->
                            <!--                                        class=\"fa fa-facebook-square\"></i></a>-->

                        </div>
                    </div>


                    <script>
                        function call() {
                            var num = document.getElementById('tel').value;
                            window.open('tel:' + num);
                        }
                    </script>

                </center>
            </div>";
