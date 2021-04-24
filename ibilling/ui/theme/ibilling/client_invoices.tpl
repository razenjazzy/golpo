{include file="sections/header.tpl"}
<div class="ibox float-e-margins">
    <div class="ibox-title">


            <h5>{$_L['Total']} : {$total_invoice}</h5>


    </div>
    <div class="ibox-content">



        <table class="table table-bordered table-hover sys_table">
            <thead>
            <tr>
                <th>#</th>
                <th>{$_L['Account']}</th>
                <th>{$_L['Amount']}</th>
                <th>{$_L['Invoice Date']}</th>
                <th>{$_L['Due Date']}</th>
                <th>
                    {$_L['Status']}
                </th>
                {*<th>{$_L['Type']}</th>*}
                <th class="text-right">{$_L['Manage']}</th>
            </tr>
            </thead>
            <tbody>

            {foreach $d as $ds}
                <tr>
                    <td><a target="_blank" href="{$_url}client/iview/{$ds['id']}/token_{$ds['vtoken']}/">{$ds['invoicenum']}{if $ds['cn'] neq ''} {$ds['cn']} {else} {$ds['id']} {/if}</a> </td>
                    <td>{$ds['account']} </td>
                    <td class="amount" data-a-sign="{if $ds['currency_symbol'] eq ''} {$_c['currency_code']} {else} {$ds['currency_symbol']}{/if} ">{$ds['total']}</td>
                    <td>{date( $_c['df'], strtotime($ds['date']))}</td>
                    <td>{date( $_c['df'], strtotime($ds['duedate']))}</td>
                    <td>

                        {if $ds['status'] eq 'Unpaid'}
                            <span class="label label-danger">{ib_lan_get_line($ds['status'])}</span>
                        {elseif $ds['status'] eq 'Paid'}
                            <span class="label label-success">{ib_lan_get_line($ds['status'])}</span>
                        {elseif $ds['status'] eq 'Partially Paid'}
                            <span class="label label-info">{ib_lan_get_line($ds['status'])}</span>
                        {elseif $ds['status'] eq 'Cancelled'}
                            <span class="label">{ib_lan_get_line($ds['status'])}</span>
                        {else}
                            {ib_lan_get_line($ds['status'])}
                        {/if}



                    </td>
                    {*<td>*}
                        {*{if $ds['r'] eq '0'}*}
                            {*<span class="label label-success"><i class="fa fa-dot-circle-o"></i> {$_L['Onetime']}</span>*}
                        {*{else}*}
                            {*<span class="label label-success"><i class="fa fa-repeat"></i> {$_L['Recurring']}</span>*}
                        {*{/if}*}
                    {*</td>*}
                    <td class="text-right">
                        <a target="_blank" href="{$_url}client/iview/{$ds['id']}/token_{$ds['vtoken']}/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {$_L['View']}</a>
                        <a href="{$_url}client/ipdf/{$ds['id']}/token_{$ds['vtoken']}/dl/" class="btn btn-primary btn-xs"><i class="fa fa-file-pdf-o"></i> {$_L['Download']}</a>
                        <a target="_blank" href="{$_url}iview/print/{$ds['id']}/token_{$ds['vtoken']}/" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> {$_L['Print']}</a>

                    </td>
                </tr>

                {foreachelse}

                <tr>
                    <td colspan="8">
                        You do not have any Invoice.
                    </td>
                </tr>

            {/foreach}

            </tbody>



        </table>

    </div>
</div>
{include file="sections/footer.tpl"}