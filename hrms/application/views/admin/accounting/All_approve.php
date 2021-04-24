<?php
/*
* Payees - Accounting View
*/
$session = $this->session->userdata('username');
?>


  <div class="col-md-8">
    <div class="card">
      <h6 class="card-header">
          Approve Expanse list
      </h6>
      <div class="card-datatable table-responsive">
        <table  class="datatables-demo table table-striped table-bordered"  class="grey lighten-2" id="xin_table">
          <thead>
            <tr  align="center">

                <th>Company Name</th>
                <th>Employee</th>
                <th>Amount</th>

                <th>Status</th>

            </tr>
          </thead>
            <tbody>
            <?php foreach ($approve_expense_list as $value){?>
            <tr>

                <td><?=$value['name']?></td>
                <td><?=$value['first_name']?></td>
                <td><?=$value['amount']?></td>

                <td><?=$value['purchase_date']?> approved</td>
            </tr>
            <?php }?>
            </tbody>
        </table>
      </div>
    </div>
  </div>
