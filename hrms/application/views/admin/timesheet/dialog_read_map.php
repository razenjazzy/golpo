<?php
// include('OpenCage/AbstractGeocoder.php');
// include('OpenCage/Geocoder.php');
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($_GET['jd']) && isset($_GET['ipaddress']) && $_GET['data'] == 'view_map') {
    $ipAdress = $_GET['ipaddress']
    ?>

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="edit-modal-data"><?php echo $this->lang->line('xin_view_map_address'); ?></h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <?php
                    $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ipAdress));
                    if ($query && $query['status'] == 'success') {
                        // google map
                        // $query2 = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.$query['lat'].','.$query['lon'].'&sensor=true');
                        // $json = json_decode($query2, true);
                        $lat = $query['lat'];
                        $lon = $query['lon'];
                        $region = $query['region'];
                        $city = $query['city'];
                        $zip = $query['zip'];
                        $country = $query['country'];?>
                        <iframe src="https://maps.google.com/maps?q=<?php echo $lat;?>,<?php echo $lon;?> &hl=en-US;z=19&amp;output=embed" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen>
                        </iframe>
                        <br/>
                        <?php
                        echo "IP: " . $ipAdress . " | Address: " . $region . ", " . $city . " " . $zip . ", " . $country . ".";
                    } else {
                        echo $this->lang->line('xin_map_unable_get_location');
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary"
                data-dismiss="modal"><?php echo $this->lang->line('xin_close'); ?></button>
    </div>
<?php } ?>