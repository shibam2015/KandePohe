<?php
$this->load->library('session');
if($_SESSION['user'])
{
    ?>
<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">
<?php $this->view('patient/patient_info_section'); ?>

    <?php
    $read = array();
    $insulin = array();
    $glucose = array();
    foreach($daily as $row) {
        if($row['Time_Period'] == 'Before Lunch')
        {
            $read['B4LUNCH'] = 'Before Lunch';//$row['Reading_Date'];
            if($row['Insulin_Dosage'] != '')
            {
                $insulin['B4LUNCH'] = $row['Insulin_Dosage'];
            }
            else if($row['Insulin_Dosage'] == '')
            {
                $insulin['B4LUNCH'] = 'null';
            }
            if($row['BG_Level'] != '')
            {
                $glucose['B4LUNCH'] = $row['BG_Level'];
            }
            else if($row['BG_Level'] == '')
            {
                $glucose['B4LUNCH'] = 'null';
            }

        }
        if($row['Time_Period'] == 'Before Breakfast')
        {
            $read['B4BREAK'] = 'Before Breakfast';//$row['Reading_Date'];

            if($row['Insulin_Dosage'] != '')
            {
                $insulin['B4BREAK'] = $row['Insulin_Dosage'];
            }
            else if($row['Insulin_Dosage'] == '')
            {
                $insulin['B4BREAK'] = 'null';
            }
            if($row['BG_Level'] != '')
            {
                $glucose['B4BREAK'] = $row['BG_Level'];
            }
            else if($row['BG_Level'] == '')
            {
                $glucose['B4BREAK'] = 'null';
            }
        }
        if($row['Time_Period'] == 'Before Dinner')
        {
            $read['B4DINNER'] = 'Before Dinner';//$row['Reading_Date'];
            if($row['Insulin_Dosage'] != '')
            {
                $insulin['B4DINNER'] = $row['Insulin_Dosage'];
            }
            else if($row['Insulin_Dosage'] == '')
            {
                $insulin['B4DINNER'] = 'null';
            }
            if($row['BG_Level'] != '')
            {
                $glucose['B4DINNER'] = $row['BG_Level'];
            }
            else if($row['BG_Level'] == '')
            {
                $glucose['B4DINNER'] = 'null';
            }

        }
        if($row['Time_Period'] == 'Before Bedtime')
        {
            $read['B4BED'] = 'Before Bedtime';//$row['Reading_Date'];
            if($row['Insulin_Dosage'] != '')
            {
                $insulin['B4BED'] = $row['Insulin_Dosage'];
            }
            else if($row['Insulin_Dosage'] == '')
            {
                $insulin['B4BED'] = 'null';
            }
            if($row['BG_Level'] != '')
            {
                $glucose['B4BED'] = $row['BG_Level'];
            }
            else if($row['BG_Level'] == '')
            {
                $glucose['B4BED'] = 'null';
            }

        }


    }
    $date = array_unique($read);
    #  echo "date => <pre>"; print_r($date);
    #   echo "ins => <pre>"; print_r($insulin);
    #  echo "Gul => <pre>"; print_r($glucose);exit;
    ?>
      <!-- row -->
      <div class="row">
        <div class="col-xs-12">

          <!-- jQuery Knob -->
          <div class="box box-solid">
          	<?php
    if(isset($_GET['message']))
    {
        $message = $_GET['message'];
        if($message == '9')
        {?>

            <div class="alert alert-success text-center col-xs-12" id="success-alert">
                <strong>Success! </strong>Tele-Health Record Added.
            </div>
        <?php
        } if($message == '1')
    {?>

        <div class="alert alert-success text-center col-xs-12" id="success-alert">
            <strong>Success! </strong>Record Updated.
        </div>
    <?php
    }
        if($message == '2')
        {?>

            <div class="alert alert-warning text-center col-xs-12" id="success-alert">
                <strong>Warning! </strong>Something goes wrong.
            </div>
        <?php
        } }?>

            <!-- /.box-header -->
            <div class="box-body">
            	<div class="pull-right" style="margin-bottom:10px;">
            	<a href="weekly?id=<?php echo $_GET['id']; ?>" class="btn btn-info">Weekly Chart</a>
                <a href="monthly?id=<?php echo $_GET['id']; ?>" class="btn btn-info">Monthly Chart</a>
                </div>
				<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                <div>
                <h1>&nbsp;</h1>
                </div>

            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->

        <?php $this->view('patient/medication_section'); ?>

	</section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
    <footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
     <strong>Copyright &copy; 2016 <a href="#">Vivovitals</a>.</strong> <!--Powered By <a href="http://immacbytes.com" target="_blank">Immac Bytes</a>-->

  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
      </div>
        <!-- /.control-sidebar-menu -->
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../../plugins/jQuery/jquery-2.2.3.min.js"></script>

<!-- Bootstrap 3.3.6 -->
<script src="../../bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script> -->

<script src="../../js/highcharts.js"></script>
<script src="../../js/data.js"></script>
<script src="../../js/exporting.js"></script>
<script src="../../js/drilldown.js"></script>

<script src="../../js/exportcsv.js"></script>

<style type="text/css">
    div.highcharts-data-table
    {
        padding-top:50px;
    }

    div.highcharts-data-table table
    {
        width: 100%;
        max-width: 100%;
        margin-bottom: 20px;
        background-color: transparent;
        border-spacing: 0;
        border-collapse: collapse;

    }

    div.highcharts-data-table table tr
    {
       border: 1px solid #4a4a4a;
    }

    div.highcharts-data-table table  th {
        background-color: #f4f4f4;
        padding: 5px;
    }

    div.highcharts-data-table table td, th {
        padding: 5px;
    }
</style>



<script>

$(function () {
    Highcharts.chart('container', {
        chart: {
            zoomType: 'xy'
        },
		/* navigation: {
        buttonOptions: {
            theme: {
                // Good old text links
                style: {
                    color: 'red',
                    textDecoration: 'underline'
                }
            }
        }
    },*/
        exporting: {
			 buttons: {
            contextButton: {
             //symbol: 'url(http://geodev.grid.unep.ch/images/button_download.png)'
             symbol: 'url(../../users/admin/download_icon.png)'
				//enabled: false,
                //text: 'Download'
               // text: 'Click on the Disc icon below to dowload the chart'
            }
        },
		 /*buttons: {
            contextButton: {
                //enabled: false
				// text: 'Download'
				 symbol: 'url(http://geodev.grid.unep.ch/images/button_download.png)'
            },
            exportButton: {
                //text: '<a href="javascript:void(0)" class="btn btn-info"><b>Download</b></a>',
                //#text: '<img src="http://picresize.com/popup.html?images/rsz_2download_image.png" border="0" vspace="4">',
                // Use only the download related menu items from the default context button
                menuItems: Highcharts.getOptions().exporting.buttons.contextButton.menuItems.splice(0)
            }
        },*/
			filename: '<?php date_default_timezone_set('America/New_York');
    echo str_replace(":","_",(str_replace("-","_",date('Y-m-d H:i:s')))); ?>'
        },

        title: {
            text: 'Daily Insulin and Glucose Chart'
        },
        subtitle: {
            text: ''
        },
        xAxis: [{
            categories: [<?php foreach($read as $read)
{
    //$time = explode(' ',$read);
    //echo "'".$time[0] . ' | ' . $time[1] ."',";
    $time = explode(' ',$read);
    $TM = explode(":", $time[1]);
    //echo "'".$TM[0] .":".$TM[1]." | ".date('m-d-Y',strtotime($time[0]))."'," ;
    echo "'".$read ."'," ;

} ?>],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
		min: 0,
            max: 100,
            tickInterval: 20,
			alignTicks: false,
			endOnTick: false,
            labels: {
                format: '{value} units',
                style: {
                    color: '#00008B'
                }
            },
            title: {
                text: 'Insulin',
                style: {
                    color: '#00008B'
                }
            },
            opposite: true

        }, { // Secondary yAxis
		min: 0,
           max: 900,
            tickInterval: 180,
            gridLineWidth: 0,
			alignTicks: false,
			endOnTick: false,
            title: {
                text: 'Glucose',
                style: {
                    color: '#A74E67'
                }
            },
                    plotBands: [{
                        from: 70,
                        to: 180,
                        color: 'rgb(181, 202, 146)',
                        label: {
                            text: ''
                        }
                    }],
            labels: {
                format: '{value} mg/dL',
                style: {
                    color:  '#A74E67'
                }
            }

        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 80,
            verticalAlign: 'top',
            y: 55,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Glucose',
            type: 'spline',
            yAxis: 1,
			//threshold: 500,
			color: '#A74E67',
            data: [<?php foreach($glucose as $glucose)
{
    if($glucose >= 300)
    {
        echo "{ y: ". round($glucose) . ", color: '#A74E67'},";
    }
    else
    {
        //echo $glucose.",";
        echo "{ y: ". round($glucose) . ", color: '#A74E67'},";
    }
}
    ?>],
            tooltip: {
                valueSuffix: 'mg/dL',
				headerFormat: '<b>{point.x.name} </b>',
            }

        },  {
            name: 'Insulin',
            type: 'spline',
			color: '#00008B',
			marker: {
                symbol: 'diamond',
                radius: 7
            },
            data: [<?php foreach($insulin as $insulin) { echo "{ y: ". round($insulin) ."},";  } ?>],
			//data: [<?php foreach($insulin as $insulin) { echo "{ y: ". round($insulin) . ", color: '#000000'},";  } ?>],
            tooltip: {
                valueSuffix: 'units'
            }
        }]
    });
});

		//alert hiding
		$("#success-alert").fadeTo(3000, 500).slideUp(500, function(){
			$("#success-alert").slideUp(500);
			var id = $('#id').val();
			history.pushState('', '', 'index?id=' + id);
		});
</script>
</body>
</html>
<?php
}
else
{
    header('Location: ../?message=2');
}
?>