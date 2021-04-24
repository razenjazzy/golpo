<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/jszip/jszip.min.js") )?>" ></script>
<script type="text/javascript" src="<?php _e( get_module_path($this, "assets/plugins/kendo/kendo.all.min.js") )?>" ></script>

<script type="text/javascript">
	$(document).on("click", ".ExportPDF", function(){
        $(".none-export").hide();
        $(".instagram-analytics .wrap-analytics").css({"width": 745});
        Core.overplay();
        setTimeout(function(){
            ExportPdf();
        }, 1000);

        setTimeout(function(){
            $(".instagram-analytics .wrap-analytics").attr("style", "");
            $(".none-export").show();
            $(".loading-overplay").hide();
        }, 4000);
    });

 	function ExportPdf(){ 
        kendo.pdf.defineFont({
            "DejaVu Sans"             : "<?php _e( get_module_path($this, "assets/plugins/kendo/fonts/DejaVuSans.ttf") )?>",
            "DejaVu Sans|Bold"        : "<?php _e( get_module_path($this, "assets/plugins/kendo/fonts/DejaVuSans-Bold.ttf") )?>",
            "DejaVu Sans|Bold|Italic" : "<?php _e( get_module_path($this, "assets/plugins/kendo/fonts/DejaVuSans-Oblique.ttf") )?>",
            "DejaVu Sans|Italic"      : "<?php _e( get_module_path($this, "assets/plugins/kendo/fonts/DejaVuSans-Oblique.ttf") )?>",
            "WebComponentsIcons"      : "<?php _e( get_module_path($this, "assets/plugins/kendo/fonts/WebComponentsIcons.ttf") )?>"
        });

        kendo.drawing
        .drawDOM(".wrap-analytics", 
        { 
            forcePageBreak: ".page-break", 
            paperSize: "A4",
            margin: { top: "1cm", bottom: "1cm" },
            scale: 0.8,
            height: 500, 
            template: $("#page-template").html(),
            keepTogether: ".prevent-split"
        })
            .then(function(group){
            kendo.drawing.pdf.saveAs(group, "Report_Instagram_Account.pdf")
        });
    }
</script>

<div class="subheader-main wrap-m w-100 p-r-0"> 
	<div class="wrap-c">
		<button type="button" class="btn btn-label-info m-r-10 subheader-toggle"><i class="fas fa-bars"></i></button>
		<h3 class="title"><i class="<?php _e( $module_icon )?>" style="color: <?php _e( $module_color )?>"></i> <?php _e( $module_name )?></h3>
	</div>
	<button type="button" class="btn btn-label-info float-right wrap-c ExportPDF"><i class="fas fa-file-export"></i> <?php _e("Export")?></button>
</div>	