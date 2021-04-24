{include file="sections/header.tpl"}
<div class="ibox float-e-margins">
    <div class="ibox-title">
        <h5><h5>{$_L['Total']} : {$total_quotes}</h5></h5>
    </div>
    <div class="ibox-content">

        <table class="table table-bordered table-hover sys_table">
            <thead>
            <tr>
                <th>#</th>
                <th>{$_L['Account']}</th>
                <th width="30%">{$_L['Subject']}</th>
                <th>{$_L['Amount']}</th>
                <th>{$_L['Date Created']}</th>
                <th>{$_L['Expiry Date']}</th>
                {*<th>{$_L['Stage']}</th>*}

                <th class="text-right">{$_L['Manage']}</th>
            </tr>
            </thead>
            <tbody>

            {foreach $d as $ds}
                <tr>
                    <td><a href="{$_url}quotes/view/{$ds['id']}/">{$ds['id']}</a> </td>
                    <td><a href="{$_url}contacts/view/{$ds['userid']}/">{$ds['account']}</a> </td>
                    <td><a href="{$_url}quotes/view/{$ds['id']}/">{$ds['subject']}</a> </td>
                    <td class="amount">{$ds['total']}</td>
                    <td>{date( $_c['df'], strtotime($ds['datecreated']))}</td>
                    <td>{date( $_c['df'], strtotime($ds['validuntil']))}</td>
                    {*<td>*}
                        {*{if $ds['stage'] eq 'Dead'}*}
                            {*<span class="label label-default">{$_L['Dead']}</span>*}
                        {*{elseif $ds['stage'] eq 'Lost'}*}
                            {*<span class="label label-danger">{$_L['Lost']}</span>*}
                        {*{elseif $ds['stage'] eq 'Accepted'}*}
                            {*<span class="label label-success">{$_L['Accepted']}</span>*}
                        {*{elseif $ds['stage'] eq 'Draft'}*}
                            {*<span class="label label-info">{$_L['Draft']}</span>*}
                        {*{elseif $ds['stage'] eq 'Delivered'}*}
                            {*<span class="label label-info">{$_L['Delivered']}</span>*}
                        {*{else}*}
                            {*<span class="label label-info">{$ds['stage']}</span>*}
                        {*{/if}*}

                    {*</td>*}

                    <td class="text-right">
                        <a href="{$_url}quotes/view/{$ds['id']}/" class="btn btn-primary btn-xs"><i class="fa fa-check"></i> {$_L['View']}</a>

                        <a href="{$_url}client/qpdf/{$ds['id']}/token_{$ds['vtoken']}/dl/" class="btn btn-primary btn-xs" ><i class="fa fa-file-pdf-o"></i> {$_L['Download']}</a>
                        <a href="{$_url}client/qpdf/{$ds['id']}/token_{$ds['vtoken']}/" target="_blank" class="btn btn-primary btn-xs"><i class="fa fa-print"></i> {$_L['Print']}</a>
                    </td>
                </tr>

                {foreachelse}

                <tr>
                    <td colspan="7">
                        You do not have any Quote.
                    </td>
                </tr>

            {/foreach}

            </tbody>
        </table>

    </div>
</div>
{include file="sections/footer.tpl"}