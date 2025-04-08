
    var options = {
        chart: { height: 285, type: "line", zoom: { enabled: !1 }, toolbar: { show: !1 } },
        colors: ["#038edc", "#5fd0f3"],
        dataLabels: { enabled: !1 },
        stroke: { width: [3, 3], curve: "straight" },
        series: [
            { name: "Effectif", data: [
                <?php
                
                $ser=$con->prepare('SELECT * FROM service ');
                $ser->execute();
                $nser=$ser->rowcount();

                $i=0;
                $se=$con->prepare('SELECT * FROM service ');
                $se->execute();
                while($ise=$se->fetch())
                {
                    $i++;
                    $pe=$con->prepare('SELECT * FROM personnel_soignant WHERE service_id=:A');
                    $pe->execute(array('A'=>$ise['id_service']));
                    $np=$pe->rowcount();
                    echo $np;
                    if($i<$nser){ echo ','; }
                }
                
                ?>
            ] },
            { name: "Personnes formées", 
                data: [
                    <?php
                
                $ser=$con->prepare('SELECT * FROM service ');
                $ser->execute();
                $nser=$ser->rowcount();

                $i=0;
                $se=$con->prepare('SELECT * FROM service ');
                $se->execute();
                while($ise=$se->fetch())
                {
                    $i++;
                    $pe=$con->prepare('SELECT * FROM personnel_soignant LEFT JOIN participe_formation ON participe_formation.personnel_id=personnel_soignant.id_personnel_soignant WHERE service_id=:A AND id_participe_formation!="" ');
                    $pe->execute(array('A'=>$ise['id_service']));
                    $np=$pe->rowcount();
                    echo $np;
                    if($i<$nser){ echo ','; }
                }
                
                ?>
             
            ] },
        ],
        grid: { row: { colors: ["transparent", "transparent"], opacity: 0.2 }, borderColor: "#f1f1f1" },
        markers: { style: "inverted", size: 4, hover: { size: 6 } },
        xaxis: { categories: [
            <?php 

//Répartition du budget par service
$ser=$con->prepare('SELECT * FROM service ');
                $ser->execute();
                $nser=$ser->rowcount(); 

$bud_serv_1=$con->prepare('SELECT * FROM service ');
$bud_serv_1->execute(); 

        $i=0;
        while($ibud_serv_1=$bud_serv_1->fetch())
        {
            $i++;
            echo "'".$ibud_serv_1['lib_service']."'";
           if($i<$nser){ echo ', '; }
        }
        ?>

        ], title: { text: "Service", style: { fontWeight: 500 } } },
        yaxis: { title: { text: "Effectif | Personnes formées", style: { fontWeight: 500 } }, min: 0, max: 40 },
        legend: { position: "top", horizontalAlign: "right", floating: !0, offsetY: -25, offsetX: -5 },
        responsive: [{ breakpoint: 600, options: { chart: { toolbar: { show: !1 } }, legend: { show: !1 } } }],
    },
    chart = new ApexCharts(document.querySelector("#line_chart_datalabel"), options);
    chart.render();

    //
    options = {
    chart: { height: 285, type: "area", toolbar: { show: !1 } },
    dataLabels: { enabled: !1 },
    stroke: { curve: "smooth", width: 3 },
    series: [
        { name: "series1", data: [34, 40, 28, 52, 42, 109, 100] },
        { name: "series2", data: [32, 60, 34, 46, 34, 52, 41] },
    ],
    colors: ["#038edc", "#5fd0f3"],
    xaxis: { type: "datetime", categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"] },
    grid: { borderColor: "#f1f1f1" },
    fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [20, 100, 100, 100] } },
    tooltip: { x: { format: "dd/MM/yy HH:mm" } },
    };

    //Nombre de participants par formation
    options = {
          series: [{  name: "Participants",
          data: [
              
            <?php 

//Participants 
$ser=$con->prepare('SELECT * FROM formation ');
$ser->execute();
$nser=$ser->rowcount(); 

$for=$con->prepare('SELECT * FROM formation LEFT JOIN demande_formation ON formation.demande_formation_id=demande_formation.id_demande_formation ');
$for->execute();
$i=0;
while($ifor=$for->fetch())
{
    $i++;
    $pe=$con->prepare('SELECT * FROM personnel_soignant LEFT JOIN participe_formation ON participe_formation.personnel_id=personnel_soignant.id_personnel_soignant LEFT JOIN demande_formation ON demande_formation.num_demande_formation=participe_formation.formation_code LEFT JOIN formation ON formation.demande_formation_id=demande_formation.id_demande_formation WHERE formation_code=:A');
    $pe->execute(array('A'=>$ifor['num_demande_formation']));
    $np=$pe->rowcount();
    echo $np;
    if($i<$nser){ echo ','; }
}
?>
        
        ]
        }],
          chart: {
          type: 'bar',
          height: 290
        },
        plotOptions: {
          bar: {
            borderRadius: 4,
            horizontal: true,
          }
        },
        dataLabels: {
          enabled: false
        },
        xaxis: {
          categories: [
              
            <?php 

                //Formations
                $ser=$con->prepare('SELECT * FROM formation ');
                $ser->execute();
                $nser=$ser->rowcount(); 

                $bud_serv_1=$con->prepare('SELECT * FROM formation LEFT JOIN demande_formation ON formation.demande_formation_id=demande_formation.id_demande_formation');
                $bud_serv_1->execute(); 

                $i=0;
                while($ibud_serv_1=$bud_serv_1->fetch())
                {
                    $i++;
                    echo "'".$ibud_serv_1['formation_demande']."'";
                if($i<$nser){ echo ', '; }
                }
        ?>

          ],
        }
        };

        var chart = new ApexCharts(document.querySelector("#column_chart_datalabel"), options);
        chart.render();

     //Camember - Représentation du Budget global Exécuté/Disponible
     <?php
     $bud_rest=floatval($valeur_actuelle_budget/$valeur_initiale_budget)*100;
     $bud_exec=100-$bud_rest;
     ?>
    (chart = new ApexCharts(document.querySelector("#bar_chart"), options)).render();
    var bud_exec=<?php echo floatval($bud_exec); ?>;
    var bud_rest=<?php echo floatval($bud_rest); ?>;
    options = {
    chart: { height: 320, type: "pie" },
    series: [bud_exec,bud_rest],
    labels: ["Budget exécuté", "Budget disponible"],
    colors: ["#f06548", "#51d28c"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };

    (chart = new ApexCharts(document.querySelector("#pie-chart"), options)).render();

       //Camember - Représentation formations Exécuté/Prévues
       <?php
    $prev=$con->prepare('SELECT * FROM demande_formation');
    $prev->execute();
    $nprev=$prev->rowcount();

    $exef=$con->prepare('SELECT * FROM formation');
    $exef->execute();
    $nexef=$exef->rowcount();
     ?>
    (chart = new ApexCharts(document.querySelector("#bar_chart"), options)).render();
    var bud_exec=<?php echo floatval($nexef); ?>;
    var bud_rest=<?php echo floatval($nprev); ?>;
    options = {
    chart: { height: 320, type: "pie" },
    series: [bud_exec,bud_rest],
    labels: ["Formations effectuées", "Formations prévues"],
    colors: ["#51d28c", "#f7b84b"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };

    (chart = new ApexCharts(document.querySelector("#pie-chart-1"), options)).render();


    
    //Camember - Représentation de la répartition du budget par service
    options = {
    chart: { height: 320, type: "donut" },
    series: [
             
        <?php

        $ser=$con->query('SELECT * FROM service');
        $ser->execute();
        $nser=$ser->rowcount();

        $i=0;
        while($ibud_serv=$bud_serv->fetch())
        {
            $i++;
            echo floatval($ibud_serv['montant_alloue']/$valeur_initiale_budget)*100;
           if($i<$nser){ echo ', '; }
        }
        
        ?>
    ],
    labels: [
        <?php 

//Répartition du budget par service
$bud_serv_1=$con->prepare('SELECT * FROM budget LEFT JOIN budget_service ON budget.code_budget=budget_service.budget_code_service LEFT JOIN service ON budget_service.service_id_budget=service.id_service WHERE actif_budget=0');
$bud_serv_1->execute(); 

        $i=0;
        while($ibud_serv_1=$bud_serv_1->fetch())
        {
            $i++;
            echo "'".$ibud_serv_1['lib_service']."'";
           if($i<$nser){ echo ', '; }
        }
        ?>
    ],
    colors: ["#5fd0f3", "#038edc", "#f06548", "#51d28c", "#f7b84b", "green", "blue", "red", "violet", "pink", "orange", "yellow", "grey"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };
    (chart = new ApexCharts(document.querySelector("#donut-chart"), options)).render();

     //Camember - Demandes de formations par service
     options = {
    chart: { height: 320, type: "donut" },
    series: [
             
        <?php

        $ser=$con->query('SELECT * FROM service ');
        $ser->execute();
        $nser=$ser->rowcount();


        $ser=$con->query('SELECT * FROM service ');
        $ser->execute();
        $i=0;
        while($ibud_serv=$ser->fetch())
        {
            $i++;
            $dem=$con->prepare('SELECT * FROM demande_formation LEFT JOIN utilisateur ON utilisateur.secur=demande_formation.secur_ajout_demande LEFT JOIN personnel_soignant ON personnel_soignant.id_personnel_soignant=utilisateur.personnel_soignant_id LEFT JOIN service ON service.id_service=personnel_soignant.service_id WHERE service_id=:A');
            $dem->execute(array('A'=>$ibud_serv['id_service']));
            $ndem=$dem->rowcount();
            echo floatval($ndem);
           if($i<$nser){ echo ', '; }
        }
        
        ?>
    ],
    labels: [
        <?php 
$bud_serv_1=$con->prepare('SELECT * FROM service ');
$bud_serv_1->execute(); 

        $i=0;
        while($ibud_serv_1=$bud_serv_1->fetch())
        {
            $i++;
            echo "'".$ibud_serv_1['lib_service']."'";
           if($i<$nser){ echo ', '; }
        }
        ?>
    ],
    colors: ["#5fd0f3", "#038edc", "#f06548", "#51d28c", "#f7b84b", "green", "blue", "red", "violet", "pink", "orange", "yellow", "grey"],
    legend: { show: !0, position: "bottom", horizontalAlign: "center", verticalAlign: "middle", floating: !1, fontSize: "14px", offsetX: 0, offsetY: -10 },
    responsive: [{ breakpoint: 600, options: { chart: { height: 240 }, legend: { show: !1 } } }],
    };
    (chart = new ApexCharts(document.querySelector("#donut-chart-1"), options)).render();


            var options5 = {
        series: [{ data: [10, 20, 15, 40, 20, 50, 70, 60, 90, 70, 110] }],
        chart: { type: "bar", height: 50, sparkline: { enabled: !0 } },
        plotOptions: { bar: { columnWidth: "50%" } },
        tooltip: {
            fixed: { enabled: !1 },
            y: {
                title: {
                    formatter: function (e) {
                        return "";
                    },
                },
            },
        },
        colors: ["#038edc"],
    },
    chart5 = new ApexCharts(document.querySelector("#sparkline-chart-1"), options5);
    chart5.render();
    var options = {
        series: [{ name: "Series A", data: [10, 90, 30, 60, 50, 90, 25, 55, 30, 40] }],
        chart: { height: 50, type: "area", sparkline: { enabled: !0 }, toolbar: { show: !1 } },
        dataLabels: { enabled: !1 },
        stroke: { curve: "smooth", width: 2 },
        fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [50, 100, 100, 100] } },
        colors: ["#038edc", "transparent"],
    },

    
    chart = new ApexCharts(document.querySelector("#sparkline-chart-2"), options);
    chart.render();
    options5 = {
    series: [{  data: [40, 20, 30, 40, 20, 60, 55, 70, 95, 65, 110] }],
    chart: { type: "bar", height: 50, sparkline: { enabled: !0 } },
    plotOptions: { bar: { columnWidth: "50%" } },
    tooltip: {
        fixed: { enabled: !1 },
        y: {
            title: {
                formatter: function (e) {
                    return "";
                },
            },
        },
    },
    colors: ["#038edc"],
    };

    //Personnes formées 
    (chart5 = new ApexCharts(document.querySelector("#sparkline-chart-3"), options5)).render();
    options = {
    series: [{ name: "Personnes formées", data: [10, 90, 30, 60, 50, 90, 25, 55, 30, 40] }],
    chart: { height: 50, type: "area", sparkline: { enabled: !0 }, toolbar: { show: !1 } },
    dataLabels: { enabled: !1 },
    stroke: { curve: "smooth", width: 2 },
    fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [50, 100, 100, 100] } },
    colors: ["#038edc", "transparent"],
    };


    (chart = new ApexCharts(document.querySelector("#sparkline-chart-4"), options)).render();
    options = {
    chart: { height: 332, type: "line", stacked: !1, offsetY: -5, toolbar: { show: !1 } },
    stroke: { width: [0, 0, 0, 1], curve: "smooth" },
    plotOptions: { bar: { columnWidth: "30%" } },
    colors: ["#5fd0f3", "#038edc", "#dfe2e6", "#51d28c"],
    series: [
        { name: "Formations effectuées", type: "column", data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30] },
        { name: "Personnes formées", type: "column", data: [19, 8, 26, 21, 18, 36, 30, 28, 40, 39, 15] },
        { name: "Budget par personne", type: "area", data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43] },
        { name: "Formateurs", type: "line", data: [9, 11, 13, 12, 10, 8, 6, 9, 14, 17, 22] },
    ],
    fill: { opacity: [0.85, 1, 0.25, 1], gradient: { inverseColors: !1, shade: "light", type: "vertical", opacityFrom: 0.85, opacityTo: 0.55, stops: [0, 100, 100, 100] } },
    labels: ["01/01/2003", "02/01/2003", "03/01/2003", "04/01/2003", "05/01/2003", "06/01/2003", "07/01/2003", "08/01/2003", "09/01/2003", "10/01/2003", "11/01/2003"],
    markers: { size: 0 },
    xaxis: { type: "datetime" },
    yaxis: { title: { text: "Analyse Financière", style: { fontWeight: 500 } } },
    tooltip: {
        shared: !0,
        intersect: !1,
        y: {
            formatter: function (e) {
                return void 0 !== e ? e.toFixed(0) : e;
            },
        },
    },
    grid: { borderColor: "#f1f1f1", padding: { bottom: 15 } },
    };
    (chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options)).render();
