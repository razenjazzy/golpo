<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{$_L['Quote']} - {$d['invoicenum']}{if $d['cn'] neq ''} {$d['cn']} {else} {$d['id']} {/if}</title>
    <link rel="apple-touch-icon" sizes="57x57" href="{$app_url}application/storage/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="{$app_url}application/storage/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="{$app_url}application/storage/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="{$app_url}application/storage/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="{$app_url}application/storage/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="{$app_url}application/storage/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="{$app_url}application/storage/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="{$app_url}application/storage/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{$app_url}application/storage/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="{$app_url}application/storage/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{$app_url}application/storage/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="{$app_url}application/storage/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{$app_url}application/storage/icon/favicon-16x16.png">
    <link rel="manifest" href="{$app_url}application/storage/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{$app_url}application/storage/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link href="{$_theme}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{$_theme}/lib/fa/css/font-awesome.min.css" rel="stylesheet">
    <link href="{$_theme}/lib/icheck/skins/all.css" rel="stylesheet">
    <link href="{$app_url}ui/lib/css/animate.css" rel="stylesheet">
    <link href="{$_theme}/css/style.css" rel="stylesheet">
    <link href="{$_theme}/css/custom.css" rel="stylesheet">
    <link href="{$app_url}ui/lib/css/ribbon.css" rel="stylesheet">

    {if $_c['rtl'] eq '1'}
        <link href="{$_theme}/css/bootstrap-rtl.min.css" rel="stylesheet">
        <link href="{$_theme}/css/style-rtl.min.css" rel="stylesheet">
    {/if}

    {if isset($xheader)}
        {$xheader}
    {/if}
    <style type="text/css">
        body {

            background-color: #FAFAFA;
            overflow-x: visible;
        }
        .paper {
            margin: 50px auto;
            width: 980px;
            border: 2px solid #DDD;
            background-color: #FFF;
            position: relative;
           font-size: 14px;
        }
    </style>
</head>

<body class="fixed-nav">

