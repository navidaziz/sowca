<div class="row">
    <!-- MESSENGER -->
    <div class="col-md-4">
        <div class="box border blue" id="messenger">
            <div class="box-body">

                <div class="table-responsive">

                    <table class="table">
                        <thead>

                        </thead>
                        <tbody>
                            <?php foreach ($students as $student) : ?>


                                <tr>
                                    <th><?php echo $this->lang->line('student_name'); ?></th>
                                    <td>
                                        <?php echo $student->student_name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('father_name'); ?></th>
                                    <td>
                                        <?php echo $student->father_name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('gender'); ?></th>
                                    <td>
                                        <?php echo $student->gender; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('address'); ?></th>
                                    <td>
                                        <?php echo $student->address; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('mobile_no'); ?></th>
                                    <td>
                                        <?php echo $student->mobile_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('phone_no'); ?></th>
                                    <td>
                                        <?php echo $student->phone_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('class'); ?></th>
                                    <td>
                                        <?php echo $student->class; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('institute'); ?></th>
                                    <td>
                                        <?php echo $student->institute; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('on_scholarship'); ?></th>
                                    <td>
                                        <?php echo $student->on_scholarship; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th><?php echo $this->lang->line('transport'); ?></th>
                                    <td>
                                        <?php echo $student->transport; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('scholarship_name'); ?></th>
                                    <td>
                                        <?php echo $student->scholarship_name; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?php echo $this->lang->line('Status'); ?></th>
                                    <td>
                                        <?php echo status($student->status); ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>




                </div>


            </div>

        </div>
    </div>
    <div class="col-md-6">

        <div class="table-responsive">
            <?php $query = "SELECT `session_name` FROM `sessions` WHERE `sessions`.`status` = '1'";
            $session_name = $this->db->query($query)->result()[0]->session_name; ?>
            <h3> Session: <?php echo ucwords($session_name);  ?> Courses / Fees</h3>
            <form method="post" action="<?php echo site_url(ADMIN_DIR . "home/admit_student"); ?>">
                <input type="hidden" name="student_id" value="<?php echo $students[0]->student_id; ?>" />
                <?php if ($session_courses) { ?>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Name</th>
                                <th>Monthly Fee</th>
                                <th>Installments</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            foreach ($session_courses as $class_name => $classes) : ?>

                                <tr>

                                    <?php if ($class_name != 0 or 1 == 1) { ?>
                                        <td colspan="6"><?php if ($class_name != 0 or 1 == 1) {
                                                            echo $class_name;
                                                        } ?></td>
                                </tr>
                            <?php } ?>

                            <?php foreach ($classes['session_courses'] as $session_course) : ?>

                                <tr>
                                    <td><input <?php if (strtolower($session_course->course_name) == 'transport') { ?> onclick="set_transport()" id="tranport_cb" <?php } ?> type="checkbox" name="session_course_id[]" value="<?php echo $session_course->session_course_id; ?>" /></td>
                                    <td title="<?php
                                                $query = "SELECT `teacher_name` FROM `teachers` WHERE `teacher_id` = '" . $session_course->teacher_id . "'";
                                                $result = $this->db->query($query)->result();
                                                if ($result) {
                                                    echo $result[0]->teacher_name;
                                                }

                                                ?>"><?php echo $session_course->course_name; ?>

                                    </td>
                                    <td>
                                        <?php if (strtolower($session_course->course_name) == 'transport') { ?>
                                            <input style="width: 100px;" type="number" name="transport_fee" id="transport_fee" value="" />
                                        <?php } else { ?>
                                            <?php echo $session_course->course_fee; ?>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo $session_course->monthly_installment; ?></td>


                                </tr>
                        <?php endforeach;
                            endforeach;
                        ?>
                        <tr>
                            <td colspan="4" style="text-align: center;"><input type="submit" name="admint_student" value="Admint Student" class="btn btn-danger" /></td>
                        </tr>
                        </tbody>

                    </table>
                <?php } else { ?>
                    <h3 style="text-align: center;">Session Not Define.</h3>
                <?php } ?>
            </form>

        </div>

    </div>
    <!-- /MESSENGER -->
</div>

<script>
    function set_transport() {
        if ($('#tranport_cb').is(":checked")) {
            $("#transport_fee").prop('required', true);
        } else {
            $("#transport_fee").prop('required', false);
        }
    }
</script>