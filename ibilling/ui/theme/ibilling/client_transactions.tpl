{include file="sections/header.tpl"}

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{$_L['Total']} : {count($d)} </h5>

            </div>
            <div class="ibox-content">

                <table class="table table-bordered sys_table">
                    <th>{$_L['Date']}</th>
                    <th>{$_L['Account']}</th>
                    <th>{$_L['Type']}</th>

                    <th class="text-right">{$_L['Amount']}</th>

                    <th>{$_L['Description']}</th>
                    <th class="text-right">{$_L['Dr']}</th>
                    <th class="text-right">{$_L['Cr']}</th>
                    {*<th class="text-right">{$_L['Balance']}</th>*}
                    {*<th>{$_L['Manage']}</th>*}
                    {foreach $d as $ds}
                        <tr class="{if $ds['cr'] eq '0.00'}warning {else}info{/if}">
                            <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                            <td>{$ds['account']}</td>
                            {*<td>{$ds['type']}</td>*}
                            {* From v 2.4 Baizid Arefin *}

                            <td>
                                {if $ds['type'] eq 'Income'}
                                    {$_L['Paid']}
                                {elseif $ds['type'] eq 'Expense'}
                                    {$_L['Received']}
                                {elseif $ds['type'] eq 'Transfer'}
                                    {$_L['Transfer']}
                                {else}
                                    {$ds['type']}
                                {/if}
                            </td>

                            <td class="text-right amount">{$ds['amount']}</td>
                            <td>{$ds['description']}</td>
                            <td class="text-right amount">{$ds['dr']}</td>
                            <td class="text-right amount">{$ds['cr']}</td>
                            {*<td class="text-right"><span {if $ds['bal'] < 0}class="text-red"{/if}>{$_c['currency_code']} {number_format($ds['bal'],2,$_c['dec_point'],$_c['thousands_sep'])}</span></td>*}
                            {*<td><a href="{$_url}transactions/manage/{$ds['id']}">{$_L['Manage']}</a></td>*}
                        </tr>
                    {/foreach}



                </table>

            </div>
        </div>

    </div>

    <!-- Widget-1 end-->

    <!-- Widget-2 end-->
</div> <!-- Row end-->


<!-- Row end-->


<!-- Row end-->

{include file="sections/footer.tpl"}