<div class="paper">

    <section class="panel">
        <div class="panel-body">

            <div class="invoice">
                <header class="clearfix">
                    <div class="row">
                        <div class="col-md-12 mt-md">
                            <h2 class="h2 mt-none mb-sm text-dark text-bold">{$_c['CompanyName']}</h2>
                            <h4 class="h4 m-none text-dark text-bold">{$_L['Quote']} #{$d['invoicenum']}{if $d['cn'] neq ''} {$d['cn']} {else} {$d['id']} {/if}</h4>

                        </div>

                    </div>
                </header>
                <div class="bill-info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bill-to">
                                <p class="h5 mb-xs text-dark text-semibold"><strong>{$_L['Recipient']}:</strong></p>
                                <address>
                                    {if $a['company'] neq ''}
                                        {$a['company']}
                                        <br>
                                        {$_L['ATTN']}: {$d['account']}
                                        <br>
                                    {else}
                                        {$d['account']}
                                        <br>
                                    {/if}

                                    {$a['address']} <br>
                                    {$a['city']} <br>
                                    {$a['state']} - {$a['zip']} <br>
                                    {$a['country']}
                                    <br>
                                    <strong>{$_L['Phone']}:</strong> {$a['phone']}
                                    <br>
                                    <strong>{$_L['Email']}:</strong> {$a['email']}
                                    {foreach $cf as $cfs}
                                        <br>
                                        <strong>{$cfs['fieldname']}: </strong> {get_custom_field_value($cfs['id'],$a['id'])}
                                    {/foreach}

                                    {$x_html}
                                </address>





                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bill-data text-right">
                                <address class="ib mr-xlg">
                                    {$_c['caddress']}
                                </address>
                                <div class="ib">
                                    <img src="{$app_url}application/storage/system/logo.png" alt="Logo">
                                </div>
                                <p class="mb-none mt-lg">
                                    <span class="text-dark">{$_L['Date Created']}:</span>
                                    <span class="value">{date( $_c['df'], strtotime($d['datecreated']))}</span>
                                </p>
                                <p class="mb-none">
                                    <span class="text-dark">{$_L['Expiry Date']}:</span>
                                    <span class="value">{date( $_c['df'], strtotime($d['validuntil']))}</span>
                                </p>
                                <h2> {$_L['Total']}: {$_c['currency_code']} {number_format($d['total'],2,$_c['dec_point'],$_c['thousands_sep'])} </h2>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        {$d['proposal']}
                        <hr>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table invoice-items">
                        <thead>
                        <tr class="h4 text-dark">
                            <th id="cell-id" class="text-semibold">#</th>
                            <th id="cell-item" class="text-semibold">{$_L['Item']}</th>

                            <th id="cell-price" class="text-center text-semibold">{$_L['Price']}</th>
                            <th id="cell-qty" class="text-center text-semibold">{$_L['Quantity']}</th>
                            <th id="cell-total" class="text-center text-semibold">{$_L['Total']}</th>
                        </tr>
                        </thead>
                        <tbody>
                        {foreach $items as $item}
                            <tr>
                                <td>{$item['itemcode']}</td>
                                <td class="text-semibold text-dark">{$item['description']}</td>

                                <td class="text-center">{$_c['currency_code']} {number_format($item['amount'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                                <td class="text-center">{$item['qty']}</td>
                                <td class="text-center">{$_c['currency_code']} {number_format($item['total'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                            </tr>
                        {/foreach}

                        </tbody>
                    </table>
                </div>

                <div class="invoice-summary">
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-8">
                            <table class="table h5 text-dark">
                                <tbody>
                                <tr class="b-top-none">
                                    <td colspan="2">{$_L['Subtotal']}</td>
                                    <td class="text-left">{$_c['currency_code']} {number_format($d['subtotal'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                                </tr>
                                {if ($d['discount']) neq '0.00'}
                                    <tr>
                                        <td colspan="2">{$_L['Discount']}</td>
                                        <td class="text-left">{$_c['currency_code']} {number_format($d['discount'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                                    </tr>
                                {/if}
                                <tr>
                                    <td colspan="2">{$d['taxname']}</td>
                                    <td class="text-left">{$_c['currency_code']} {number_format($d['tax1'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                                </tr>

                                <tr class="h4">
                                    <td colspan="2">{$_L['Grand Total']}</td>
                                    <td class="text-left">{$_c['currency_code']} {number_format($d['total'],2,$_c['dec_point'],$_c['thousands_sep'])}</td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>
                        {$d['customernotes']}
                    </div>
                </div>
            </div>


            <div class="text-right">

                <br>
                <a href="{$_url}client/qpdf/{$d['id']}/token_{$d['vtoken']}" class="btn btn-primary ml-sm"><i class="fa fa-print"></i> {$_L['Download PDF']}</a>

            </div>
        </div>
    </section>

</div>

<!-- Mainly scripts -->
<script src="{$_theme}/js/jquery-1.10.2.js"></script>
<script src="{$_theme}/js/jquery-ui-1.10.4.min.js"></script>
<script>
    var _L = [];
    var config_animate = 'No';
    {if ($_c['animate']) eq '1'}
    var config_animate = 'Yes';
    {/if}
    {$jsvar}
</script>
<script src="{$_theme}/js/bootstrap.min.js"></script>
<script src="{$_theme}/js/jquery.metisMenu.js"></script>
<script src="{$_theme}/js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<script src="{$_theme}/lib/moment.js"></script>

<script src="{$_theme}/js/app.js"></script>
<script src="{$_theme}/js/pace.min.js"></script>
<script src="{$_theme}/lib/progress.js"></script>
<script src="{$_theme}/lib/bootbox.min.js"></script>

<!-- iCheck -->
<script src="{$_theme}/lib/icheck/icheck.min.js"></script>
{if isset($xfooter)}
    {$xfooter}
{/if}
<script>
    jQuery(document).ready(function() {

        {if isset($xjq)}
        {$xjq}
        {/if}

    });

</script>
</body>

</html>
