<div class="row">
  <!-- MESSENGER -->
  <div class="col-md-4">
    <div class="box " id="messenger">
      <div class="box-body">

        <div class="table-responsive">


          <div class="card">
            <!--  -->
            <div class="container">
              <img src="<?php echo site_url("assets/admin/no_image.jpg"); ?>" alt="Avatar" style="width:50%" />
              <h3><b><?php echo $students[0]->student_name; ?></b></h3>
              <h4><?php echo $students[0]->father_name; ?></h4>
              <p>Gender: <?php echo ucwords($students[0]->gender); ?></p>
              <p>Address: <?php echo $students[0]->address; ?></p>
              <p>Contact: <?php echo $students[0]->mobile_no; ?> - <?php echo $students[0]->phone_no; ?></p>
              <p>Class: <?php echo $students[0]->class; ?></p>
              <p>Institute: <?php echo $students[0]->institute; ?></p>
              <?php if ($students[0]->institute == 'Yes') { ?>
                <p><?php echo $students[0]->scholarship_name; ?></p>
              <?php } ?>

            </div>
          </div>
          <style>
            .card {
              /* Add shadows to create the "card" effect */
              box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
              transition: 0.3s;
            }

            /* On mouse-over, add a deeper shadow */
            .card:hover {
              box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
            }

            /* Add some padding inside the card container */
            .container {
              padding: 2px 16px;
            }
          </style>






        </div>


      </div>

    </div>
  </div>
  <div class="col-md-6">

    <div class="table-responsive">
      <?php foreach ($student_courses_installments as $student_courses_installment) {
      ?>
        <div style="display: none;">
          <table style="width: 50%;" id="installment_<?php echo $student_courses_installment->course_installment_no; ?>">
            <tr>
              <td><img src="<?php echo site_url("assets/sowca.png"); ?>" width="50" /></td>
              <td style="text-align: center;">
                <h4>Shaheed Osama Warraich Academy,</h4>
                <h4>Chitral (SOWCA)</h4>
              </td>
              <td><img src="<?php echo site_url("assets/dc_logo.png"); ?>" width="50" /></td>
            </tr>
            <tr>
              <td colspan="3">
                <span class="pull-left">Receipt No:____________________</span>
                <span class="pull-right">Dated:____________________</span>
              </td>
            </tr>

            <tr>
              <td colspan="3">
                <table class="table table-bordered">
                  <tr>
                    <td>

                      <span class="pull-left">Student's Name:
                        <strong style="text-decoration-line: underline;"><?php echo $students[0]->student_name; ?></strong> </span>
                      <span class="pull-right">Father's Name:
                        <strong style="text-decoration-line: underline;"><?php echo $students[0]->father_name; ?></strong> </span>
                    </td>
                  </tr>
                  <tr>
                    <td><span class="pull-left">Month: <strong style="text-decoration-line: underline;">Installment-<?php echo $student_courses_installment->course_installment_no; ?></strong></span>
                      <span class="pull-right">Class: <strong style="text-decoration-line: underline;"> 11th </strong></span>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

            <tr>
              <td colspan="3">

                <table class="table table-bordered">

                  <tr>
                    <td>Course Name</d>
                    <td>Course Fee</d>
                    <td>Discount</d>
                    <td>Total</d>
                  </tr>

                  <?php foreach ($student_courses_installment->installment as $s_c_installment) {  ?>

                    <tr>
                      <td><?php echo $s_c_installment->course_name; ?></d>
                      <td><?php echo $s_c_installment->course_fee_total; ?></d>
                      <td> <?php echo $s_c_installment->course_fee_discount; ?> </td>
                      <td><?php echo $s_c_installment->course_fee_total - $s_c_installment->course_fee_discount;  ?></d>
                    </tr>

                  <?php } ?>
                  <tr>
                    <td><strong class="pull-right">Total</strong></td>
                    <td><strong>
                        <?php
                        $query = "SELECT SUM(`course_fee_total`) as `total`, SUM(`course_fee_discount`) as `total_discount` 
                                        FROM `session_student_fees`
                                        WHERE `student_id` = '" . $s_c_installment->student_id . "'
                                        AND `session_id` = '" . $s_c_installment->session_id . "'
                                        AND `course_installment_no` = '" . $s_c_installment->course_installment_no . "';";
                        $result =  $this->db->query($query)->result()[0];
                        echo $result->total;
                        ?>
                      </strong></td>
                    <td><strong><?php echo $result->total_discount;  ?></strong></td>
                    <td><strong><?php echo $result->total - $result->total_discount;  ?></strong></td>
                  </tr>

                </table>

              </td>
            </tr>

            <tr>
              <td colspan="3">
                <table class="table table-bordered">
                  <tr>
                    <td style="width: 50%; height: 89px; vertical-align:middle;"><strong>Remarks: ___________________</strong></td>
                    <td style="text-align: center; vertical-align:middle;"><strong> Signature & Stamp</strong></td>
                  </tr>
                </table>
              </td>
            </tr>

          </table>
        </div>




        <form method="post" action="<?php echo site_url(ADMIN_DIR . "home/add_payment/$student_courses_installment->course_installment_no"); ?>">
          <input type="hidden" name="student_id" value="<?php echo $students[0]->student_id; ?>" />
          <table class="table table-bordered">
            <h4>Installment <?php echo $student_courses_installment->course_installment_no; ?></h4>
            <tr>
              <td>Course Name</d>
              <td>Course Fee</d>
              <td>Discount</d>
              <td>Total</d>
            </tr>

            <?php foreach ($student_courses_installment->installment as $s_c_installment) {
              $status = false;
            ?>

              <tr>
                <td><?php echo $s_c_installment->course_name; ?></d>
                <td id="<?php echo $s_c_installment->session_student_fee_id; ?>_fee"><?php echo $s_c_installment->course_fee_total; ?></d>
                <td>
                  <?php if ($s_c_installment->status == 0) {
                    $status = true;
                  ?>
                    <input class="<?php echo  $s_c_installment->course_installment_no; ?>_discount" onkeyup="update_total('<?php echo $s_c_installment->session_student_fee_id; ?>', '<?php echo  $s_c_installment->course_installment_no; ?>')" id="<?php echo $s_c_installment->session_student_fee_id; ?>_discount" style="width: 100px;" type="number" max="<?php echo $s_c_installment->course_fee_total; ?>" name="discount[<?php echo $s_c_installment->session_student_fee_id; ?>]" value="<?php echo $s_c_installment->course_fee_discount; ?>" /></d>
                  <?php } else { ?>
                    <?php echo $s_c_installment->course_fee_discount; ?>
                  <?php } ?>
                <td id="<?php echo $s_c_installment->session_student_fee_id; ?>_total"><?php echo $s_c_installment->course_fee_total - $s_c_installment->course_fee_discount;  ?></d>
              </tr>

            <?php } ?>
            <tr>
              <td><strong>Total</strong></td>
              <td><strong id="<?php echo $s_c_installment->course_installment_no; ?>_total_fee">
                  <?php
                  $query = "SELECT SUM(`course_fee_total`) as `total`, SUM(`course_fee_discount`) as `total_discount` 
                                        FROM `session_student_fees`
                                        WHERE `student_id` = '" . $s_c_installment->student_id . "'
                                        AND `session_id` = '" . $s_c_installment->session_id . "'
                                        AND `course_installment_no` = '" . $s_c_installment->course_installment_no . "';";
                  $result =  $this->db->query($query)->result()[0];
                  echo $result->total;
                  ?>
                </strong></td>
              <td><strong id="<?php echo $s_c_installment->course_installment_no; ?>_total_discount"><?php echo $result->total_discount;  ?></strong></td>
              <td><strong id="<?php echo $s_c_installment->course_installment_no; ?>_total_total"><?php echo $result->total - $result->total_discount;  ?></strong></td>
            </tr>
            <tr>
              <td colspan="5">
                <?php if ($status) { ?>

                  <input type="submit" name="add_fees" value="Add Payment" />
                <?php } else { ?>
                  <input type="Button" name="print" onclick="printContent('installment_<?php echo $student_courses_installment->course_installment_no; ?>');" value="Print Receipt" />
                <?php  } ?>

              </td>
            </tr>
          </table>
        </form>

      <?php } ?>

    </div>

  </div>
  <!-- /MESSENGER -->
</div>




<script>
  function update_total(session_student_fee_id, installment) {

    var fee = parseInt($('#' + session_student_fee_id + '_fee').html());
    var discount = parseInt($('#' + session_student_fee_id + '_discount').val());
    var new_value = fee - discount;
    $('#' + session_student_fee_id + '_total').html(fee - discount);

    var discount_values = $("." + installment + "_discount");
    var total_discount = 0;
    for (var i = 0; i < discount_values.length; i++) {
      total_discount = total_discount + parseInt($(discount_values[i]).val());
    }

    $('#' + installment + '_total_discount').html(total_discount);
    var total_fee = parseInt($('#' + installment + '_total_fee').html());
    $('#' + installment + '_total_total').html(total_fee - total_discount);
  }

function printContent(el){
var restorepage = $('body').html();
var printcontent = $('#' + el).clone();
$('body').empty().html(printcontent);
window.print();
$('body').html(restorepage);
}

</script>