<!-- Modal Refund -->
<div class="modal fade bs-example-modal-sm3" tabindex="-1" role="dialog" aria-hidden="true" id="modalRefund">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
          </button>
          <h4 class="modal-title" id="myModalLabel2">Refund Confirmation</h4>
      </div>

      <div class="modal-body">
      <div class="form-group">
        <p>Are you sure you want to Refund this data?</p>
      </div>
        </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <!-- <a href="controller/refund_invoice.php?invoice_id=<?php echo $row["invoice_id"]?>" class="btn btn-danger btn-xs"><i class="fa fa-pencil"></i> Refund </a> -->
        <!-- <a id="ref" href="controller/refund_invoice.php" class="btn btn-danger" ><i class="fa fa-pencil"></i> Refund </a> -->
        <button type="submit" class="btn btn-danger refunddata" data-dismiss="modal" >Refund</button>
      </div>

    </div>
  </div>
</div>
<!-- Modal Refund
